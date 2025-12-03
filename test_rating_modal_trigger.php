<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;

echo "Testing Rating Modal Trigger:\n";
echo "============================\n";

// Get order 1
$order = Order::with(['user', 'orderItems.product'])->find(1);

if (!$order) {
    echo "Order not found!\n";
    exit;
}

// Login as the user
auth()->loginUsingId($order->user_id);

echo "Logged in as: " . auth()->user()->name . "\n";
echo "Order ID: {$order->id}\n";
echo "Order Status: {$order->status}\n";

// Set session for rating modal
session(['show_rating_modal' => true]);

echo "Session 'show_rating_modal' set to: " . (session('show_rating_modal') ? 'true' : 'false') . "\n";

// Test if we can access the order show page
echo "Order URL: http://127.0.0.1:8000/orders/{$order->id}\n";

// Check if order belongs to user
if ($order->user_id === auth()->id()) {
    echo "Order belongs to current user - should work\n";
} else {
    echo "Order does NOT belong to current user - will fail\n";
}

// Check order items
echo "Order Items:\n";
foreach ($order->orderItems as $item) {
    echo "  - Product: {$item->product->name} (ID: {$item->product_id})\n";
    echo "    Quantity: {$item->quantity}\n";
}

echo "\nTo test rating modal:\n";
echo "1. Open browser and go to: http://127.0.0.1:8000/orders/{$order->id}\n";
echo "2. The rating modal should appear automatically\n";
echo "3. Check browser console for any JavaScript errors\n";
echo "4. Try to submit a rating and check console logs\n";






