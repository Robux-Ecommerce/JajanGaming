<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\AdminWallet;
use App\Models\AdminTaxHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function process(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Order is not pending payment.');
        }

        // Simulate payment gateway integration
        // In real implementation, you would integrate with actual payment gateway
        return view('payment.process', compact('order'));
    }

    public function topup(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('wallet.index')
                ->with('error', 'Transaction is not pending.');
        }

        return view('payment.topup', compact('transaction'));
    }

    public function callback(Request $request)
    {
        $transactionId = $request->get('transaction_id');
        $status = $request->get('status'); // success, failed, pending
        $orderId = $request->get('order_id');

        // Find transaction by order_id or transaction_id
        $transaction = Transaction::where('order_id', $orderId)
            ->orWhere('transaction_id', $transactionId)
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        DB::beginTransaction();

        try {
            if ($status === 'success') {
                $transaction->update([
                    'status' => 'success',
                    'transaction_id' => $transactionId ?: 'TXN-' . time() . '-' . $transaction->user_id,
                ]);

                if ($transaction->type === 'topup') {
                    // Add to wallet
                    $user = $transaction->user;
                    $user->update([
                        'wallet_balance' => $user->wallet_balance + $transaction->amount,
                    ]);

                    // Create top-up success notification
                    Notification::create([
                        'user_id' => $transaction->user_id,
                        'type' => 'wallet',
                        'title' => 'Wallet Top-up Successful! 💰',
                        'message' => "Your wallet has been topped up with Rp " . number_format($transaction->amount, 0, ',', '.') . ". New balance: Rp " . number_format($user->wallet_balance, 0, ',', '.'),
                        'data' => [
                            'amount' => $transaction->amount,
                            'new_balance' => $user->wallet_balance,
                            'transaction_id' => $transaction->transaction_id,
                        ],
                    ]);
                } else if ($transaction->type === 'purchase') {
                    // Complete the order
                    $transaction->order->update(['status' => 'completed']);
                    
                    // Increase sales count for each product in the order
                    foreach ($transaction->order->orderItems as $item) {
                        $item->product->increment('sales_count', $item->quantity);
                    }
                    
                    // Clear cart if order is completed
                    Cart::where('user_id', $transaction->user_id)->delete();

                    // Create rating notification for customer
                    Notification::create([
                        'user_id' => $transaction->user_id,
                        'order_id' => $transaction->order_id,
                        'type' => 'rating',
                        'title' => 'Rate Your Purchase! ⭐',
                        'message' => "Thank you for your purchase! Please rate your experience to help us improve our service.",
                        'data' => [
                            'order_number' => $transaction->order->order_number,
                            'order_id' => $transaction->order_id,
                            'products' => $transaction->order->orderItems->map(function($item) {
                                return [
                                    'id' => $item->product_id,
                                    'name' => $item->product->name,
                                    'seller_name' => $item->product->seller_name,
                                ];
                            })->toArray(),
                        ],
                    ]);
                }
            } else {
                $transaction->update([
                    'status' => 'failed',
                ]);

                if ($transaction->type === 'topup') {
                    // Create top-up failed notification
                    Notification::create([
                        'user_id' => $transaction->user_id,
                        'type' => 'wallet',
                        'title' => 'Wallet Top-up Failed! ❌',
                        'message' => "Your wallet top-up of Rp " . number_format($transaction->amount, 0, ',', '.') . " has failed. Please try again.",
                        'data' => [
                            'amount' => $transaction->amount,
                            'transaction_id' => $transaction->transaction_id,
                        ],
                    ]);
                } else if ($transaction->type === 'purchase') {
                    // Cancel the order and restore stock
                    $order = $transaction->order;
                    $order->update(['status' => 'cancelled']);
                    
                    // Restore product stock and decrease sales count
                    foreach ($order->orderItems as $item) {
                        $item->product->increment('quantity', $item->quantity);
                        $item->product->decrement('sales_count', $item->quantity);
                    }

                    // Create payment failed notification
                    Notification::create([
                        'user_id' => $transaction->user_id,
                        'order_id' => $transaction->order_id,
                        'type' => 'payment',
                        'title' => 'Payment Failed! ❌',
                        'message' => "Your payment for order #{$transaction->order->id} has failed. The order has been cancelled and stock restored.",
                        'data' => [
                            'order_number' => $transaction->order->order_number,
                            'amount' => $transaction->amount,
                            'transaction_id' => $transaction->transaction_id,
                        ],
                    ]);
                }
            }

            DB::commit();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to process payment'], 500);
        }
    }

    public function simulateSuccess(Request $request)
    {
        $transactionId = $request->get('transaction_id');
        $transaction = Transaction::findOrFail($transactionId);

        // Simulate successful payment
        $transaction->update([
            'transaction_id' => 'TXN-' . time() . '-' . $transaction->user_id,
            'status' => 'success',
        ]);

        if ($transaction->type === 'topup') {
            $user = $transaction->user;
            $user->update([
                'wallet_balance' => $user->wallet_balance + $transaction->amount,
            ]);

            // Create top-up success notification
            Notification::create([
                'user_id' => $transaction->user_id,
                'type' => 'wallet',
                'title' => 'Wallet Top-up Successful! 💰',
                'message' => "Your wallet has been topped up with Rp " . number_format($transaction->amount, 0, ',', '.') . ". New balance: Rp " . number_format($user->wallet_balance, 0, ',', '.'),
                'data' => [
                    'amount' => $transaction->amount,
                    'new_balance' => $user->wallet_balance,
                    'transaction_id' => $transaction->transaction_id,
                ],
            ]);

            return redirect()->route('wallet.index')
                ->with('success', 'Top up successful!');
        } elseif ($transaction->type === 'purchase') {
            $transaction->order->update(['status' => 'completed']);
            
            // Increase sales count for each product in the order
            foreach ($transaction->order->orderItems as $item) {
                $item->product->increment('sales_count', $item->quantity);
            }
            
            // Collect 10% tax from purchase amount
            $taxAmount = ($transaction->amount * 10) / 100;
            $adminWallet = AdminWallet::first();
            
            if ($adminWallet) {
                $adminWallet->update([
                    'total_balance' => $adminWallet->total_balance + $taxAmount,
                    'total_tax_collected' => $adminWallet->total_tax_collected + $taxAmount,
                    'last_updated' => now(),
                ]);
            }
            
            // Record tax history
            AdminTaxHistory::create([
                'transaction_id' => $transaction->id,
                'order_id' => $transaction->order_id,
                'amount' => $taxAmount,
                'tax_rate' => 10,
                'description' => "Pajak dari pesanan #{$transaction->order->order_number}",
            ]);
            
            // Clear cart if order is completed
            Cart::where('user_id', $transaction->user_id)->delete();

            // Create rating notification for customer
            Notification::create([
                'user_id' => $transaction->user_id,
                'order_id' => $transaction->order_id,
                'type' => 'rating',
                'title' => 'Rate Your Purchase! ⭐',
                'message' => "Thank you for your purchase! Please rate your experience to help us improve our service.",
                'data' => [
                    'order_number' => $transaction->order->order_number,
                    'order_id' => $transaction->order_id,
                    'products' => $transaction->order->orderItems->map(function($item) {
                        return [
                            'id' => $item->product_id,
                            'name' => $item->product->name,
                            'seller_name' => $item->product->seller_name,
                        ];
                    })->toArray(),
                ],
            ]);
            
            return redirect()->route('orders.show', $transaction->order_id)
                ->with('success', 'Payment successful! Order completed.')
                ->with('show_rating_modal', true);
        }

        return redirect()->back()->with('success', 'Payment successful!');
    }

    public function simulateFailed(Request $request)
    {
        $transactionId = $request->get('transaction_id');
        $transaction = Transaction::findOrFail($transactionId);

        // Simulate failed payment
        $transaction->update([
            'status' => 'failed',
        ]);

        if ($transaction->type === 'topup') {
            // Create top-up failed notification
            Notification::create([
                'user_id' => $transaction->user_id,
                'type' => 'wallet',
                'title' => 'Wallet Top-up Failed! ❌',
                'message' => "Your wallet top-up of Rp " . number_format($transaction->amount, 0, ',', '.') . " has failed. Please try again.",
                'data' => [
                    'amount' => $transaction->amount,
                    'transaction_id' => $transaction->transaction_id,
                ],
            ]);
            
            return redirect()->route('wallet.index')
                ->with('error', 'Top up failed!');
        } else if ($transaction->type === 'purchase') {
            $order = $transaction->order;
            $order->update(['status' => 'cancelled']);
            
            // Restore product stock and decrease sales count
            foreach ($order->orderItems as $item) {
                $item->product->increment('quantity', $item->quantity);
                $item->product->decrement('sales_count', $item->quantity);
            }

            // Payment failed - no notification to user
        }

        return redirect()->back()->with('error', 'Payment failed!');
    }
}
