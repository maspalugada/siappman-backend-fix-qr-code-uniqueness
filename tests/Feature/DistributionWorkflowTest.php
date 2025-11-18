<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\InstrumentSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistributionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->artisan('migrate');
    }

    /** @test */
    public function scanning_asset_with_start_distribution_updates_status_to_in_transit()
    {
        $asset = Asset::factory()->create(['status' => Asset::STATUS_READY]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Start Distribution',
            'location' => 'Distribution Center',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_IN_TRANSIT,
        ]);
    }

    /** @test */
    public function scanning_asset_with_start_sterile_distribution_updates_status_and_stock()
    {
        $asset = Asset::factory()->create([
            'status' => Asset::STATUS_READY,
            'jumlah_steril' => 5
        ]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Start Sterile Distribution',
            'location' => 'Operating Room 1',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_IN_TRANSIT_STERILE,
            'jumlah_steril' => 4, // Decreased by 1
        ]);
    }

    /** @test */
    public function scanning_asset_with_start_dirty_distribution_updates_status_and_stock()
    {
        $asset = Asset::factory()->create([
            'status' => Asset::STATUS_IN_USE,
            'jumlah_kotor' => 3,
            'jumlah_proses_cssd' => 0
        ]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Start Dirty Distribution',
            'location' => 'CSSD Receiving',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_IN_TRANSIT_DIRTY,
            'jumlah_kotor' => 2, // Decreased by 1
            'jumlah_proses_cssd' => 1, // Increased by 1
        ]);
    }

    /** @test */
    public function scanning_asset_with_complete_sterilization_updates_stock()
    {
        $asset = Asset::factory()->create([
            'status' => Asset::STATUS_STERILIZING,
            'jumlah_proses_cssd' => 2,
            'jumlah_steril' => 1
        ]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Complete Sterilization',
            'location' => 'CSSD Sterile Area',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_READY,
            'jumlah_proses_cssd' => 1, // Decreased by 1
            'jumlah_steril' => 2, // Increased by 1
        ]);
    }

    /** @test */
    public function scanning_asset_with_insufficient_sterile_stock_fails()
    {
        $asset = Asset::factory()->create([
            'status' => Asset::STATUS_READY,
            'jumlah_steril' => 0
        ]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Start Sterile Distribution',
            'location' => 'Operating Room 1',
        ];

        $response = $this->postJson('/api/scan', $scanData);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Insufficient sterile stock for distribution']);
    }

    /** @test */
    public function scanning_asset_with_mark_as_received_updates_status_to_in_use()
    {
        $asset = Asset::factory()->create(['status' => Asset::STATUS_IN_TRANSIT]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Mark as Received',
            'location' => 'Operating Room 1',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_IN_USE,
        ]);
    }

    /** @test */
    public function scanning_asset_with_start_return_updates_status_to_returning()
    {
        $asset = Asset::factory()->create(['status' => Asset::STATUS_IN_USE]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Start Return',
            'location' => 'Operating Room 1',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_RETURNING,
        ]);
    }

    /** @test */
    public function scanning_asset_with_mark_as_returned_updates_status_to_returned()
    {
        $asset = Asset::factory()->create(['status' => Asset::STATUS_RETURNING]);
        $scanData = [
            'qr_code' => $asset->qr_code,
            'action' => 'Mark as Returned',
            'location' => 'CSSD Receiving',
        ];

        $this->postJson('/api/scan', $scanData);

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'status' => Asset::STATUS_RETURNED,
        ]);
    }

    /** @test */
    public function scanning_instrument_set_with_distribution_actions_updates_set_and_assets()
    {
        $assets = Asset::factory()->count(2)->create(['status' => Asset::STATUS_READY]);
        $instrumentSet = InstrumentSet::factory()
            ->hasAttached($assets)
            ->create(['status' => InstrumentSet::STATUS_READY]);

        $scanData = [
            'qr_code' => $instrumentSet->qr_code,
            'action' => 'Start Distribution',
            'location' => 'Distribution Center',
        ];

        $this->postJson('/api/scan', $scanData);

        // Assert the set's status was updated
        $this->assertDatabaseHas('instrument_sets', [
            'id' => $instrumentSet->id,
            'status' => InstrumentSet::STATUS_IN_TRANSIT,
        ]);

        // Assert all assets within the set have had their status updated
        foreach ($assets as $asset) {
            $this->assertDatabaseHas('assets', [
                'id' => $asset->id,
                'status' => Asset::STATUS_IN_TRANSIT,
            ]);
        }
    }

    /** @test */
    public function scanning_instrument_set_with_return_actions_updates_set_and_assets()
    {
        $assets = Asset::factory()->count(2)->create(['status' => Asset::STATUS_IN_USE]);
        $instrumentSet = InstrumentSet::factory()
            ->hasAttached($assets)
            ->create(['status' => InstrumentSet::STATUS_IN_USE]);

        $scanData = [
            'qr_code' => $instrumentSet->qr_code,
            'action' => 'Start Return',
            'location' => 'Operating Room 1',
        ];

        $this->postJson('/api/scan', $scanData);

        // Assert the set's status was updated
        $this->assertDatabaseHas('instrument_sets', [
            'id' => $instrumentSet->id,
            'status' => InstrumentSet::STATUS_RETURNING,
        ]);

        // Assert all assets within the set have had their status updated
        foreach ($assets as $asset) {
            $this->assertDatabaseHas('assets', [
                'id' => $asset->id,
                'status' => Asset::STATUS_RETURNING,
            ]);
        }
    }
}
