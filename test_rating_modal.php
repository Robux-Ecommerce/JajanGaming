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

echo "Order ID: {$order->id}\n";
echo "User: {$order->user->name} (ID: {$order->user->id})\n";
echo "Status: {$order->status}\n";

// Check if order is completed
if ($order->status === 'completed') {
    echo "Order is completed - rating modal should be available\n";
} else {
    echo "Order is NOT completed - rating modal will not show\n";
}

// Check if user owns the order
if ($order->user_id === 13) { // apelGaming user ID
    echo "User owns this order - rating should work\n";
} else {
    echo "User does NOT own this order - rating will fail\n";
}

// Check order items
echo "Order Items:\n";
foreach ($order->orderItems as $item) {
    echo "  - Product: {$item->product->name} (ID: {$item->product_id})\n";
    echo "    Quantity: {$item->quantity}\n";
}

echo "\nTo test rating modal:\n";
echo "1. Login as user 'apelGaming'\n";
echo "2. Go to: http://127.0.0.1:8000/orders/1\n";
echo "3. The rating modal should appear automatically\n";
echo "4. Check browser console for JavaScript errors\n";






