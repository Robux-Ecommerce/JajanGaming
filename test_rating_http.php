<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\RatingController;

echo "Testing Rating HTTP Request:\n";
echo "===========================\n";

// Get order 1
$order = Order::with(['user', 'orderItems.product'])->find(1);

if (!$order) {
    echo "Order not found!\n";
    exit;
}

echo "Order ID: {$order->id}\n";
echo "User: {$order->user->name} (ID: {$order->user->id})\n";

// Simulate HTTP request
$request = new Request();
$request->merge([
    'order_id' => $order->id,
    'rating_2' => 4, // Product ID 2
    'review_2' => 'Test review from HTTP request',
    '_token' => csrf_token()
]);

// Set authenticated user
auth()->loginUsingId($order->user_id);

echo "Authenticated as: " . auth()->user()->name . "\n";

// Test RatingController
$controller = new RatingController();

try {
    $response = $controller->store($request);
    $responseData = $response->getData(true);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Data: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

