<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;

echo "Orders:\n";
echo "=======\n";

$orders = Order::with('user')->get(['id', 'user_id', 'status', 'total_amount']);

foreach ($orders as $order) {
    echo "ID: {$order->id}, User: {$order->user->name}, Status: {$order->status}, Amount: {$order->total_amount}\n";
}

echo "\nTotal orders: " . $orders->count() . "\n";

