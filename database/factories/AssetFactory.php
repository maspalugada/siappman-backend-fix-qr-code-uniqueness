<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Generate QR code for factory (simplified version).
     */
    private function generateFactoryQrCode($unitCode, $location)
    {
        $floor = rand(1, 5); // Random floor for factory
        $sequence = rand(1, 999);
        return sprintf('%s-%d-%03d', strtoupper($unitCode), $floor, $sequence);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $instrumentTypes = [
            'Pressure Gauge',
            'Temperature Sensor',
            'Flow Meter',
            'Level Transmitter',
            'Control Valve',
            'Pump',
            'Motor',
            'Switch',
            'Transducer',
            'Analyzer'
        ];

        $units = [
            'Bar',
            'Psi',
            'Celsius',
            'Fahrenheit',
            'Liter/min',
            'm³/h',
            'mm',
            'cm',
            'Meter',
            'RPM',
            'Volt',
            'Ampere',
            'Hz'
        ];

        $locations = [
            'Workshop A',
            'Workshop B',
            'Production Line 1',
            'Production Line 2',
            'Storage Area',
            'Maintenance Room',
            'Control Room',
            'Laboratory'
        ];

        $jumlah = $this->faker->numberBetween(1, 10);
        $jumlah_steril = $this->faker->numberBetween(0, $jumlah);
        $jumlah_kotor = $this->faker->numberBetween(0, $jumlah - $jumlah_steril);
        $jumlah_proses_cssd = $jumlah - $jumlah_steril - $jumlah_kotor;

        // Ensure minimum values for testing
        if ($jumlah_steril < 1) $jumlah_steril = 1;
        if ($jumlah_kotor < 1) $jumlah_kotor = 1;
        if ($jumlah_proses_cssd < 1) $jumlah_proses_cssd = 1;

        $unitCode = $this->faker->randomElement(['IB', 'OK', 'ICU', 'LT7', 'LT8']);
        $location = $this->faker->randomElement($locations);

        return [
            'name' => $this->faker->words(3, true),
            'instrument_type' => $this->faker->randomElement($instrumentTypes),
            'unit' => $this->faker->randomElement($units),
            'unit_code' => $unitCode,
            'jumlah' => $jumlah,
            'jumlah_steril' => $jumlah_steril,
            'jumlah_kotor' => $jumlah_kotor,
            'jumlah_proses_cssd' => $jumlah_proses_cssd,
            'location' => $location,
            'description' => $this->faker->optional()->paragraph(),
            'qr_code' => $this->generateFactoryQrCode($unitCode, $location),
            'specifications' => $this->faker->optional()->randomElements(['Range: 0-100', 'Accuracy: ±0.5%', 'Power: 24VDC'], 2),
            'status' => $this->faker->randomElement([Asset::STATUS_READY, Asset::STATUS_WASHING, Asset::STATUS_IN_USE]),
        ];
    }
}
