<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AssetQrCodeUniquenessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->user = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_generates_unique_qr_codes()
    {
        $assetData1 = [
            'name' => 'Test Asset 1',
            'instrument_type' => 'STEAM',
            'unit' => 'Unit 1',
            'unit_code' => 'U001',
            'destination_unit' => null,
            'destination_unit_code' => null,
            'jumlah' => 1,
            'jumlah_steril' => 1,
            'jumlah_kotor' => 0,
            'jumlah_proses_cssd' => 0,
            'location' => 'Location 1',
            'description' => 'Test asset 1',
            'specifications' => null,
        ];

        $assetData2 = [
            'name' => 'Test Asset 2',
            'instrument_type' => 'EO',
            'unit' => 'Unit 2',
            'unit_code' => 'U002',
            'destination_unit' => null,
            'destination_unit_code' => null,
            'jumlah' => 1,
            'jumlah_steril' => 1,
            'jumlah_kotor' => 0,
            'jumlah_proses_cssd' => 0,
            'location' => 'Location 2',
            'description' => 'Test asset 2',
            'specifications' => null,
        ];

        $this->post(route('dashboard.assets.store'), $assetData1);
        $this->post(route('dashboard.assets.store'), $assetData2);

        $assets = Asset::all();
        $this->assertCount(2, $assets);

        $qrCodes = $assets->pluck('qr_code');
        $this->assertCount(2, $qrCodes->unique());
    }
}
