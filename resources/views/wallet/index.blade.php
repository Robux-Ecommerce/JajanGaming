@extends('layouts.app')

@section('title', 'My Wallet - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .wallet-balance-card {
            margin-bottom: 2rem;
        }
        
        .wallet-balance-card .card-body {
            text-align: center;
            padding: 1rem;
        }
        
        .wallet-balance-card h3 {
            font-size: 1.5rem;
        }
        
        .topup-form {
            margin-bottom: 2rem;
        }
        
        .topup-form .btn {
            width: 100%;
            margin-top: 1rem;
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
        }
        
        .topup-form .form-control {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }
        
        .transaction-history {
            margin-top: 2rem;
        }
        
        .transaction-history .table {
            font-size: 0.85rem;
        }
        
        .transaction-history .table th,
        .transaction-history .table td {
            padding: 0.5rem 0.25rem;
        }
    }
    
    @media (max-width: 576px) {
        .wallet-balance-card h3 {
            font-size: 1.3rem;
        }
        
        .wallet-balance-card .card-body {
            padding: 1rem;
        }
        
        .topup-form .card-body {
            padding: 1rem;
        }
        
        .transaction-history .table {
            font-size: 0.8rem;
        }
        
        .transaction-history .table th,
        .transaction-history .table td {
            padding: 0.4rem 0.2rem;
        }
        
        .transaction-history .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-wallet me-2"></i>{{ auth()->user()->isSeller() ? 'Dompet Penghasilan' : 'My Wallet' }}</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-coins me-2"></i>{{ auth()->user()->isSeller() ? 'Total Revenue (Completed Orders)' : 'Wallet Balance' }}</h5>
                </div>
                <div class="card-body text-center">
                    <div class="wallet-balance mb-3" style="font-size: 1.5rem; max-width: 300px; margin: 0 auto;">
                        <i class="fas fa-coins me-2"></i>
                        @if(auth()->user()->isSeller())
                            Rp {{ number_format(\App\Models\Order::whereHas('orderItems.product', function($q){ $q->where('seller_name', auth()->user()->name); })->where('status','completed')->sum('total_amount'), 0, ',', '.') }}
                        @else
                            Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}
                        @endif
                    </div>
                    
                    @if(!auth()->user()->isSeller())
                    <form action="{{ route('wallet.topup') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Top Up Amount (Minimum Rp 10,000)</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" min="10000" step="1000" 
                                   value="{{ $requiredAmount ?? '' }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($requiredAmount)
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    You need at least Rp {{ number_format($requiredAmount, 0, ',', '.') }} to complete your order.
                                </div>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-slide btn-glow">
                            <i class="fas fa-plus me-2"></i>Top Up Wallet
                        </button>
                        
                        @if($requiredAmount)
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary ms-2 btn-slide btn-glow">
                                <i class="fas fa-arrow-left me-2"></i>Back to Cart
                            </a>
                        @endif
                    </form>
                    @else
                        <div class="alert alert-info mt-3">
                            Pendapatan dihitung dari total order selesai (completed). Untuk detail transaksi, gunakan laporan order.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>{{ auth()->user()->isSeller() ? 'Informasi Pendapatan' : 'Wallet Information' }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Secure wallet system
                        </li>
                        @if(!auth()->user()->isSeller())
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Instant top up processing
                            </li>
                        @endif
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use for purchases or withdrawals
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Transaction history tracking
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-history me-2"></i>{{ auth()->user()->isSeller() ? 'Ringkasan Order Selesai' : 'Transaction History' }}</h5>
                </div>
                <div class="card-body">
                    @if(auth()->user()->isSeller())
                        <div class="text-muted">Silakan lihat menu Orders untuk detail transaksi. Fitur laporan pendapatan per produk bisa ditambahkan di dashboard.</div>
                    @elseif($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $index => $transaction)
                                        <tr class="{{ $index % 2 == 0 ? 'table-evenodd-light' : 'table-evenodd-white' }}">
                                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($transaction->type === 'topup')
                                                    <span class="badge bg-success">Top Up</span>
                                                @elseif($transaction->type === 'purchase')
                                                    <span class="badge bg-primary">Purchase</span>
                                                @else
                                                    <span class="badge bg-warning">Refund</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->type === 'topup')
                                                    <span class="text-success">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-danger">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->status === 'success')
                                                    <span class="badge bg-success">Success</span>
                                                @elseif($transaction->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="pagination-info">
                                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} results
                                </div>
                                {{ $transactions->links('pagination.bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5>No transactions yet</h5>
                            <p class="text-muted">Your transaction history will appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
