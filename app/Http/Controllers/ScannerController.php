<?php

namespace App\Http\Controllers;

use App\Models\QRCode;
use App\Models\ScanActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScannerController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'action' => 'required|string',
            'notes' => 'nullable|string',
            'location' => 'nullable|string',
            'room' => 'nullable|string',
            'sub_location' => 'nullable|string',
        ]);

        $qrCode = $request->qr_code;
        $scannable = null;

        // Check if it's an asset QR code
        $scannable = \App\Models\Asset::where('qr_code', $qrCode)->first();

        // If not found, check if it's an instrument set QR code
        if (!$scannable) {
            $scannable = \App\Models\InstrumentSet::where('qr_code', $qrCode)->with('assets')->first();
        }

        if (!$scannable) {
            return response()->json(['message' => 'QR Code not found or invalid'], 404);
        }

        $scanData = [
            'user_id' => auth()->id(),
            'action' => $request->action,
            'notes' => $request->notes,
            'location' => $request->location,
            'room' => $request->room,
            'sub_location' => $request->sub_location,
            'scanned_at' => now(),
        ];

        // Create the main scan activity for the set or asset
        $mainScanActivity = $scannable->scanActivities()->create($scanData);

        // Update the status based on the action
        $statusMap = [
            'Start Washing' => \App\Models\Asset::STATUS_WASHING,
            'Start Sterilizing' => \App\Models\Asset::STATUS_STERILIZING,
            'Mark as Ready' => \App\Models\Asset::STATUS_READY,
            'Mark as In Use' => \App\Models\Asset::STATUS_IN_USE,
            'Start Maintenance' => \App\Models\Asset::STATUS_MAINTENANCE,
            'Start Distribution' => \App\Models\Asset::STATUS_IN_TRANSIT,
            'Start Sterile Distribution' => \App\Models\Asset::STATUS_IN_TRANSIT_STERILE,
            'Start Dirty Distribution' => \App\Models\Asset::STATUS_IN_TRANSIT_DIRTY,
            'Mark as Received' => \App\Models\Asset::STATUS_IN_USE,
            'Mark as Received (Sterile)' => \App\Models\Asset::STATUS_IN_USE,
            'Mark as Received (Dirty)' => \App\Models\Asset::STATUS_IN_PROCESS,
            'Start Return' => \App\Models\Asset::STATUS_RETURNING,
            'Mark as Returned' => \App\Models\Asset::STATUS_RETURNED,
            'Complete Sterilization' => \App\Models\Asset::STATUS_READY,
        ];

        if (isset($statusMap[$request->action])) {
            $newStatus = $statusMap[$request->action];

            // Handle stock calculations for distribution actions
            if ($request->action === 'Start Sterile Distribution') {
                // Validate sufficient sterile stock
                if ($scannable->jumlah_steril < 1) {
                    return response()->json(['message' => 'Insufficient sterile stock for distribution'], 400);
                }
                // Decrease sterile stock
                $scannable->decrement('jumlah_steril');
            } elseif ($request->action === 'Start Dirty Distribution') {
                // Validate sufficient dirty stock
                if ($scannable->jumlah_kotor < 1) {
                    return response()->json(['message' => 'Insufficient dirty stock for distribution'], 400);
                }
                // Decrease dirty stock and increase CSSD process stock
                $scannable->decrement('jumlah_kotor');
                $scannable->increment('jumlah_proses_cssd');
            } elseif ($request->action === 'Mark as Received (Dirty)') {
                // When dirty items are received by CSSD, they are now in process
                // This is handled by status change only
            } elseif ($request->action === 'Complete Sterilization') {
                // When sterilization is complete, move from process to sterile stock
                if ($scannable->jumlah_proses_cssd < 1) {
                    return response()->json(['message' => 'No items in CSSD process to complete sterilization'], 400);
                }
                $scannable->decrement('jumlah_proses_cssd');
                $scannable->increment('jumlah_steril');
            }

            $scannable->update(['status' => $newStatus]);
        }

        Log::info('Item scanned', [
            'scannable_id' => $scannable->id,
            'scannable_type' => get_class($scannable),
            'user_id' => auth()->id(),
            'action' => $request->action,
        ]);

        // If it's an instrument set, also log an activity for each asset within it
        if ($scannable instanceof \App\Models\InstrumentSet) {
            if (isset($newStatus)) {
                $scannable->assets()->update(['status' => $newStatus]);
            }

            // Handle stock calculations for instrument sets
            if ($request->action === 'Start Sterile Distribution') {
                // For instrument sets, we need to handle stock for each asset
                foreach ($scannable->assets as $asset) {
                    if ($asset->jumlah_steril < 1) {
                        return response()->json(['message' => 'Insufficient sterile stock for asset: ' . $asset->name], 400);
                    }
                    $asset->decrement('jumlah_steril');
                }
            } elseif ($request->action === 'Start Dirty Distribution') {
                foreach ($scannable->assets as $asset) {
                    if ($asset->jumlah_kotor < 1) {
                        return response()->json(['message' => 'Insufficient dirty stock for asset: ' . $asset->name], 400);
                    }
                    $asset->decrement('jumlah_kotor');
                    $asset->increment('jumlah_proses_cssd');
                }
            } elseif ($request->action === 'Complete Sterilization') {
                foreach ($scannable->assets as $asset) {
                    if ($asset->jumlah_proses_cssd < 1) {
                        return response()->json(['message' => 'No items in CSSD process for asset: ' . $asset->name], 400);
                    }
                    $asset->decrement('jumlah_proses_cssd');
                    $asset->increment('jumlah_steril');
                }
            }

            foreach ($scannable->assets as $asset) {
                $asset->scanActivities()->create($scanData);
                Log::info('Asset scanned as part of a set', [
                    'asset_id' => $asset->id,
                    'instrument_set_id' => $scannable->id,
                    'user_id' => auth()->id(),
                    'action' => $request->action,
                ]);
            }
        }

        return response()->json([
            'message' => 'Scan recorded successfully',
            'scan_activity' => $mainScanActivity->load('scannable', 'user'),
        ]);
    }

    public function getScanHistory(Request $request)
    {
        $query = ScanActivity::with('qrCode', 'user');

        if ($request->has('qr_code')) {
            $query->whereHas('qrCode', function ($q) use ($request) {
                $q->where('code', $request->qr_code);
            });
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $scanActivities = $query->orderBy('scanned_at', 'desc')->paginate(20);

        return response()->json($scanActivities);
    }
}
