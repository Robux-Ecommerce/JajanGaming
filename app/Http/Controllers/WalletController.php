<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get required amount from session if redirected from cart
        $requiredAmount = session('required_amount');

        return view('wallet.index', compact('user', 'transactions', 'requiredAmount'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'topup',
            'amount' => $request->amount,
            'status' => 'pending',
            'payment_method' => 'gateway',
            'description' => 'Wallet top up',
        ]);

        // Redirect to payment gateway for top up
        return redirect()->route('payment.topup', $transaction->id);
    }
}
