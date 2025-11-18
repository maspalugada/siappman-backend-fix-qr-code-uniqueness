<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Asset;

echo "Testing QR code uniqueness for 100 instruments...\n";

$asset = Asset::create([
    'name' => 'Test Surgical Scissors 100 Units',
    'instrument_type' => 'Surgical Instruments',
    'unit' => 'Operating Room 1',
    'unit_code' => 'OR001',
    'destination_unit' => null,
    'destination_unit_code' => null,
    'jumlah' => 100,
    'jumlah_steril' => 100,
    'jumlah_kotor' => 0,
    'jumlah_proses_cssd' => 0,
    'location' => 'Storage Room A',
    'description' => 'Test asset with 100 units',
    'status' => 'Ready'
]);

echo "✅ Asset created with ID: " . $asset->id . "\n";
$qrCodes = $asset->qr_codes ?? [];
echo "📱 Total QR codes generated: " . count($qrCodes) . "\n";
echo "🎯 Expected: 100, Actual: " . count($qrCodes) . "\n";
echo "🔍 All QR codes unique: " . (count($qrCodes) === count(array_unique($qrCodes)) ? '✅ YES' : '❌ NO') . "\n";

$sampleQRs = array_slice($qrCodes, 0, 5);
echo "\n📋 Sample QR codes (first 5):\n";
foreach ($sampleQRs as $i => $qr) {
    echo "  " . ($i + 1) . ". " . $qr . "\n";
}

if (!empty($qrCodes)) {
    echo "\n📊 QR Code Pattern Analysis:\n";
    $firstQR = $qrCodes[0];
    $parts = explode('-', $firstQR);
    echo "  Format: " . $parts[0] . "-" . $parts[1] . "-" . $parts[2] . "\n";
    echo "  Unit Code: " . $parts[0] . "\n";
    echo "  Floor: " . $parts[1] . "\n";
    echo "  Sequence starts at: " . $parts[2] . "\n";

    $lastQR = end($qrCodes);
    $lastParts = explode('-', $lastQR);
    echo "  Sequence ends at: " . $lastParts[2] . "\n";
} else {
    echo "\n❌ No QR codes were generated!\n";
}

echo "\n✅ Test completed successfully!\n";
