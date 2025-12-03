<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Redirect seller to admin dashboard
        if (Auth::check() && Auth::user()->isSeller()) {
            return redirect()->route('admin.dashboard');
        }

        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems.product.seller')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product.seller');

        return view('orders.show', compact('order'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,gateway',
            'roblox_username' => 'required|string|max:255',
        ]);

        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $carts->sum(function($cart) {
            return $cart->quantity * $cart->price;
        });

        // Check wallet balance if using wallet payment
        if ($request->payment_method === 'wallet') {
            $user = Auth::user();
            if ($user->wallet_balance < $total) {
                // Redirect to wallet top up page instead of showing error
                return redirect()->route('wallet.index')
                    ->with('error', 'Insufficient wallet balance! Please top up your wallet first.')
                    ->with('required_amount', $total);
            }
        }

        DB::beginTransaction();

        try {
            // Check stock availability before creating order
            foreach ($carts as $cart) {
                if ($cart->product->quantity < $cart->quantity) {
                    DB::rollback();
                    return redirect()->route('cart.index')
                        ->with('error', 'Insufficient stock for ' . $cart->product->name);
                }
            }

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . time() . '-' . Auth::id(),
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'notes' => $request->notes,
                'roblox_username' => $request->roblox_username,
            ]);

            // Create notifications for sellers
            $this->createOrderNotifications($order, $carts);

            // Create order items and reduce stock
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->price,
                ]);

                // Reduce product stock and increase sales count
                $cart->product->decrement('quantity', $cart->quantity);
                $cart->product->increment('sales_count', $cart->quantity);
            }

            // Handle payment based on method
            if ($request->payment_method === 'wallet') {
                // Deduct from wallet and complete order immediately
                $user = Auth::user();
                $user->update([
                    'wallet_balance' => $user->wallet_balance - $total,
                ]);

                // Create successful transaction record
                Transaction::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'type' => 'purchase',
                    'amount' => $total,
                    'status' => 'success',
                    'payment_method' => 'wallet',
                    'transaction_id' => 'TXN-' . time() . '-' . Auth::id(),
                    'description' => 'Purchase using wallet balance',
                ]);

                // Complete the order
                $order->update(['status' => 'completed']);

                // Clear cart
                Cart::where('user_id', Auth::id())->delete();

                DB::commit();

                return redirect()->route('orders.show', $order->id)
                    ->with('success', 'Order completed successfully using DompetKu!');

            } else {
                // Payment Gateway - Create pending transaction and redirect
                Transaction::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'type' => 'purchase',
                    'amount' => $total,
                    'status' => 'pending',
                    'payment_method' => 'gateway',
                    'description' => 'Purchase via payment gateway',
                ]);

                DB::commit();

                // Redirect to payment gateway
                return redirect()->route('payment.process', $order->id);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cart.index')
                ->with('error', 'Failed to process order. Please try again.');
        }
    }

    private function createOrderNotifications($order, $carts)
    {
        // Get unique sellers from the order
        $sellerNames = $carts->map(function($cart) {
            return $cart->product->seller_name;
        })->unique()->filter();

        foreach ($sellerNames as $sellerName) {
            // Find seller user by name
            $seller = \App\Models\User::where('name', $sellerName)->where('role', 'seller')->first();
            
            if (!$seller) {
                continue; // Skip if seller not found
            }

            // Get seller's products in this order
            $sellerProducts = $carts->filter(function($cart) use ($sellerName) {
                return $cart->product->seller_name == $sellerName;
            });

            $totalAmount = $sellerProducts->sum(function($cart) {
                return $cart->quantity * $cart->price;
            });

            $productNames = $sellerProducts->pluck('product.name')->toArray();
            $productCount = $sellerProducts->count();

            Notification::create([
                'user_id' => $seller->id,
                'order_id' => $order->id,
                'type' => 'order',
                'title' => 'New Order Received! 🎮',
                'message' => "You have a new order from {$order->user->name} for " . 
                           ($productCount > 1 ? $productCount . ' products' : $productNames[0]) . 
                           " worth Rp " . number_format($totalAmount, 0, ',', '.') . 
                           ". Roblox Username: {$order->roblox_username}",
                'data' => [
                    'customer_name' => $order->user->name,
                    'customer_email' => $order->user->email,
                    'roblox_username' => $order->roblox_username,
                    'product_names' => $productNames,
                    'product_count' => $productCount,
                    'total_amount' => $totalAmount,
                    'order_number' => $order->order_number,
                ],
            ]);
        }

        // Also notify admin if there are any orders
        $adminUsers = \App\Models\User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'order_id' => $order->id,
                'type' => 'order',
                'title' => 'New Order Alert! 📦',
                'message' => "New order #{$order->id} from {$order->user->name} for Rp " . 
                           number_format($order->total_amount, 0, ',', '.') . 
                           ". Roblox Username: {$order->roblox_username}",
                'data' => [
                    'customer_name' => $order->user->name,
                    'customer_email' => $order->user->email,
                    'roblox_username' => $order->roblox_username,
                    'total_amount' => $order->total_amount,
                    'order_number' => $order->order_number,
                ],
            ]);
        }
    }
}
