@extends('layouts.app')

@section('title', 'My Wallet - JajanGaming')

@section('content')
<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'My Wallet'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
<style>
    .wallet-page {
        background: linear-gradient(180deg, #121a24 0%, #1a2a38 100%);
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.9) 0%, rgba(26, 42, 56, 0.9) 100%);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(100, 160, 180, 0.12);
        backdrop-filter: blur(10px);
    }

    .page-title {
        color: #ffffff;
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .page-title i { color: #64a0b4; font-size: 1.2rem; }

    .btn-back {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.8rem;
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Wallet Layout */
    .wallet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    /* Balance Card */
    .balance-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
        position: relative;
    }

    .balance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #64a0b4, #6fcf6f);
    }

    .balance-header {
        padding: 1.25rem;
        text-align: center;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
    }

    .balance-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(111, 207, 111, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.85rem;
    }

    .balance-icon i {
        color: #6fcf6f;
        font-size: 1.5rem;
    }

    .balance-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }

    .balance-amount {
        color: #6fcf6f;
        font-size: 1.75rem;
        font-weight: 800;
    }

    .balance-body {
        padding: 1.25rem;
    }

    /* Top Up Form */
    .topup-form .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 0.4rem;
    }

    .form-control {
        width: 100%;
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(100, 160, 180, 0.15);
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        color: #ffffff;
        font-size: 0.85rem;
        transition: all 0.25s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: rgba(100, 160, 180, 0.4);
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.1);
    }

    .form-hint {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.65rem;
        margin-top: 0.35rem;
    }

    .form-hint.warning {
        color: #f5c06a;
    }

    .form-hint.warning i {
        margin-right: 0.25rem;
    }

    .invalid-feedback {
        color: #e87a76;
        font-size: 0.7rem;
        margin-top: 0.3rem;
    }

    .btn-topup {
        width: 100%;
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        border: none;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .btn-topup:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(100, 160, 180, 0.3);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        margin-top: 0.65rem;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        box-shadow: none;
    }

    /* Info Card */
    .info-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
    }

    .info-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
        background: rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-header i { color: #64a0b4; font-size: 0.9rem; }
    .info-header h3 { color: #ffffff; font-size: 0.9rem; font-weight: 600; margin: 0; }

    .info-body {
        padding: 1.25rem;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
        padding: 0.5rem 0;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
    }

    .info-list li i {
        color: #6fcf6f;
        font-size: 0.7rem;
        margin-top: 0.2rem;
    }

    .seller-alert {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 10px;
        padding: 1rem;
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.8rem;
    }

    .seller-alert i {
        color: #64a0b4;
        margin-right: 0.5rem;
    }

    /* Transaction History */
    .history-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
    }

    .history-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
        background: rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .history-header i { color: #64a0b4; font-size: 0.9rem; }
    .history-header h3 { color: #ffffff; font-size: 0.9rem; font-weight: 600; margin: 0; }

    .history-body {
        padding: 0.5rem;
    }

    /* Transaction List */
    .transaction-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .transaction-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .transaction-item:hover {
        background: rgba(0, 0, 0, 0.25);
    }

    .transaction-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .transaction-icon.topup {
        background: rgba(111, 207, 111, 0.15);
        color: #6fcf6f;
    }

    .transaction-icon.purchase {
        background: rgba(100, 160, 180, 0.15);
        color: #7ab8c8;
    }

    .transaction-icon.refund {
        background: rgba(245, 192, 106, 0.15);
        color: #f5c06a;
    }

    .transaction-details {
        flex: 1;
        min-width: 0;
    }

    .transaction-type {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.8rem;
        margin-bottom: 0.15rem;
    }

    .transaction-desc {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.7rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .transaction-meta {
        text-align: right;
    }

    .transaction-amount {
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 0.15rem;
    }

    .transaction-amount.positive { color: #6fcf6f; }
    .transaction-amount.negative { color: #e87a76; }

    .transaction-date {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.65rem;
    }

    .transaction-status {
        display: inline-block;
        padding: 0.15rem 0.4rem;
        border-radius: 6px;
        font-size: 0.55rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .transaction-status.success { background: rgba(111, 207, 111, 0.2); color: #6fcf6f; }
    .transaction-status.pending { background: rgba(245, 192, 106, 0.2); color: #f5c06a; }
    .transaction-status.failed { background: rgba(232, 122, 118, 0.2); color: #e87a76; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1.5rem;
    }

    .empty-state i {
        font-size: 2.5rem;
        color: rgba(100, 160, 180, 0.2);
        margin-bottom: 0.85rem;
    }

    .empty-state h4 {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        margin-bottom: 0.35rem;
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.8rem;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1rem 1.25rem;
        border-top: 1px solid rgba(100, 160, 180, 0.08);
    }

    .pagination-info {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.7rem;
        margin-bottom: 0.65rem;
        text-align: center;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.3rem;
    }

    .page-link {
        background: rgba(100, 160, 180, 0.08);
        border: 1px solid rgba(100, 160, 180, 0.15);
        color: rgba(255, 255, 255, 0.6);
        border-radius: 7px;
        padding: 0.35rem 0.7rem;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background: rgba(100, 160, 180, 0.15);
        color: #ffffff;
    }

    .page-item.active .page-link {
        background: #64a0b4;
        border-color: #64a0b4;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .wallet-page { padding: 1rem 0; }
        .page-header { padding: 1rem; flex-direction: column; gap: 0.75rem; }
        .wallet-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="wallet-page">
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="page-title">
                <i class="fas fa-wallet"></i>
                {{ auth()->user()->isSeller() ? 'Dompet Penghasilan' : 'My Wallet' }}
            </h1>
            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Home
            </a>
        </div>

        <div class="wallet-grid">
            <!-- Balance Card -->
            <div class="balance-card">
                <div class="balance-header">
                    <div class="balance-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="balance-label">
                        {{ auth()->user()->isSeller() ? 'Total Revenue' : 'Current Balance' }}
                    </div>
                    <div class="balance-amount">
                        @if(auth()->user()->isSeller())
                            Rp {{ number_format(\App\Models\Order::whereHas('orderItems.product', function($q){ $q->where('seller_name', auth()->user()->name); })->where('status','completed')->sum('total_amount'), 0, ',', '.') }}
                        @else
                            Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}
                        @endif
                    </div>
                </div>
                <div class="balance-body">
                    @if(!auth()->user()->isSeller())
                    <form action="{{ route('wallet.topup') }}" method="POST" class="topup-form">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Top Up Amount</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   name="amount" min="10000" step="1000" 
                                   value="{{ $requiredAmount ?? '' }}" 
                                   placeholder="Minimum Rp 10,000" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($requiredAmount)
                                <div class="form-hint warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    You need at least Rp {{ number_format($requiredAmount, 0, ',', '.') }} to complete your order.
                                </div>
                            @else
                                <div class="form-hint">Minimum top up: Rp 10,000</div>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn-topup">
                            <i class="fas fa-plus"></i> Top Up Wallet
                        </button>
                        
                        @if($requiredAmount)
                        <a href="{{ route('cart.index') }}" class="btn-topup btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                        @endif
                    </form>
                    @else
                    <div class="seller-alert">
                        <i class="fas fa-info-circle"></i>
                        Pendapatan dihitung dari total order selesai (completed). Untuk detail transaksi, gunakan laporan order.
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="info-card">
                <div class="info-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>{{ auth()->user()->isSeller() ? 'Informasi Pendapatan' : 'Wallet Information' }}</h3>
                </div>
                <div class="info-body">
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Secure wallet system</span>
                        </li>
                        @if(!auth()->user()->isSeller())
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Instant top up processing</span>
                        </li>
                        @endif
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Use for purchases or withdrawals</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Transaction history tracking</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>24/7 support available</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="history-card">
            <div class="history-header">
                <i class="fas fa-history"></i>
                <h3>{{ auth()->user()->isSeller() ? 'Ringkasan Order Selesai' : 'Transaction History' }}</h3>
            </div>
            <div class="history-body">
                @if(auth()->user()->isSeller())
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h4>View Orders Menu</h4>
                    <p>Silakan lihat menu Orders untuk detail transaksi</p>
                </div>
                @elseif(isset($transactions) && $transactions->count() > 0)
                <div class="transaction-list">
                    @foreach($transactions as $transaction)
                    <div class="transaction-item">
                        <div class="transaction-icon {{ $transaction->type }}">
                            @if($transaction->type === 'topup')
                                <i class="fas fa-plus"></i>
                            @elseif($transaction->type === 'purchase')
                                <i class="fas fa-shopping-cart"></i>
                            @else
                                <i class="fas fa-undo"></i>
                            @endif
                        </div>
                        <div class="transaction-details">
                            <div class="transaction-type">
                                @if($transaction->type === 'topup')
                                    Top Up
                                @elseif($transaction->type === 'purchase')
                                    Purchase
                                @else
                                    Refund
                                @endif
                            </div>
                            <div class="transaction-desc">{{ $transaction->description }}</div>
                        </div>
                        <div class="transaction-meta">
                            <div class="transaction-amount {{ $transaction->type === 'topup' ? 'positive' : 'negative' }}">
                                {{ $transaction->type === 'topup' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </div>
                            <div class="transaction-date">{{ $transaction->created_at->format('M d, H:i') }}</div>
                            <span class="transaction-status {{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($transactions->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} results
                    </div>
                    {{ $transactions->links('pagination.bootstrap-5') }}
                </div>
                @endif
                @else
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <h4>No Transactions Yet</h4>
                    <p>Your transaction history will appear here</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
