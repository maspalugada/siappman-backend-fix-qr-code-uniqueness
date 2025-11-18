<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User - Full Access
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_admin' => true,
            'can_view_instrument_sets' => true,
            'can_view_qr_codes' => true,
            'can_manage_master_data' => true,
            'can_view_assets' => true,
            'can_view_scan_history' => true,
            'can_use_scanner' => true,
            'can_sterilize' => true,
            'can_wash' => true,
            'can_manage_stock' => true,
            'can_distribute_sterile' => true,
            'can_distribute_dirty' => true,
            'can_receive_returns' => true,
        ]);

        // Perawat (Nurse) - Basic Scanner Access
        User::create([
            'name' => 'Perawat User',
            'email' => 'perawat@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'staff',
            'is_admin' => false,
            'can_view_instrument_sets' => false,
            'can_view_qr_codes' => false,
            'can_manage_master_data' => false,
            'can_view_assets' => false,
            'can_view_scan_history' => false,
            'can_use_scanner' => true,
            'can_sterilize' => false,
            'can_wash' => false,
            'can_manage_stock' => false,
            'can_distribute_sterile' => false,
            'can_distribute_dirty' => false,
            'can_receive_returns' => false,
        ]);

        // Operator CSSD Steril (Sterilization Operator)
        User::create([
            'name' => 'Operator CSSD Steril',
            'email' => 'operator.steril@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'staff',
            'is_admin' => false,
            'can_view_instrument_sets' => true,
            'can_view_qr_codes' => true,
            'can_manage_master_data' => false,
            'can_view_assets' => true,
            'can_view_scan_history' => true,
            'can_use_scanner' => true,
            'can_sterilize' => true,
            'can_wash' => false,
            'can_manage_stock' => true,
            'can_distribute_sterile' => true,
            'can_distribute_dirty' => false,
            'can_receive_returns' => true,
        ]);

        // Operator CSSD Kotor (Dirty Processing Operator)
        User::create([
            'name' => 'Operator CSSD Kotor',
            'email' => 'operator.kotor@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'staff',
            'is_admin' => false,
            'can_view_instrument_sets' => true,
            'can_view_qr_codes' => true,
            'can_manage_master_data' => false,
            'can_view_assets' => true,
            'can_view_scan_history' => true,
            'can_use_scanner' => true,
            'can_sterilize' => false,
            'can_wash' => true,
            'can_manage_stock' => true,
            'can_distribute_sterile' => false,
            'can_distribute_dirty' => true,
            'can_receive_returns' => true,
        ]);

        // Manager/Kepala Unit (Unit Manager)
        User::create([
            'name' => 'Manager Unit',
            'email' => 'manager@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'staff',
            'is_admin' => false,
            'can_view_instrument_sets' => true,
            'can_view_qr_codes' => true,
            'can_manage_master_data' => true,
            'can_view_assets' => true,
            'can_view_scan_history' => true,
            'can_use_scanner' => true,
            'can_sterilize' => false,
            'can_wash' => false,
            'can_manage_stock' => true,
            'can_distribute_sterile' => true,
            'can_distribute_dirty' => true,
            'can_receive_returns' => true,
        ]);

        // Operator Stok (Stock Operator)
        User::create([
            'name' => 'Operator Stok',
            'email' => 'operator.stok@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'staff',
            'is_admin' => false,
            'can_view_instrument_sets' => true,
            'can_view_qr_codes' => true,
            'can_manage_master_data' => false,
            'can_view_assets' => true,
            'can_view_scan_history' => true,
            'can_use_scanner' => true,
            'can_sterilize' => false,
            'can_wash' => false,
            'can_manage_stock' => true,
            'can_distribute_sterile' => true,
            'can_distribute_dirty' => true,
            'can_receive_returns' => true,
        ]);

        // Operator Pencucian (Washing Operator)
        User::create([
            'name' => 'Operator Pencucian',
            'email' => 'operator.pencucian@siappman.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'staff',
            'is_admin' => false,
            'can_view_instrument_sets' => true,
            'can_view_qr_codes' => true,
            'can_manage_master_data' => false,
            'can_view_assets' => true,
            'can_view_scan_history' => true,
            'can_use_scanner' => true,
            'can_sterilize' => false,
            'can_wash' => true,
            'can_manage_stock' => false,
            'can_distribute_sterile' => false,
            'can_distribute_dirty' => true,
            'can_receive_returns' => true,
        ]);
    }
}
