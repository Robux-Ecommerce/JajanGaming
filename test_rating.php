<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\Rating;
use App\Models\User;

echo "Testing Rating System:\n";
echo "=====================\n";

// Get order 1
$order = Order::with(['user', 'orderItems.product'])->find(1);

if (!$order) {
    echo "Order not found!\n";
    exit;
}

echo "Order ID: {$order->id}\n";
echo "User: {$order->user->name} (ID: {$order->user->id})\n";
echo "Status: {$order->status}\n";
echo "Order Items:\n";

foreach ($order->orderItems as $item) {
    echo "  - Product: {$item->product->name} (ID: {$item->product_id})\n";
    echo "    Quantity: {$item->quantity}\n";
}

echo "\nTesting Rating Creation:\n";

// Test creating a rating
$rating = Rating::create([
    'user_id' => $order->user_id,
    'product_id' => $order->orderItems[0]->product_id,
    'order_id' => $order->id,
    'rating' => 5,
    'review' => 'Test review from script'
]);

echo "Rating created successfully!\n";
echo "Rating ID: {$rating->id}\n";
echo "Product ID: {$rating->product_id}\n";
echo "Rating: {$rating->rating}\n";
echo "Review: {$rating->review}\n";

// Check if rating exists
$existingRating = Rating::where('user_id', $order->user_id)
    ->where('product_id', $order->orderItems[0]->product_id)
    ->where('order_id', $order->id)
    ->first();

if ($existingRating) {
    echo "\nRating exists in database!\n";
} else {
    echo "\nRating NOT found in database!\n";
}

