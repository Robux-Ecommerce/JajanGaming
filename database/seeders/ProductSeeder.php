<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Robux 80',
                'description' => '80 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'GameStore Pro',
                'seller_photo' => 'seller1.jpg',
                'rating' => 0,
                'sales_count' => 1250,
                'price' => 12000,
                'quantity' => 183,
                'image' => 'sellers/robux dikit 1.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 170',
                'description' => '170 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'Digital Gaming',
                'seller_photo' => 'seller2.jpg',
                'rating' => 0,
                'sales_count' => 980,
                'price' => 25000,
                'quantity' => 156,
                'image' => 'sellers/robux sedang 2.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 240',
                'description' => '240 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'TopUp Master',
                'seller_photo' => 'seller3.jpg',
                'rating' => 0,
                'sales_count' => 750,
                'price' => 35000,
                'quantity' => 89,
                'image' => 'sellers/robux banyak 2.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 320',
                'description' => '320 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'GameHub Official',
                'seller_photo' => 'seller4.jpg',
                'rating' => 0,
                'sales_count' => 1100,
                'price' => 45000,
                'quantity' => 234,
                'image' => 'sellers/robux.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 400',
                'description' => '400 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'Premium Store',
                'seller_photo' => 'seller5.jpg',
                'rating' => 0,
                'sales_count' => 650,
                'price' => 55000,
                'quantity' => 67,
                'image' => 'sellers/robux dikit 1.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 800',
                'description' => '800 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'Elite Gaming',
                'seller_photo' => 'seller6.jpg',
                'rating' => 0,
                'sales_count' => 850,
                'price' => 100000,
                'quantity' => 145,
                'image' => 'sellers/robux sedang 2.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 1200',
                'description' => '1200 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'Mega TopUp',
                'seller_photo' => 'seller7.jpg',
                'rating' => 0,
                'sales_count' => 720,
                'price' => 150000,
                'quantity' => 78,
                'image' => 'sellers/robux banyak 2.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 2000',
                'description' => '2000 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'Super Store',
                'seller_photo' => 'seller8.jpg',
                'rating' => 0,
                'sales_count' => 580,
                'price' => 250000,
                'quantity' => 45,
                'image' => 'sellers/robux.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 4000',
                'description' => '4000 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'Ultimate Gaming',
                'seller_photo' => 'seller9.jpg',
                'rating' => 0,
                'sales_count' => 420,
                'price' => 500000,
                'quantity' => 32,
                'image' => 'sellers/robux dikit 1.png',
                'is_active' => true,
            ],
            [
                'name' => 'Robux 8000',
                'description' => '8000 Robux untuk Roblox',
                'game_name' => 'Roblox',
                'game_type' => 'Robux',
                'seller_name' => 'VIP Store',
                'seller_photo' => 'seller10.jpg',
                'rating' => 0,
                'sales_count' => 350,
                'price' => 1000000,
                'quantity' => 28,
                'image' => 'sellers/robux sedang 2.png',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}