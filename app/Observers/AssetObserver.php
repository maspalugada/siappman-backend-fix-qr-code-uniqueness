<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\QRCode;

class AssetObserver
{
    /**
     * Handle the Asset "created" event.
     */
    public function created(Asset $asset): void
    {
        $this->generateQrCodes($asset);
    }

    /**
     * Handle the Asset "updated" event.
     */
    public function updated(Asset $asset): void
    {
        // Regenerate QR codes if jumlah changed
        if ($asset->wasChanged('jumlah')) {
            $asset->qrCodes()->delete(); // Delete existing QR codes
            $this->generateQrCodes($asset);
        }
    }

    /**
     * Handle the Asset "deleted" event.
     */
    public function deleted(Asset $asset): void
    {
        // QR codes will be deleted automatically due to cascade delete
    }

    /**
     * Handle the Asset "restored" event.
     */
    public function restored(Asset $asset): void
    {
        // Regenerate QR codes when asset is restored
        $this->generateQrCodes($asset);
    }

    /**
     * Handle the Asset "force deleted" event.
     */
    public function forceDeleted(Asset $asset): void
    {
        // QR codes will be deleted automatically due to cascade delete
    }

    /**
     * Generate QR codes for the asset
     */
    private function generateQrCodes(Asset $asset): void
    {
        $jumlah = (int) $asset->jumlah;
        $unitCode = $asset->unit_code ?: 'DEFAULT';

        for ($i = 1; $i <= $jumlah; $i++) {
            $qrCodeString = sprintf('%s-%06d-%02d', strtoupper($unitCode), $asset->id, $i);

            // Generate SVG QR code
            $qrImageSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qrCodeString);
            $qrImageBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrImageSvg);

            QRCode::create([
                'asset_id' => $asset->id,
                'qr_code' => $qrCodeString,
                'qr_image' => $qrImageBase64,
                'sequence_number' => $i,
                'status' => QRCode::STATUS_ACTIVE,
            ]);
        }
    }
}
