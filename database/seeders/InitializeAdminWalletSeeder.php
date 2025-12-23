<?php

namespace Database\Seeders;

use App\Models\AdminWallet;
use Illuminate\Database\Seeder;

class InitializeAdminWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin wallet already exists
        if (AdminWallet::count() === 0) {
            AdminWallet::create([
                'total_balance' => 0,
                'total_tax_collected' => 0,
                'last_updated' => now(),
            ]);
        }
    }
}
