<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;

echo "Order Details:\n";
echo "==============\n";

$orders = Order::with(['user', 'orderItems.product'])->get();

foreach ($orders as $order) {
    echo "Order ID: {$order->id}\n";
    echo "User: {$order->user->name} (ID: {$order->user->id})\n";
    echo "Status: {$order->status}\n";
    echo "Total: {$order->total_amount}\n";
    echo "Order Items:\n";
    
    foreach ($order->orderItems as $item) {
        echo "  - Product: {$item->product->name} (ID: {$item->product_id})\n";
        echo "    Quantity: {$item->quantity}\n";
        echo "    Price: {$item->price}\n";
    }
    echo "\n";
}

