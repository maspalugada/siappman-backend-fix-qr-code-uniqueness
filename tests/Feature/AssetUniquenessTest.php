<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetUniquenessTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->user);
        $this->artisan('migrate');
    }

    /** @test */
    public function cannot_create_duplicate_asset_with_same_name_instrument_type_and_unit()
    {
        // Create first asset
        Asset::factory()->create([
            'name' => 'Surgical Scissors',
            'instrument_type' => 'Cutting Instrument',
            'unit' => 'Surgery Unit',
            'unit_code' => 'SU001',
            'location' => 'Operating Room 1',
        ]);

        // Attempt to create duplicate
        $duplicateData = [
            'name' => 'Surgical Scissors',
            'instrument_type' => 'Cutting Instrument',
            'unit' => 'Surgery Unit',
            'unit_code' => 'SU001',
            'destination_unit' => null,
            'destination_unit_code' => null,
            'jumlah' => 5,
            'jumlah_steril' => 5,
            'jumlah_kotor' => 0,
            'jumlah_proses_cssd' => 0,
            'location' => 'Operating Room 1',
            'description' => 'Duplicate scissors',
        ];

        $response = $this->post(route('dashboard.assets.store'), $duplicateData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['duplicate' => 'Alat Instrumen Sudah Tersedia']);
        $this->assertDatabaseCount('assets', 1); // Should still have only 1 asset
    }

    /** @test */
    public function can_create_asset_with_same_name_but_different_instrument_type()
    {
        // Create first asset
        Asset::factory()->create([
            'name' => 'Surgical Scissors',
            'instrument_type' => 'Cutting Instrument',
            'unit' => 'Surgery Unit',
            'unit_code' => 'SU001',
            'location' => 'Operating Room 1',
        ]);

        // Create asset with same name but different instrument type
        $differentData = [
            'name' => 'Surgical Scissors',
            'instrument_type' => 'Specialized Cutting Instrument',
            'unit' => 'Surgery Unit',
            'unit_code' => 'SU001',
            'destination_unit' => null,
            'destination_unit_code' => null,
            'jumlah' => 3,
            'jumlah_steril' => 3,
            'jumlah_kotor' => 0,
            'jumlah_proses_cssd' => 0,
            'location' => 'Operating Room 1',
            'description' => 'Different type of scissors',
        ];

        $response = $this->post(route('dashboard.assets.store'), $differentData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('assets', 2); // Should have 2 assets now
    }

    /** @test */
    public function can_create_asset_with_same_name_and_instrument_type_but_different_unit()
    {
        // Create first asset
        Asset::factory()->create([
            'name' => 'Surgical Scissors',
            'instrument_type' => 'Cutting Instrument',
            'unit' => 'Surgery Unit',
            'unit_code' => 'SU001',
            'location' => 'Operating Room 1',
        ]);

        // Create asset with same name and instrument type but different unit
        $differentData = [
            'name' => 'Surgical Scissors',
            'instrument_type' => 'Cutting Instrument',
            'unit' => 'Emergency Unit',
            'unit_code' => 'EU001',
            'destination_unit' => null,
            'destination_unit_code' => null,
            'jumlah' => 2,
            'jumlah_steril' => 2,
            'jumlah_kotor' => 0,
            'jumlah_proses_cssd' => 0,
            'location' => 'Emergency Room',
            'description' => 'Scissors for emergency unit',
        ];

        $response = $this->post(route('dashboard.assets.store'), $differentData);

        $response->assertRedirect(route('dashboard.assets.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('assets', 2); // Should have 2 assets now
    }
}
