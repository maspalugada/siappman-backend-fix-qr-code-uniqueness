<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asset::query();

        // Enhanced search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('instrument_type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('qr_code', 'like', '%' . $searchTerm . '%')
                  ->orWhere('unit', 'like', '%' . $searchTerm . '%');
            });
        }

        // Add status filtering
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Add location filtering
        if ($request->has('location') && $request->location !== '') {
            $query->where('location', $request->location);
        }

        // Add unit filtering
        if ($request->has('unit') && $request->unit !== '') {
            $query->where('unit', $request->unit);
        }

        // Add instrument type filtering
        if ($request->has('instrument_type') && $request->instrument_type !== '') {
            $query->where('instrument_type', $request->instrument_type);
        }

        // Add date range filtering
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Add sorting functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Validate sort parameters for security
        $allowedSortFields = ['name', 'instrument_type', 'unit', 'location', 'status', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $assets = $query->paginate(10)->appends($request->query());
        return view('dashboard.assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $instrumentTypes = \App\Models\InstrumentType::all();
        $units = \App\Models\Unit::all();
        $locations = \App\Models\Location::all();

        // Template data for quick asset creation
        $templates = [
            'Surgical Scissors' => [
                'name' => 'Surgical Scissors',
                'instrument_type' => 'Cutting Instrument',
                'jumlah' => 5,
                'jumlah_steril' => 5,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'specifications' => ['Material: Stainless Steel', 'Size: 15cm']
            ],
            'Surgical Forceps' => [
                'name' => 'Surgical Forceps',
                'instrument_type' => 'Grasping Instrument',
                'jumlah' => 3,
                'jumlah_steril' => 3,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'specifications' => ['Type: Toothed', 'Size: 20cm']
            ],
            'Surgical Needle Holder' => [
                'name' => 'Surgical Needle Holder',
                'instrument_type' => 'Holding Instrument',
                'jumlah' => 2,
                'jumlah_steril' => 2,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'specifications' => ['Type: Mayo-Hegar', 'Size: 16cm']
            ],
            'Pressure Gauge' => [
                'name' => 'Pressure Gauge',
                'instrument_type' => 'Measuring Instrument',
                'jumlah' => 1,
                'jumlah_steril' => 1,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'specifications' => ['Range: 0-300 psi', 'Accuracy: ±1%']
            ],
            'Temperature Sensor' => [
                'name' => 'Temperature Sensor',
                'instrument_type' => 'Monitoring Instrument',
                'jumlah' => 1,
                'jumlah_steril' => 1,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'specifications' => ['Range: -50°C to 200°C', 'Type: RTD']
            ]
        ];

        $selectedTemplate = $request->get('template');
        $templateData = isset($templates[$selectedTemplate]) ? $templates[$selectedTemplate] : [];

        return view('dashboard.assets.create', compact('instrumentTypes', 'units', 'locations', 'templates', 'templateData'));
    }

    /**
     * Duplicate an existing asset.
     */
    public function duplicate(Asset $asset)
    {
        $instrumentTypes = \App\Models\InstrumentType::all();
        $units = \App\Models\Unit::all();
        $locations = \App\Models\Location::all();

        // Prepare data for duplication with slight modifications
        $duplicateData = $asset->toArray();
        unset($duplicateData['id'], $duplicateData['created_at'], $duplicateData['updated_at']);
        $duplicateData['name'] = $asset->name . ' (Copy)';
        $duplicateData['qr_code'] = null; // Will be generated on save

        return view('dashboard.assets.create', compact('instrumentTypes', 'units', 'locations', 'duplicateData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'instrument_type' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'destination_unit' => 'nullable|string|max:255',
            'destination_unit_code' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'jumlah_steril' => 'required|integer|min:0',
            'jumlah_kotor' => 'required|integer|min:0',
            'jumlah_proses_cssd' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
        ]);

        $validator->after(function ($validator) use ($request) {
            $totalStock = $request->jumlah_steril + $request->jumlah_kotor + $request->jumlah_proses_cssd;
            if ($totalStock !== $request->jumlah) {
                $validator->errors()->add('stock_total', 'Total distribusi stok harus sama dengan jumlah total instrumen.');
            }

            // Additional validation for non-negative values
            if ($request->jumlah_steril < 0 || $request->jumlah_kotor < 0 || $request->jumlah_proses_cssd < 0) {
                $validator->errors()->add('stock_negative', 'Jumlah stok tidak boleh negatif.');
            }

            // Validate that stock values don't exceed total jumlah
            if ($request->jumlah_steril > $request->jumlah || $request->jumlah_kotor > $request->jumlah || $request->jumlah_proses_cssd > $request->jumlah) {
                $validator->errors()->add('stock_exceed', 'Jumlah stok per kategori tidak boleh melebihi jumlah total.');
            }
        });

        // Check for duplicate asset (same name, instrument_type, unit, location)
        $existingAsset = Asset::where('name', $request->name)
            ->where('instrument_type', $request->instrument_type)
            ->where('unit', $request->unit)
            ->where('destination_unit', $request->destination_unit)
            ->where('location', $request->location)
            ->first();

        if ($existingAsset) {
            return back()->withErrors(['duplicate' => 'Alat Instrumen Sudah Tersedia'])->withInput();
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create and save asset - QR codes will be generated automatically by the observer
        $asset = new Asset();
        $asset->name = $request->name;
        $asset->instrument_type = $request->instrument_type;
        $asset->unit = $request->unit;
        $asset->unit_code = $request->unit_code;
        $asset->destination_unit = $request->destination_unit;
        $asset->destination_unit_code = $request->destination_unit_code;
        $asset->jumlah = $request->jumlah;
        $asset->jumlah_steril = $request->jumlah_steril;
        $asset->jumlah_kotor = $request->jumlah_kotor;
        $asset->jumlah_proses_cssd = $request->jumlah_proses_cssd;
        $asset->location = $request->location;
        $asset->description = $request->description;
        $asset->specifications = $request->specifications;
        $asset->status = Asset::STATUS_READY;
        $asset->save(); // QR codes will be generated by the AssetObserver

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        // Get related assets (same unit or location)
        $relatedAssets = Asset::where(function($query) use ($asset) {
            $query->where('unit', $asset->unit)
                  ->orWhere('location', $asset->location);
        })
        ->where('id', '!=', $asset->id)
        ->limit(5)
        ->get();

        // Get scan history for this asset
        $scanHistory = $asset->scanActivities()
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.assets.show', compact('asset', 'relatedAssets', 'scanHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $instrumentTypes = \App\Models\InstrumentType::all();
        $units = \App\Models\Unit::all();
        $locations = \App\Models\Location::all();

        return view('dashboard.assets.edit', compact('asset', 'instrumentTypes', 'units', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'instrument_type' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'unit_code' => 'required|string|max:255',
            'destination_unit' => 'nullable|string|max:255',
            'destination_unit_code' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'jumlah_steril' => 'required|integer|min:0',
            'jumlah_kotor' => 'required|integer|min:0',
            'jumlah_proses_cssd' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'status' => 'required|in:Ready,Washing,Sterilizing,In Use,Maintenance,In Transit,In Transit (Sterile),In Transit (Dirty),In Process,Returning,Returned',
        ]);

        $validator->after(function ($validator) use ($request) {
            $totalStock = $request->jumlah_steril + $request->jumlah_kotor + $request->jumlah_proses_cssd;
            if ($totalStock !== $request->jumlah) {
                $validator->errors()->add('stock_total', 'Total distribusi stok harus sama dengan jumlah total instrumen.');
            }

            // Additional validation for non-negative values
            if ($request->jumlah_steril < 0 || $request->jumlah_kotor < 0 || $request->jumlah_proses_cssd < 0) {
                $validator->errors()->add('stock_negative', 'Jumlah stok tidak boleh negatif.');
            }

            // Validate that stock values don't exceed total jumlah
            if ($request->jumlah_steril > $request->jumlah || $request->jumlah_kotor > $request->jumlah || $request->jumlah_proses_cssd > $request->jumlah) {
                $validator->errors()->add('stock_exceed', 'Jumlah stok per kategori tidak boleh melebihi jumlah total.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $asset->update([
            'name' => $request->name,
            'instrument_type' => $request->instrument_type,
            'unit' => $request->unit,
            'unit_code' => $request->unit_code,
            'destination_unit' => $request->destination_unit,
            'destination_unit_code' => $request->destination_unit_code,
            'jumlah' => $request->jumlah,
            'jumlah_steril' => $request->jumlah_steril,
            'jumlah_kotor' => $request->jumlah_kotor,
            'jumlah_proses_cssd' => $request->jumlah_proses_cssd,
            'location' => $request->location,
            'description' => $request->description,
            'specifications' => $request->specifications,
            'status' => $request->status,
        ]);

        // If jumlah changed and QR codes count no longer matches, regenerate QR codes and images
        if (is_numeric($request->jumlah) && $asset->qr_codes && count($asset->qr_codes) !== (int)$request->jumlah) {
            $qrCodes = $this->generateAssetQrCodes($asset->unit_code, $asset->location, $asset->id, $asset->jumlah);
            $qrImages = $this->generateAssetQrImages($qrCodes);
            $asset->qr_code = $qrCodes[0] ?? $asset->qr_code;
            $asset->qr_codes = $qrCodes;
            $asset->qr_images = $qrImages;
            $asset->save();
        }

        return redirect()->route('dashboard.assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('dashboard.assets.index')->with('success', 'Asset deleted successfully.');
    }

    /**
     * Show bulk import form.
     */
    public function bulkImportForm()
    {
        return view('dashboard.assets.bulk-import');
    }

    /**
     * Process bulk import from CSV/Excel.
     */
    public function bulkImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        try {
            $data = [];
            if ($extension === 'csv') {
                $data = $this->parseCsv($file);
            } else {
                $data = $this->parseExcel($file);
            }

            $results = $this->processBulkImport($data);

            return redirect()->route('dashboard.assets.index')->with('success',
                "Bulk import completed. Success: {$results['success']}, Failed: {$results['failed']}"
            )->with('import_results', $results);

        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }

    /**
     * Download import template.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="asset_import_template.csv"',
        ];

        $templateData = [
            ['name', 'instrument_type', 'unit', 'unit_code', 'destination_unit', 'destination_unit_code', 'jumlah', 'jumlah_steril', 'jumlah_kotor', 'jumlah_proses_cssd', 'location', 'description', 'specifications'],
            ['Surgical Scissors', 'Cutting Instrument', 'CSSD, Lt B1', 'CSSD', 'IW BEDAH, Lt 6', 'IWB', '5', '5', '0', '0', 'Gedung VENTRICLE', 'High-quality surgical scissors', 'Material: Stainless Steel, Size: 15cm'],
            ['Surgical Forceps', 'Grasping Instrument', 'CSSD, Lt B1', 'CSSD', 'ICU DEWASA, Lt 8', 'ICUD', '3', '3', '0', '0', 'Gedung VENTRICLE', 'Precision forceps', 'Type: Toothed, Size: 20cm'],
        ];

        $callback = function() use ($templateData) {
            $file = fopen('php://output', 'w');
            foreach ($templateData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export assets to CSV/Excel.
     */
    public function export(Request $request)
    {
        $query = Asset::query();

        // Apply same filters as index
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('instrument_type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('qr_code', 'like', '%' . $searchTerm . '%')
                  ->orWhere('unit', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('location') && $request->location !== '') {
            $query->where('location', $request->location);
        }

        $assets = $query->get();

        $format = $request->get('format', 'csv');
        $filename = 'assets_export_' . date('Y-m-d_H-i-s');

        if ($format === 'excel') {
            return $this->exportExcel($assets, $filename);
        }

        return $this->exportCsv($assets, $filename);
    }

    /**
     * Parse CSV file.
     */
    private function parseCsv($file)
    {
        $data = [];
        $handle = fopen($file->getPathname(), 'r');

        // Skip header row
        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) >= 13) {
                $data[] = [
                    'name' => trim($row[0]),
                    'instrument_type' => trim($row[1]),
                    'unit' => trim($row[2]),
                    'unit_code' => trim($row[3]),
                    'destination_unit' => trim($row[4]) ?: null,
                    'destination_unit_code' => trim($row[5]) ?: null,
                    'jumlah' => (int) trim($row[6]),
                    'jumlah_steril' => (int) trim($row[7]),
                    'jumlah_kotor' => (int) trim($row[8]),
                    'jumlah_proses_cssd' => (int) trim($row[9]),
                    'location' => trim($row[10]),
                    'description' => trim($row[11]) ?: null,
                    'specifications' => trim($row[12]) ? array_map('trim', explode(',', trim($row[12]))) : [],
                ];
            }
        }

        fclose($handle);
        return $data;
    }

    /**
     * Parse Excel file.
     */
    private function parseExcel($file)
    {
        // For simplicity, we'll use a basic CSV-like parsing
        // In production, you'd want to use a proper Excel library like PhpSpreadsheet
        return $this->parseCsv($file);
    }

    /**
     * Process bulk import data.
     */
    private function processBulkImport($data)
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        foreach ($data as $index => $row) {
            try {
                // Validate required fields
                if (empty($row['name']) || empty($row['instrument_type']) || empty($row['unit']) ||
                    empty($row['unit_code']) || empty($row['jumlah']) || empty($row['location'])) {
                    throw new \Exception('Missing required fields');
                }

                // Check for duplicates (include location)
                $existingAsset = Asset::where('name', $row['name'])
                    ->where('instrument_type', $row['instrument_type'])
                    ->where('unit', $row['unit'])
                    ->where('destination_unit', $row['destination_unit'])
                    ->where('location', $row['location'])
                    ->first();

                if ($existingAsset) {
                    throw new \Exception('Asset already exists');
                }

                // Validate stock distribution
                $totalStock = $row['jumlah_steril'] + $row['jumlah_kotor'] + $row['jumlah_proses_cssd'];
                if ($totalStock !== $row['jumlah']) {
                    throw new \Exception('Stock distribution does not match total quantity');
                }

                // Create asset - QR codes will be generated automatically by the observer
                $asset = new Asset();
                $asset->fill($row);
                $asset->status = Asset::STATUS_READY;
                $asset->save(); // QR codes will be generated by the AssetObserver

                $results['success']++;

            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = [
                    'row' => $index + 2, // +2 because of 0-index and header
                    'name' => $row['name'] ?? 'Unknown',
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * Export to CSV.
     */
    private function exportCsv($assets, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];

        $callback = function() use ($assets) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'ID', 'Name', 'Instrument Type', 'Unit', 'Unit Code', 'Destination Unit',
                'Destination Unit Code', 'Jumlah', 'Jumlah Steril', 'Jumlah Kotor',
                'Jumlah Proses CSSD', 'Location', 'QR Code', 'Status', 'Description', 'Created At'
            ]);

            // Data rows
            foreach ($assets as $asset) {
                fputcsv($file, [
                    $asset->id,
                    $asset->name,
                    $asset->instrument_type,
                    $asset->unit,
                    $asset->unit_code,
                    $asset->destination_unit,
                    $asset->destination_unit_code,
                    $asset->jumlah,
                    $asset->jumlah_steril,
                    $asset->jumlah_kotor,
                    $asset->jumlah_proses_cssd,
                    $asset->location,
                    $asset->qr_code,
                    $asset->status,
                    $asset->description,
                    $asset->created_at ? $asset->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to Excel (simplified version).
     */
    private function exportExcel($assets, $filename)
    {
        // For now, return CSV with Excel headers
        // In production, use PhpSpreadsheet for proper Excel format
        return $this->exportCsv($assets, $filename);
    }

    /**
     * Generate QR code for the asset.
     */
    public function generateQr(Asset $asset)
    {
        // Generate QR code data
        $qrData = [
            'id' => $asset->id,
            'name' => $asset->name,
            'type' => $asset->instrument_type,
            'location' => $asset->location,
            'qr_code' => $asset->qr_code,
            'timestamp' => now()->toISOString()
        ];

        return response()->json([
            'qr_data' => $qrData,
            'qr_string' => json_encode($qrData)
        ]);
    }

    /**
     * Get asset data by QR code for n8n integration.
     */
    public function getByQrCode($qrCode)
    {
        // First try direct match on primary qr_code
        $asset = Asset::where('qr_code', $qrCode)->first();

        // If not found, try to find within qr_codes JSON array (assuming DB stored as JSON/text)
        if (!$asset) {
            $asset = Asset::whereJsonContains('qr_codes', $qrCode)->first();
        }

        if (!$asset) {
            return response()->json([
                'error' => 'Asset not found',
                'message' => 'No asset found with QR code: ' . $qrCode
            ], 404);
        }

        return response()->json([
            'id' => $asset->id,
            'name' => $asset->name,
            'instrument_type' => $asset->instrument_type,
            'unit' => $asset->unit,
            'unit_code' => $asset->unit_code,
            'destination_unit' => $asset->destination_unit,
            'destination_unit_code' => $asset->destination_unit_code,
            'jumlah' => $asset->jumlah,
            'location' => $asset->location,
            'qr_code' => $asset->qr_code,
            'status' => $asset->status,
            'description' => $asset->description,
            'specifications' => $asset->specifications,
            'created_at' => $asset->created_at,
            'updated_at' => $asset->updated_at
        ]);
    }

    /**
     * Generate QR code for asset based on unit code and asset ID.
     *
     * NOTE: We generate QR codes AFTER the asset is saved, using the asset ID to ensure uniqueness.
     */
    private function generateAssetQrCode($unitCode, $locationName, $assetId, $index)
    {
        // Format: UNIT-<assetId zero-padded 6>-<sequence zero-padded 2>
        // e.g., CSSD-000123-01
        return sprintf('%s-%06d-%02d', strtoupper($unitCode), $assetId, $index);
    }

    /**
     * Generate multiple unique QR codes for an asset based on jumlah.
     */
    private function generateAssetQrCodes($unitCode, $locationName, $assetId, $jumlah)
    {
        $qrCodes = [];

        for ($i = 1; $i <= (int)$jumlah; $i++) {
            $qrCodes[] = $this->generateAssetQrCode($unitCode, $locationName, $assetId, $i);
        }

        return $qrCodes;
    }

    /**
     * Generate QR code images as base64 encoded strings for an array of QR codes.
     */
    private function generateAssetQrImages($qrCodes)
    {
        $qrImages = [];

        foreach ($qrCodes as $qrCode) {
            // Generate SVG QR code using SimpleSoftwareIO QRCode
            $qrImageSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qrCode);

            // Convert SVG to base64 data URL
            $qrImages[] = 'data:image/svg+xml;base64,' . base64_encode($qrImageSvg);
        }

        return $qrImages;
    }


}
