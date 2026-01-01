@extends('layouts.app')

@section('title', 'Pendapatan Seller - JajanGaming')

@section('content')
<div class="dashboard-wrapper">
    <!-- Dashboard Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-brand">
            <i class="fas fa-gamepad"></i>
            <span>JajanGaming</span>
        </div>
        
        <div class="sidebar-user">
            @if($seller->profile_photo)
                <img src="{{ asset('storage/' . $seller->profile_photo) }}" alt="Profile" class="sidebar-avatar">
            @else
                <div class="sidebar-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div class="sidebar-user-info">
                <h6>{{ $seller->name }}</h6>
                <span class="user-role">Penjual</span>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <a href="{{ route('seller.dashboard') }}" class="menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('seller.products.index') }}" class="menu-item">
                <i class="fas fa-cube"></i>
                <span>Produk Saya</span>
            </a>
            <a href="{{ route('seller.orders.index') }}" class="menu-item">
                <i class="fas fa-shopping-bag"></i>
                <span>Pesanan</span>
            </a>
            
            <div class="menu-label">Manajemen</div>
            <a href="{{ route('seller.products.create') }}" class="menu-item">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('seller.wallet') }}" class="menu-item active">
                <i class="fas fa-wallet"></i>
                <span>Pendapatan</span>
            </a>
            <a href="{{ route('seller.reports.index') }}" class="menu-item">
                <i class="fas fa-exclamation-circle"></i>
                <span>Laporan Saya</span>
                @php
                    $pendingReportsCount = \App\Models\Report::where('seller_id', auth()->user()->id)
                        ->where('status', 'pending')
                        ->count();
                @endphp
                @if($pendingReportsCount > 0)
                    <span class="menu-badge">{{ $pendingReportsCount }}</span>
                @endif
            </a>
            <a href="{{ route('seller.transactions') }}" class="menu-item">
                <i class="fas fa-receipt"></i>
                <span>Detail Transaksi</span>
            </a>
            <a href="{{ route('seller.profile') }}" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            
            <div class="menu-label">Navigasi</div>
            <a href="{{ route('home') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Kembali ke Toko</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="header-left">
                <h1>
                    <i class="fas fa-wallet"></i>
                    Pendapatan
                </h1>
                <p class="header-subtitle">Kelola dan pantau pendapatan penjualan Anda</p>
            </div>
        </div>

        @php
            use App\Models\Product;
            use App\Models\Order;
            use App\Models\OrderItem;
            use Illuminate\Support\Facades\DB;
            use Illuminate\Support\Facades\Schema;
            
            // Get seller's product IDs
            $sellerProductIds = Product::where(function($query) use ($seller) {
                if (Schema::hasColumn('products', 'seller_id')) {
                    $query->where('seller_id', $seller->id);
                } else {
                    $query->where('seller_name', $seller->name);
                }
            })->pluck('id');
            
            // Get orders that contain seller's products
            $sellerOrderIds = OrderItem::whereIn('product_id', $sellerProductIds)
                ->pluck('order_id')
                ->unique();
            
            // Calculate total revenue from completed orders
            $totalRevenue = OrderItem::whereIn('product_id', $sellerProductIds)
                ->whereHas('order', function($query) {
                    $query->where('status', 'completed');
                })
                ->sum(DB::raw('quantity * price'));
            
            // Get recent transactions (completed orders)
            $recentTransactions = Order::whereIn('id', $sellerOrderIds)
                ->where('status', 'completed')
                ->with(['user', 'orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        @endphp

        <!-- Balance Cards -->
        <div class="wallet-balance-section">
            <div class="wallet-balance-card">
                <div class="balance-header">
                    <div class="balance-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="balance-info">
                        <span class="balance-label">Total Pendapatan</span>
                        <h2 class="balance-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    </div>
                </div>
                <div class="balance-footer">
                    <span class="balance-note">
                        <i class="fas fa-info-circle"></i> Total dari semua penjualan yang selesai
                    </span>
                </div>
            </div>

            <div class="wallet-balance-card wallet-card-secondary">
                <div class="balance-header">
                    <div class="balance-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="balance-info">
                        <span class="balance-label">Saldo Dompet</span>
                        <h2 class="balance-amount">Rp {{ number_format($seller->wallet_balance ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
                <div class="balance-footer">
                    <span class="balance-note">
                        <i class="fas fa-check-circle"></i> Saldo yang dapat ditarik
                    </span>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="wallet-transactions-section">
            <div class="data-card">
                <div class="data-header">
                    <h4><i class="fas fa-history"></i> Riwayat Pendapatan</h4>
                </div>
                <div class="data-body">
                    @if($recentTransactions->count() > 0)
                        <div class="transaction-list">
                            @foreach($recentTransactions as $order)
                                @php
                                    // Get seller's products in this order
                                    $sellerOrderItems = $order->orderItems->filter(function($item) use ($sellerProductIds) {
                                        return $sellerProductIds->contains($item->product_id);
                                    });
                                    $sellerOrderTotal = $sellerOrderItems->sum(function($item) {
                                        return $item->quantity * $item->price;
                                    });
                                @endphp
                                <div class="transaction-item">
                                    <div class="transaction-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="transaction-details">
                                        <div class="transaction-title">
                                            Pesanan #{{ $order->id }} dari {{ $order->user->name }}
                                        </div>
                                        <div class="transaction-meta">
                                            <span><i class="fas fa-box"></i> {{ $sellerOrderItems->sum('quantity') }} item</span>
                                            <span><i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                        <div class="transaction-products">
                                            @foreach($sellerOrderItems->take(3) as $item)
                                                <span class="product-tag">{{ $item->product->name }} ({{ $item->quantity }})</span>
                                            @endforeach
                                            @if($sellerOrderItems->count() > 3)
                                                <span class="product-tag">+{{ $sellerOrderItems->count() - 3 }} lainnya</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="transaction-amount">
                                        <span class="amount-positive">+Rp {{ number_format($sellerOrderTotal, 0, ',', '.') }}</span>
                                        <span class="amount-status completed">Selesai</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada transaksi</p>
                            <small>Pendapatan akan muncul di sini setelah pesanan selesai</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Dashboard Layout */
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
    background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
}

.dashboard-sidebar {
    width: 280px;
    background: linear-gradient(180deg, #0f1a24 0%, #162030 100%);
    border-right: 1px solid rgba(100, 160, 180, 0.1);
    position: fixed;
    top: 76px;
    left: 0;
    height: calc(100vh - 76px);
    z-index: 1000;
    overflow-y: auto;
    transition: transform 0.3s ease;
}

.sidebar-brand {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    background: rgba(100, 160, 180, 0.05);
}

.sidebar-brand i {
    font-size: 28px;
    color: #64a0b4;
}

.sidebar-brand span {
    font-size: 1.3rem;
    font-weight: 700;
    color: #ffffff;
}

.sidebar-user {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
}

.sidebar-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid rgba(100, 160, 180, 0.3);
}

.sidebar-avatar-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.sidebar-user-info h6 {
    color: #ffffff;
    font-weight: 600;
    margin: 0;
    font-size: 0.95rem;
}

.sidebar-user-info .user-role {
    font-size: 0.75rem;
    color: #64a0b4;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-menu {
    padding: 15px 0;
}

.menu-label {
    padding: 15px 20px 8px;
    font-size: 0.7rem;
    color: rgba(100, 160, 180, 0.6);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-weight: 600;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 14px 20px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    gap: 14px;
}

.menu-item:hover {
    background: rgba(100, 160, 180, 0.1);
    color: #ffffff;
    border-left-color: rgba(100, 160, 180, 0.5);
}

.menu-item.active {
    background: rgba(100, 160, 180, 0.15);
    color: #64a0b4;
    border-left-color: #64a0b4;
}

.menu-item i {
    width: 20px;
    font-size: 1rem;
}

.menu-item span {
    font-size: 0.9rem;
    font-weight: 500;
}

.menu-badge {
    margin-left: auto;
    background: linear-gradient(135deg, #c47070 0%, #b05858 100%);
    color: white;
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 10px;
    font-weight: 600;
}

.dashboard-main {
    flex: 1;
    margin-left: 280px;
    padding: 30px;
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.header-left h1 {
    color: #ffffff;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-left h1 i {
    color: #64a0b4;
}

.header-subtitle {
    color: rgba(255, 255, 255, 0.5);
    margin: 8px 0 0;
    font-size: 0.95rem;
}

/* Wallet Balance Cards */
.wallet-balance-section {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    margin-bottom: 30px;
}

.wallet-balance-card {
    background: linear-gradient(135deg, #1a2a38 0%, #253545 100%);
    border-radius: 20px;
    padding: 32px;
    border: 2px solid rgba(100, 160, 180, 0.2);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.wallet-balance-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #64a0b4 0%, #5eb8c4 100%);
}

.wallet-card-secondary::before {
    background: linear-gradient(90deg, #5cb890 0%, #48a078 100%);
}

.wallet-balance-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(100, 160, 180, 0.2);
    border-color: rgba(100, 160, 180, 0.4);
}

.balance-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.balance-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    background: rgba(100, 160, 180, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #64a0b4;
    flex-shrink: 0;
}

.wallet-card-secondary .balance-icon {
    background: rgba(92, 184, 144, 0.2);
    color: #5cb890;
}

.balance-info {
    flex: 1;
}

.balance-label {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 8px;
}

.balance-amount {
    color: #ffffff;
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    line-height: 1.2;
    word-break: break-word;
}

.balance-footer {
    padding-top: 16px;
    border-top: 1px solid rgba(100, 160, 180, 0.1);
}

.balance-note {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
}

.balance-note i {
    color: #64a0b4;
}

/* Transaction List */
.wallet-transactions-section {
    margin-bottom: 30px;
}

.data-card {
    background: linear-gradient(145deg, #1a2a38 0%, #253545 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.15);
    overflow: hidden;
}

.data-header {
    padding: 18px 22px;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.data-header h4 {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.data-header h4 i {
    color: #64a0b4;
}

.data-body {
    padding: 20px;
}

.transaction-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.transaction-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px;
    background: rgba(100, 160, 180, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.transaction-item:hover {
    background: rgba(100, 160, 180, 0.1);
    border-color: rgba(100, 160, 180, 0.2);
    transform: translateX(5px);
}

.transaction-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(92, 184, 144, 0.2) 0%, rgba(92, 184, 144, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5cb890;
    font-size: 20px;
    flex-shrink: 0;
}

.transaction-details {
    flex: 1;
}

.transaction-title {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.transaction-meta {
    display: flex;
    gap: 16px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}

.transaction-meta span {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.transaction-meta i {
    color: #64a0b4;
    font-size: 0.75rem;
}

.transaction-products {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.product-tag {
    background: rgba(100, 160, 180, 0.15);
    color: #64a0b4;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

.transaction-amount {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 6px;
}

.amount-positive {
    color: #5cb890;
    font-size: 1.2rem;
    font-weight: 700;
}

.amount-status {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.amount-status.completed {
    background: rgba(92, 184, 144, 0.15);
    color: #5cb890;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: rgba(255, 255, 255, 0.4);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 16px;
    display: block;
    color: rgba(100, 160, 180, 0.3);
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 8px;
    color: rgba(255, 255, 255, 0.6);
}

.empty-state small {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.9rem;
}

@media (max-width: 992px) {
    .dashboard-sidebar {
        transform: translateX(-100%);
    }
    
    .dashboard-main {
        margin-left: 0;
        padding: 20px;
    }
    
    .wallet-balance-section {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .wallet-balance-card {
        padding: 24px;
    }
    
    .balance-amount {
        font-size: 2rem;
    }
    
    .transaction-item {
        flex-direction: column;
    }
    
    .transaction-amount {
        align-items: flex-start;
        width: 100%;
    }
}
</style>
@endsection
