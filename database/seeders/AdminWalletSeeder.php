<?php

namespace Database\Seeders;

use App\Models\AdminWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminWallet::firstOrCreate(
            ['id' => 1],
            [
                'total_balance' => 0,
                'total_tax_collected' => 0,
                'last_updated' => now(),
            ]
        );
    }
}
