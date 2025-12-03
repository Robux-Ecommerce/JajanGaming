<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing admin user role
        $adminUser = User::where('email', 'admin@jajangaming.com')->first();
        if ($adminUser) {
            $adminUser->update(['role' => 'admin']);
        } else {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@jajangaming.com',
                'password' => Hash::make('admin123'),
                'wallet_balance' => 0,
                'role' => 'admin',
                'profile_photo' => null,
            ]);
        }

        // Create Seller Users (matching ProductSeeder)
        $sellers = [
            ['name' => 'GameStore Pro', 'email' => 'gamestore@jajangaming.com'],
            ['name' => 'Digital Gaming', 'email' => 'digital@jajangaming.com'],
            ['name' => 'TopUp Master', 'email' => 'topup@jajangaming.com'],
            ['name' => 'GameHub Official', 'email' => 'gamehub@jajangaming.com'],
            ['name' => 'Premium Store', 'email' => 'premium@jajangaming.com'],
            ['name' => 'Elite Gaming', 'email' => 'elite@jajangaming.com'],
            ['name' => 'Mega Store', 'email' => 'mega@jajangaming.com'],
            ['name' => 'Ultimate Gaming', 'email' => 'ultimate@jajangaming.com'],
            ['name' => 'Pro Gaming', 'email' => 'pro@jajangaming.com'],
            ['name' => 'VIP Store', 'email' => 'vip@jajangaming.com'],
        ];

        foreach ($sellers as $seller) {
            User::updateOrCreate(
                ['email' => $seller['email']],
                [
                    'name' => $seller['name'],
                    'password' => Hash::make('seller123'),
                    'wallet_balance' => 0,
                    'role' => 'seller',
                    'profile_photo' => null,
                ]
            );
        }

        // Create Regular User
        User::updateOrCreate(
            ['email' => 'user@jajangaming.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'),
                'wallet_balance' => 100000,
                'role' => 'user',
                'profile_photo' => null,
            ]
        );
    }
}
