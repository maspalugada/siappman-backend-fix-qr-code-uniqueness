<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InstrumentType;
use App\Models\Unit;
use App\Models\Location;

class ManageableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrumentTypes = [
            ['name' => 'Cutting Instrument'],
            ['name' => 'Grasping Instrument'],
            ['name' => 'Holding Instrument'],
            ['name' => 'Measuring Instrument'],
            ['name' => 'Monitoring Instrument'],
            ['name' => 'STEAM'],
            ['name' => 'EO'],
            ['name' => 'DTT'],
        ];

        foreach ($instrumentTypes as $type) {
            InstrumentType::create($type);
        }

        $units = [
            ['name' => 'CSSD, Lt B1', 'code' => 'CSSD'],
            ['name' => 'SUKAMAN EBONY, Lt 8', 'code' => 'EB'],
            ['name' => 'SUKAMAN SILVER, Lt 7', 'code' => 'SV'],
            ['name' => 'RAWAT ANAK, Lt 7', 'code' => 'RA'],
            ['name' => 'IW BEDAH, Lt 6', 'code' => 'IWB'],
            ['name' => 'IW MEDIKAL, Lt 6', 'code' => 'IWM'],
            ['name' => 'ICU DEWASA, Lt 8', 'code' => 'ICUD'],
            ['name' => 'ICVCU MERANTI, Lt 3', 'code' => 'MR'],
            ['name' => 'ICVCU CANOPUS, Lt 3', 'code' => 'CP'],
            ['name' => 'ICVCU ULIN, Lt 3', 'code' => 'UL'],
            ['name' => 'ICU ANAK, Lt 8', 'code' => 'ICUA'],
            ['name' => 'ICVCU PEDIATRIK, Lt 8', 'code' => 'ICPED'],
            ['name' => 'IW ANAK, Lt 6', 'code' => 'IWA'],
            ['name' => 'Lt 5, Lt 5', 'code' => 'LT5'],
            ['name' => 'Lt 4, Lt 4', 'code' => 'LT4'],
            ['name' => 'Lt 3, Lt 3', 'code' => 'LT3'],
            ['name' => 'UGD, Lt 1', 'code' => 'UGD'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }

        $locations = [
            ['name' => 'Gedung VENTRICLE', 'unit' => 'CSSD, LT B1', 'unit_code' => 'CSSD', 'floor' => 'B1'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'SUKAMAN EBONY, LT 8', 'unit_code' => 'EB', 'floor' => '8'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'SUKAMAN SILVER, LT 8', 'unit_code' => 'SV', 'floor' => '8'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'RAWAT ANAK, LT 7', 'unit_code' => 'RA', 'floor' => '7'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'IW BEDAH, LT 6', 'unit_code' => 'IWB', 'floor' => '6'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'IW MEDIKAL, LT 6', 'unit_code' => 'IWM', 'floor' => '6'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'ICU DEWASA, LT 4', 'unit_code' => 'ICUD', 'floor' => '4'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'ICVCU MERANTI, LT 3', 'unit_code' => 'MR', 'floor' => '3'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'ICVCU CANOPUS, LT 3', 'unit_code' => 'CP', 'floor' => '3'],
            ['name' => 'Gedung VENTRICLE', 'unit' => 'ICVCU ULIN, LT 3', 'unit_code' => 'UL', 'floor' => '3'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'ICU ANAK, LT 8', 'unit_code' => 'ICUA', 'floor' => '8'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'ICVCU PEDIATRIK, LT 6', 'unit_code' => 'ICPED', 'floor' => '6'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'IW ANAK, LT 6', 'unit_code' => 'IWA', 'floor' => '6'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'Lt 5, Lt 5', 'unit_code' => 'LT5', 'floor' => '5'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'Lt 4, Lt 4', 'unit_code' => 'LT4', 'floor' => '4'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'Lt 3, Lt 3', 'unit_code' => 'LT3', 'floor' => '3'],
            ['name' => 'Gedung PERAWATAN', 'unit' => 'UGD, LT 1', 'unit_code' => 'UGD', 'floor' => '1'],

        ];

        foreach ($locations as $location) {
            Location::create($location);
        }

        // Seed sample assets for demonstration
        $sampleAssets = [
            [
                'name' => 'Surgical Scissors',
                'instrument_type' => 'Cutting Instrument',
                'unit' => 'CSSD, Lt B1',
                'unit_code' => 'CSSD',
                'destination_unit' => 'IW BEDAH, Lt 6',
                'destination_unit_code' => 'IWB',
                'jumlah' => 5,
                'jumlah_steril' => 5,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'location' => 'Gedung VENTRICLE',
                'description' => 'High-quality surgical scissors for precision cutting',
                'specifications' => ['Material: Stainless Steel', 'Size: 15cm', 'Type: Curved'],
                'status' => 'Ready',
            ],
            [
                'name' => 'Surgical Forceps',
                'instrument_type' => 'Grasping Instrument',
                'unit' => 'CSSD, Lt B1',
                'unit_code' => 'CSSD',
                'destination_unit' => 'ICU DEWASA, Lt 8',
                'destination_unit_code' => 'ICUD',
                'jumlah' => 3,
                'jumlah_steril' => 3,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'location' => 'Gedung VENTRICLE',
                'description' => 'Precision forceps for surgical procedures',
                'specifications' => ['Type: Toothed', 'Size: 20cm', 'Material: Stainless Steel'],
                'status' => 'Ready',
            ],
            [
                'name' => 'Surgical Needle Holder',
                'instrument_type' => 'Holding Instrument',
                'unit' => 'CSSD, Lt B1',
                'unit_code' => 'CSSD',
                'destination_unit' => 'RAWAT ANAK, Lt 7',
                'destination_unit_code' => 'RA',
                'jumlah' => 2,
                'jumlah_steril' => 2,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'location' => 'Gedung VENTRICLE',
                'description' => 'Professional needle holder for surgical suturing',
                'specifications' => ['Type: Mayo-Hegar', 'Size: 16cm', 'Material: Tungsten Carbide'],
                'status' => 'Ready',
            ],
            [
                'name' => 'Pressure Gauge',
                'instrument_type' => 'Measuring Instrument',
                'unit' => 'IW MEDIKAL, Lt 6',
                'unit_code' => 'IWM',
                'destination_unit' => null,
                'destination_unit_code' => null,
                'jumlah' => 1,
                'jumlah_steril' => 1,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'location' => 'Gedung VENTRICLE',
                'description' => 'Digital pressure gauge for medical monitoring',
                'specifications' => ['Range: 0-300 psi', 'Accuracy: ±1%', 'Type: Digital'],
                'status' => 'Ready',
            ],
            [
                'name' => 'Temperature Sensor',
                'instrument_type' => 'Monitoring Instrument',
                'unit' => 'ICU ANAK, Lt 8',
                'unit_code' => 'ICUA',
                'destination_unit' => null,
                'destination_unit_code' => null,
                'jumlah' => 1,
                'jumlah_steril' => 1,
                'jumlah_kotor' => 0,
                'jumlah_proses_cssd' => 0,
                'location' => 'Gedung PERAWATAN',
                'description' => 'High-precision temperature sensor for patient monitoring',
                'specifications' => ['Range: -50°C to 200°C', 'Accuracy: ±0.1°C', 'Type: RTD'],
                'status' => 'Ready',
            ],
        ];

        foreach ($sampleAssets as $asset) {
            // Generate QR code first
            $tempAsset = new \App\Models\Asset($asset);
            $asset['qr_code'] = $tempAsset->generateQrCode();

            // Create asset with QR code
            \App\Models\Asset::create($asset);
        }
    }
}
