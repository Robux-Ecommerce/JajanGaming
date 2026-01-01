@extends('layouts.app')

@section('title', 'Seller Dashboard - JajanGaming')

@section('content')
<div class="dashboard-wrapper">
    <!-- Dashboard Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-brand">
            <i class="fas fa-gamepad"></i>
            <span>JajanGaming</span>
        </div>
        
        <div class="sidebar-user">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="sidebar-avatar">
            @else
                <div class="sidebar-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            <div class="sidebar-user-info">
                <h6>{{ $user->name }}</h6>
                <span class="user-role">{{ $user->isAdmin() ? 'Administrator' : ($user->isSeller() ? 'Penjual' : 'Pelanggan') }}</span>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <a href="{{ route('seller.dashboard') }}" class="menu-item active">
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
                @if($stats['pending_orders'] > 0)
                    <span class="menu-badge">{{ $stats['pending_orders'] }}</span>
                @endif
            </a>
            
            <div class="menu-label">Manajemen</div>
            <a href="{{ route('seller.products.create') }}" class="menu-item">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('seller.wallet') }}" class="menu-item">
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
        <!-- Mobile Toggle -->
        <button class="mobile-sidebar-toggle" id="mobileSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="header-left">
                <h1>
                    <i class="fas fa-tachometer-alt"></i>
                    Dasbor Penjual
                </h1>
                <p class="header-subtitle">Selamat datang kembali, {{ $user->name }}! Berikut adalah ringkasan penjualan Anda.</p>
            </div>
            <div class="header-right">
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </div>

        <!-- Financial Cards Section - Di Atas Sendiri -->
        <div class="financial-cards-section">
            <div class="financial-cards-grid">
                <a href="{{ route('seller.wallet') }}" class="financial-card financial-card-revenue" style="text-decoration: none; color: inherit;">
                    <div class="financial-header">
                        <div class="financial-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="financial-label">Total Pendapatan</span>
                    </div>
                    <div class="financial-amount">
                        <h2>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h2>
                    </div>
                    <div class="financial-footer">
                        <span class="financial-trend">
                            <i class="fas fa-arrow-up"></i> Total dari semua penjualan
                        </span>
                    </div>
                </a>
                
                <a href="{{ route('seller.wallet') }}" class="financial-card financial-card-wallet" style="text-decoration: none; color: inherit;">
                    <div class="financial-header">
                        <div class="financial-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <span class="financial-label">Saldo Dompet</span>
                    </div>
                    <div class="financial-amount">
                        <h2>Rp {{ number_format($seller->wallet_balance ?? 0, 0, ',', '.') }}</h2>
                    </div>
                    <div class="financial-footer">
                        <span class="financial-trend">
                            <i class="fas fa-coins"></i> Saldo tersedia
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Seller Stats Cards - Rounded Design -->
        <div class="seller-stats-section">
            <div class="seller-stats-grid">
                <!-- Total Products -->
                <a href="{{ route('seller.products.index') }}" class="seller-stat-card seller-stat-products">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>{{ number_format($stats['total_products']) }}</h3>
                        <p>Produk Aktif</p>
                    </div>
                </a>

                <!-- Total Orders -->
                <a href="{{ route('seller.orders.index') }}" class="seller-stat-card seller-stat-orders">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>{{ number_format($stats['total_orders']) }}</h3>
                        <p>Total Pesanan</p>
                    </div>
                </a>

                <!-- Average Rating -->
                <div class="seller-stat-card seller-stat-rating">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>{{ number_format($stats['average_rating'], 1) }}</h3>
                        <p>Rating Rata-rata</p>
                        <small>{{ number_format($stats['total_ratings']) }} ulasan</small>
                    </div>
                </div>

                <!-- Customer Satisfaction -->
                <div class="seller-stat-card seller-stat-satisfaction">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-smile"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>{{ number_format($stats['customer_satisfaction'], 1) }}%</h3>
                        <p>Kepuasan Pelanggan</p>
                        <small>Rating 4-5 bintang</small>
                    </div>
                </div>

                <!-- Unique Customers -->
                <div class="seller-stat-card seller-stat-customers">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>{{ number_format($stats['unique_customers']) }}</h3>
                        <p>Pelanggan Unik</p>
                    </div>
                </div>

                <!-- Average Order Value -->
                <div class="seller-stat-card seller-stat-avg-order">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</h3>
                        <p>Nilai Pesanan Rata-rata</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Summary -->
        <div class="order-summary-section">
            <div class="order-summary-grid">
                <div class="order-summary-card order-pending">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h4>{{ number_format($stats['pending_orders']) }}</h4>
                        <span>Pending</span>
                    </div>
                </div>
                <div class="order-summary-card order-completed">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <h4>{{ number_format($stats['completed_orders']) }}</h4>
                        <span>Selesai</span>
                    </div>
                </div>
                <div class="order-summary-card order-cancelled">
                    <i class="fas fa-times-circle"></i>
                    <div>
                        <h4>{{ number_format($stats['cancelled_orders']) }}</h4>
                        <span>Dibatalkan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section - Seller Specific -->
        <div class="seller-charts-grid">
            <div class="seller-chart-card seller-chart-large">
                <div class="seller-chart-header">
                    <h4><i class="fas fa-chart-line"></i> Tren Pendapatan Bulanan</h4>
                    <span class="seller-chart-badge">Tahun {{ date('Y') }}</span>
                </div>
                <div class="seller-chart-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            
            <div class="seller-chart-card">
                <div class="seller-chart-header">
                    <h4><i class="fas fa-gamepad"></i> Produk per Game</h4>
                </div>
                <div class="seller-chart-body">
                    <canvas id="productsByGameChart"></canvas>
                </div>
            </div>
            
            <div class="seller-chart-card">
                <div class="seller-chart-header">
                    <h4><i class="fas fa-chart-pie"></i> Distribusi Status</h4>
                </div>
                <div class="seller-chart-body">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Tables Section -->
        <div class="tables-grid">
            <!-- Recent Orders -->
            <div class="data-card">
                <div class="data-header">
                    <h4><i class="fas fa-history"></i> Pesanan Terbaru</h4>
                    <a href="{{ route('seller.orders.index') }}" class="view-all-btn">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="data-body">
                    <div class="table-responsive">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders as $order)
                                <tr>
                                    <td><span class="order-id">#{{ $order->id }}</span></td>
                                    <td>
                                        <div class="customer-info">
                                            <span class="customer-name">{{ $order->user->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></td>
                                    <td>
                                        <span class="status-badge {{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td><span class="date">{{ $order->created_at->format('d M Y') }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>Tidak ada pesanan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="data-card">
                <div class="data-header">
                    <h4><i class="fas fa-fire"></i> Produk Terlaris</h4>
                    <a href="{{ route('seller.products.index') }}" class="view-all-btn">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="data-body">
                    <div class="top-products-list">
                        @forelse($top_products as $index => $product)
                        <div class="product-item">
                            <span class="product-rank">#{{ $index + 1 }}</span>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <div class="product-image" style="background: rgba(100, 160, 180, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="product-info">
                                <h6>{{ $product->name }}</h6>
                                <span class="product-sales">{{ number_format($product->sales_count) }} sold</span>
                            </div>
                            <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-cube"></i>
                            <p>No products found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Performance Section -->
        <div class="product-performance-section">
            <div class="performance-grid">
                <div class="performance-chart-card">
                    <div class="performance-header">
                        <h4><i class="fas fa-chart-bar"></i> Performa Penjualan</h4>
                    </div>
                    <div class="performance-body">
                        <canvas id="salesPerformanceChart"></canvas>
                    </div>
                </div>
                
                <div class="performance-info-card">
                    <div class="performance-header">
                        <h4><i class="fas fa-trophy"></i> Produk Terlaris</h4>
                    </div>
                    <div class="performance-body">
                        <div class="top-products-mini">
                            @forelse($top_products->take(3) as $index => $product)
                            <div class="top-product-mini-item">
                                <span class="mini-rank">#{{ $index + 1 }}</span>
                                <div class="mini-product-info">
                                    <h6>{{ Str::limit($product->name, 20) }}</h6>
                                    <span>{{ number_format($product->sales_count) }} terjual</span>
                                </div>
                                <span class="mini-rating">
                                    <i class="fas fa-star"></i> {{ number_format($product->rating, 1) }}
                                </span>
                            </div>
                            @empty
                            <div class="empty-mini">
                                <i class="fas fa-box-open"></i>
                                <p>Belum ada produk</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
            <div class="actions-grid">
                <a href="{{ route('seller.products.create') }}" class="action-card add-product">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Produk</span>
                </a>
                <a href="{{ route('seller.products.index') }}" class="action-card manage-products">
                    <i class="fas fa-boxes"></i>
                    <span>Kelola Produk</span>
                </a>
                <a href="{{ route('seller.orders.index') }}" class="action-card view-orders">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Lihat Pesanan</span>
                </a>
                <a href="{{ route('seller.wallet') }}" class="action-card wallet">
                    <i class="fas fa-wallet"></i>
                    <span>Pendapatan</span>
                </a>
            </div>
        </div>
    </main>
</div>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
/* ===== Dashboard Layout ===== */
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
    background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
}

/* ===== Dashboard Sidebar ===== */
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
    scrollbar-width: thin;
    scrollbar-color: rgba(100, 160, 180, 0.2) transparent;
}

.dashboard-sidebar::-webkit-scrollbar {
    width: 6px;
}

.dashboard-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.dashboard-sidebar::-webkit-scrollbar-thumb {
    background: rgba(100, 160, 180, 0.2);
    border-radius: 3px;
}

.dashboard-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(100, 160, 180, 0.4);
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
    letter-spacing: -0.5px;
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

/* ===== Main Content ===== */
.dashboard-main {
    flex: 1;
    margin-left: 280px;
    padding: 30px;
    min-height: 100vh;
}

.mobile-sidebar-toggle {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1050;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    border: none;
    color: white;
    width: 45px;
    height: 45px;
    border-radius: 12px;
    font-size: 1.2rem;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
}

/* ===== Dashboard Header ===== */
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

.header-date {
    background: rgba(100, 160, 180, 0.1);
    padding: 10px 18px;
    border-radius: 10px;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(100, 160, 180, 0.15);
}

.header-date i {
    color: #64a0b4;
}

/* ===== Stats Grid ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.stat-card {
    background: linear-gradient(145deg, #1a2a38 0%, #253545 100%);
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    border: 1px solid rgba(100, 160, 180, 0.15);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
}

.stat-card.stat-primary::before { background: linear-gradient(180deg, #64a0b4 0%, #508ca0 100%); }
.stat-card.stat-success::before { background: linear-gradient(180deg, #5cb890 0%, #48a078 100%); }
.stat-card.stat-info::before { background: linear-gradient(180deg, #5eb8c4 0%, #4aa0ac 100%); }
.stat-card.stat-warning::before { background: linear-gradient(180deg, #c9a856 0%, #b59042 100%); }

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(100, 160, 180, 0.3);
}

.stat-card-clickable {
    cursor: pointer;
}

.stat-card-clickable::before {
    background: linear-gradient(180deg, #c9a856 0%, #b59042 100%);
}

.stat-card-clickable .stat-icon {
    background: rgba(201, 168, 86, 0.15);
    color: #c9a856;
}

.stat-card-clickable:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(201, 168, 86, 0.3);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-primary .stat-icon { background: rgba(100, 160, 180, 0.15); color: #64a0b4; }
.stat-success .stat-icon { background: rgba(92, 184, 144, 0.15); color: #5cb890; }
.stat-info .stat-icon { background: rgba(94, 184, 196, 0.15); color: #5eb8c4; }
.stat-warning .stat-icon { background: rgba(201, 168, 86, 0.15); color: #c9a856; }

.stat-content h3 {
    color: #ffffff;
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0;
}

.stat-content p {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.85rem;
    margin: 4px 0 0;
}

.stat-trend {
    margin-left: auto;
    font-size: 0.8rem;
    padding: 5px 10px;
    border-radius: 8px;
}

.stat-trend.up {
    background: rgba(92, 184, 144, 0.15);
    color: #5cb890;
}

/* ===== Seller Stats Cards - Rounded Design ===== */
.seller-stats-section {
    margin-bottom: 30px;
}

.seller-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.seller-stat-card {
    background: linear-gradient(145deg, #1e2d3a 0%, #2a3d4e 100%);
    border-radius: 20px;
    padding: 28px;
    display: flex;
    align-items: center;
    gap: 20px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
}

.seller-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.05) 0%, rgba(100, 160, 180, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.seller-stat-card:hover::before {
    opacity: 1;
}

.seller-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
}

.seller-stat-products {
    border-color: rgba(100, 160, 180, 0.3);
}

.seller-stat-products:hover {
    border-color: rgba(100, 160, 180, 0.6);
    box-shadow: 0 15px 40px rgba(100, 160, 180, 0.2);
}

.seller-stat-orders {
    border-color: rgba(92, 184, 144, 0.3);
}

.seller-stat-orders:hover {
    border-color: rgba(92, 184, 144, 0.6);
    box-shadow: 0 15px 40px rgba(92, 184, 144, 0.2);
}

.seller-stat-rating {
    border-color: rgba(255, 193, 7, 0.3);
}

.seller-stat-rating:hover {
    border-color: rgba(255, 193, 7, 0.6);
    box-shadow: 0 15px 40px rgba(255, 193, 7, 0.2);
}

.seller-stat-satisfaction {
    border-color: rgba(156, 39, 176, 0.3);
}

.seller-stat-satisfaction:hover {
    border-color: rgba(156, 39, 176, 0.6);
    box-shadow: 0 15px 40px rgba(156, 39, 176, 0.2);
}

.seller-stat-customers {
    border-color: rgba(33, 150, 243, 0.3);
}

.seller-stat-customers:hover {
    border-color: rgba(33, 150, 243, 0.6);
    box-shadow: 0 15px 40px rgba(33, 150, 243, 0.2);
}

.seller-stat-avg-order {
    border-color: rgba(255, 152, 0, 0.3);
}

.seller-stat-avg-order:hover {
    border-color: rgba(255, 152, 0, 0.6);
    box-shadow: 0 15px 40px rgba(255, 152, 0, 0.2);
}

.seller-stat-icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.seller-stat-products .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.25) 0%, rgba(100, 160, 180, 0.15) 100%);
    color: #64a0b4;
}

.seller-stat-orders .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(92, 184, 144, 0.25) 0%, rgba(92, 184, 144, 0.15) 100%);
    color: #5cb890;
}

.seller-stat-rating .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.25) 0%, rgba(255, 193, 7, 0.15) 100%);
    color: #ffc107;
}

.seller-stat-satisfaction .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(156, 39, 176, 0.25) 0%, rgba(156, 39, 176, 0.15) 100%);
    color: #9c27b0;
}

.seller-stat-customers .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(33, 150, 243, 0.25) 0%, rgba(33, 150, 243, 0.15) 100%);
    color: #2196f3;
}

.seller-stat-avg-order .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(255, 152, 0, 0.25) 0%, rgba(255, 152, 0, 0.15) 100%);
    color: #ff9800;
}

.seller-stat-content {
    flex: 1;
    position: relative;
    z-index: 1;
}

.seller-stat-content h3 {
    color: #ffffff;
    font-size: 2rem;
    font-weight: 800;
    margin: 0 0 8px 0;
    line-height: 1;
}

.seller-stat-content p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0;
}

.seller-stat-content small {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.75rem;
    display: block;
    margin-top: 4px;
}

/* ===== Order Summary Cards ===== */
.order-summary-section {
    margin-bottom: 30px;
}

.order-summary-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.order-summary-card {
    background: linear-gradient(145deg, #1e2d3a 0%, #2a3d4e 100%);
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.order-summary-card i {
    font-size: 36px;
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.order-pending {
    border-color: rgba(201, 168, 86, 0.3);
}

.order-pending i {
    background: rgba(201, 168, 86, 0.2);
    color: #c9a856;
}

.order-completed {
    border-color: rgba(92, 184, 144, 0.3);
}

.order-completed i {
    background: rgba(92, 184, 144, 0.2);
    color: #5cb890;
}

.order-cancelled {
    border-color: rgba(196, 112, 112, 0.3);
}

.order-cancelled i {
    background: rgba(196, 112, 112, 0.2);
    color: #c47070;
}

.order-summary-card h4 {
    color: #ffffff;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
}

.order-summary-card span {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
}

/* ===== Seller Charts ===== */
.seller-charts-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.seller-chart-card {
    background: linear-gradient(145deg, #1e2d3a 0%, #2a3d4e 100%);
    border-radius: 20px;
    border: 2px solid rgba(100, 160, 180, 0.15);
    overflow: hidden;
}

.seller-chart-large {
    grid-column: span 1;
}

.seller-chart-header {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(100, 160, 180, 0.05);
}

.seller-chart-header h4 {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.seller-chart-header h4 i {
    color: #64a0b4;
}

.seller-chart-badge {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.6);
    padding: 4px 12px;
    border-radius: 12px;
    background: rgba(100, 160, 180, 0.15);
}

.seller-chart-body {
    padding: 24px;
    height: 280px;
}

/* ===== Product Performance Section ===== */
.product-performance-section {
    margin-bottom: 25px;
}

.performance-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.performance-chart-card,
.performance-info-card {
    background: linear-gradient(145deg, #1e2d3a 0%, #2a3d4e 100%);
    border-radius: 20px;
    border: 2px solid rgba(100, 160, 180, 0.15);
    overflow: hidden;
}

.performance-header {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    background: rgba(100, 160, 180, 0.05);
}

.performance-header h4 {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.performance-header h4 i {
    color: #64a0b4;
}

.performance-body {
    padding: 24px;
}

.performance-body canvas {
    height: 300px !important;
}

.top-products-mini {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.top-product-mini-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px;
    border-radius: 12px;
    background: rgba(100, 160, 180, 0.05);
    transition: all 0.3s ease;
}

.top-product-mini-item:hover {
    background: rgba(100, 160, 180, 0.1);
}

.mini-rank {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
    font-weight: 700;
    flex-shrink: 0;
}

.mini-product-info {
    flex: 1;
}

.mini-product-info h6 {
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0 0 4px 0;
}

.mini-product-info span {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

.mini-rating {
    font-weight: 600;
    color: #ffc107;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.empty-mini {
    text-align: center;
    padding: 40px 20px;
    color: rgba(255, 255, 255, 0.4);
}

.empty-mini i {
    font-size: 2.5rem;
    margin-bottom: 12px;
    display: block;
}

/* ===== Financial Cards Grid ===== */
.financial-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    margin-bottom: 30px;
}

.financial-card {
    background: linear-gradient(135deg, #1a2a38 0%, #253545 100%);
    border-radius: 18px;
    padding: 32px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    border: 2px solid rgba(100, 160, 180, 0.2);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    text-decoration: none !important;
    color: inherit !important;
}

.financial-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #64a0b4 0%, #5eb8c4 100%);
}

.financial-card-revenue::before {
    background: linear-gradient(90deg, #5cb890 0%, #48a078 100%);
}

.financial-card-wallet::before {
    background: linear-gradient(90deg, #64a0b4 0%, #5eb8c4 100%);
}

.financial-card-seller::before {
    background: linear-gradient(90deg, #c9a856 0%, #b59042 100%);
}

.financial-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(100, 160, 180, 0.2);
    border-color: rgba(100, 160, 180, 0.4);
}

.financial-card-revenue:hover {
    border-color: rgba(92, 184, 144, 0.4);
    box-shadow: 0 20px 50px rgba(92, 184, 144, 0.15);
}

.financial-card-wallet:hover {
    border-color: rgba(100, 160, 180, 0.4);
    box-shadow: 0 20px 50px rgba(100, 160, 180, 0.15);
}

.financial-card-seller:hover {
    border-color: rgba(201, 168, 86, 0.4);
    box-shadow: 0 20px 50px rgba(201, 168, 86, 0.15);
}

.financial-header {
    display: flex;
    align-items: center;
    gap: 16px;
}

.financial-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.financial-card-revenue .financial-icon {
    background: rgba(92, 184, 144, 0.2);
    color: #5cb890;
}

.financial-card-wallet .financial-icon {
    background: rgba(100, 160, 180, 0.2);
    color: #64a0b4;
}

.financial-card-seller .financial-icon {
    background: rgba(201, 168, 86, 0.2);
    color: #c9a856;
}

.financial-card:hover .financial-icon {
    transform: scale(1.1);
}

.financial-label {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.95rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.financial-amount h2 {
    color: #ffffff;
    font-size: 2.2rem;
    font-weight: 800;
    margin: 0;
    line-height: 1.2;
    word-break: break-word;
}

.financial-footer {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-top: 12px;
    border-top: 1px solid rgba(100, 160, 180, 0.1);
}

.financial-trend {
    display: flex;
    align-items: center;
    gap: 6px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.financial-card-revenue .financial-trend {
    color: #5cb890;
}

.financial-card-wallet .financial-trend {
    color: #64a0b4;
}

.financial-card-seller .financial-trend {
    color: #c9a856;
}

/* ===== Order Status Grid ===== */
.order-status-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 25px;
}

.order-status-card {
    background: linear-gradient(145deg, #1a2a38 0%, #253545 100%);
    border-radius: 14px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.order-status-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.status-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.order-status-card.pending .status-icon { background: rgba(201, 168, 86, 0.15); color: #c9a856; }
.order-status-card.processing .status-icon { background: rgba(100, 160, 180, 0.15); color: #64a0b4; }
.order-status-card.completed .status-icon { background: rgba(92, 184, 144, 0.15); color: #5cb890; }
.order-status-card.cancelled .status-icon { background: rgba(196, 112, 112, 0.15); color: #c47070; }

.status-content {
    display: flex;
    flex-direction: column;
}

.status-count {
    font-size: 1.4rem;
    font-weight: 700;
    color: #ffffff;
}

.status-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
}

/* ===== Charts Grid ===== */
.charts-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.chart-card {
    background: linear-gradient(145deg, #1a2a38 0%, #253545 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.15);
    overflow: hidden;
}

.chart-card.large {
    grid-column: span 1;
}

.chart-header {
    padding: 18px 22px;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-header h4 {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chart-header h4 i {
    color: #64a0b4;
}

.chart-period span {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    padding: 5px 12px;
    border-radius: 8px;
    background: rgba(100, 160, 180, 0.1);
}

.chart-period span.active {
    background: rgba(100, 160, 180, 0.2);
    color: #64a0b4;
}

.chart-body {
    padding: 20px;
    height: 250px;
}

/* ===== Data Tables ===== */
.tables-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
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

.view-all-btn {
    font-size: 0.8rem;
    color: #64a0b4;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    color: #82b8c8;
}

.data-body {
    padding: 20px;
}

/* Dashboard Table */
.dashboard-table {
    width: 100%;
    border-collapse: collapse;
}

.dashboard-table thead th {
    text-align: left;
    padding: 12px 15px;
    font-size: 0.75rem;
    color: rgba(100, 160, 180, 0.8);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    border-bottom: 1px solid rgba(100, 160, 180, 0.15);
}

.dashboard-table tbody td {
    padding: 14px 15px;
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.9rem;
    border-bottom: 1px solid rgba(100, 160, 180, 0.08);
}

.dashboard-table tbody tr:hover {
    background: rgba(100, 160, 180, 0.05);
}

.order-id {
    font-weight: 600;
    color: #64a0b4;
}

.customer-name {
    font-weight: 500;
}

.amount {
    font-weight: 600;
    color: #5cb890;
}

.date {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.85rem;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.pending {
    background: rgba(201, 168, 86, 0.15);
    color: #c9a856;
}

.status-badge.completed {
    background: rgba(92, 184, 144, 0.15);
    color: #5cb890;
}

.status-badge.cancelled {
    background: rgba(196, 112, 112, 0.15);
    color: #c47070;
}

.status-badge.processing {
    background: rgba(100, 160, 180, 0.15);
    color: #64a0b4;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: rgba(255, 255, 255, 0.4);
}

.empty-state i {
    font-size: 2.5rem;
    margin-bottom: 12px;
    display: block;
}

/* Top Products */
.top-products-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.product-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px;
    border-radius: 12px;
    background: rgba(100, 160, 180, 0.05);
    transition: all 0.3s ease;
}

.product-item:hover {
    background: rgba(100, 160, 180, 0.1);
}

.product-rank {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
}

.product-image {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid rgba(100, 160, 180, 0.2);
}

.product-info {
    flex: 1;
}

.product-info h6 {
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0;
}

.product-sales {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

.product-price {
    font-weight: 600;
    color: #5cb890;
    font-size: 0.9rem;
}

/* Admin Section */
.admin-section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.quick-stats-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.quick-stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-radius: 12px;
    background: rgba(100, 160, 180, 0.05);
}

.quick-stat-item i {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(100, 160, 180, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64a0b4;
    font-size: 1rem;
}

.stat-details {
    display: flex;
    flex-direction: column;
}

.stat-details .stat-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
}

.stat-details .stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

/* Quick Actions */
.quick-actions-section {
    margin-bottom: 30px;
}

.quick-actions-section h4 {
    color: #ffffff;
    font-size: 1.1rem;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.quick-actions-section h4 i {
    color: #c9a856;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.action-card {
    background: linear-gradient(145deg, #1a2a38 0%, #253545 100%);
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    text-decoration: none;
    border: 1px solid rgba(100, 160, 180, 0.15);
    transition: all 0.3s ease;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.action-card i {
    font-size: 2rem;
    margin-bottom: 12px;
    display: block;
}

.action-card span {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9rem;
}

.action-card.add-product i { color: #5cb890; }
.action-card.add-product:hover { border-color: rgba(92, 184, 144, 0.4); }

.action-card.manage-products i { color: #64a0b4; }
.action-card.manage-products:hover { border-color: rgba(100, 160, 180, 0.4); }

.action-card.view-orders i { color: #c9a856; }
.action-card.view-orders:hover { border-color: rgba(201, 168, 86, 0.4); }

.action-card.manage-users i { color: #9878b8; }
.action-card.manage-users:hover { border-color: rgba(152, 120, 184, 0.4); }

.action-card.wallet i { color: #5eb8c4; }
.action-card.wallet:hover { border-color: rgba(94, 184, 196, 0.4); }

/* Mobile Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1090;
}

.sidebar-overlay.show {
    display: block;
}

/* Responsive */
@media (max-width: 1200px) {
    .seller-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .seller-charts-grid {
        grid-template-columns: 1fr;
    }
    
    .performance-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .financial-cards-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .financial-card {
        padding: 28px;
    }
    
    .financial-amount h2 {
        font-size: 1.9rem;
    }
    
    .order-status-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
    }
    
    .tables-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-section {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 992px) {
    .dashboard-sidebar {
        transform: translateX(-100%);
    }
    
    .dashboard-sidebar.show {
        transform: translateX(0);
    }
    
    .dashboard-main {
        margin-left: 0;
        padding: 20px;
    }
    
    .mobile-sidebar-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .dashboard-header {
        padding-top: 60px;
    }
    
    .seller-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .order-summary-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .financial-cards-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .financial-card {
        padding: 24px;
    }
    
    .financial-amount h2 {
        font-size: 1.7rem;
    }
    
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .seller-stats-grid,
    .order-summary-grid,
    .stats-grid,
    .order-status-grid,
    .financial-cards-grid,
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .seller-stat-card {
        padding: 20px;
    }
    
    .seller-stat-icon-wrapper {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
    
    .seller-stat-content h3 {
        font-size: 1.6rem;
    }
    
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-left h1 {
        font-size: 1.4rem;
    }
    
    .stat-card {
        padding: 18px;
    }
    
    .stat-content h3 {
        font-size: 1.3rem;
    }
    
    .financial-card {
        padding: 20px;
    }
    
    .financial-icon {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
    
    .financial-amount h2 {
        font-size: 1.5rem;
    }
    
    .financial-header {
        gap: 12px;
    }
    
    .financial-label {
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .dashboard-wrapper {
        flex-direction: column;
    }
    
    .dashboard-main {
        padding: 15px;
    }
    
    .stats-grid {
        gap: 15px;
    }
    
    .financial-cards-grid {
        gap: 15px;
    }
    
    .financial-card {
        padding: 18px;
    }
    
    .financial-icon {
        width: 55px;
        height: 55px;
        font-size: 24px;
    }
    
    .financial-amount h2 {
        font-size: 1.3rem;
    }
    
    .stat-card {
        padding: 16px;
        gap: 12px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .stat-content h3 {
        font-size: 1.2rem;
    }
    
    .order-status-card {
        padding: 12px 15px;
        gap: 12px;
    }
}

@media (max-width: 375px) {
    .dashboard-main {
        padding: 12px;
    }
    
    .stats-grid {
        gap: 12px;
    }
    
    .financial-cards-grid {
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .financial-card {
        padding: 16px;
        gap: 16px;
    }
    
    .financial-icon {
        width: 50px;
        height: 50px;
        font-size: 22px;
    }
    
    .financial-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .financial-amount h2 {
        font-size: 1.2rem;
    }
    
    .financial-label {
        font-size: 0.8rem;
    }
    
    .stat-card {
        padding: 14px;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .stat-icon {
        width: 45px;
        height: 45px;
        font-size: 18px;
    }
    
    .stat-content h3 {
        font-size: 1.1rem;
    }
    
    .stat-content p {
        font-size: 0.75rem;
    }
    
    .stat-trend {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
}
</style>

@php
    $months = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
    $revenueSeries = array_fill(1, 12, 0);
    foreach ($monthly_revenue as $row) {
        $revenueSeries[(int)$row->month] = (int)$row->revenue;
    }
    $ordersSeries = array_fill(1, 12, 0);
    foreach ($monthly_orders as $row) {
        $ordersSeries[(int)$row->month] = (int)$row->orders_count;
    }
    
    // Prepare products by game type data
    $productsByGameType = $productsByGameType ?? collect([]);
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mobile sidebar toggle
    const sidebar = document.getElementById('dashboardSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mobileToggle = document.getElementById('mobileSidebarToggle');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    // Chart.js default settings
    Chart.defaults.color = 'rgba(255, 255, 255, 0.6)';
    Chart.defaults.borderColor = 'rgba(100, 160, 180, 0.1)';
    
    const monthLabels = @json($months);
    const revenueData = @json(array_values($revenueSeries));
    const ordersData = @json(array_values($ordersSeries));
    
    // Revenue Chart
    const revCtx = document.getElementById('revenueChart');
    if (revCtx) {
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: revenueData,
                    borderColor: '#5cb890',
                    backgroundColor: 'rgba(92, 184, 144, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#5cb890',
                    pointBorderColor: '#1a2a38',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (v) => 'Rp ' + v.toLocaleString('id-ID')
                        },
                        grid: { color: 'rgba(100, 160, 180, 0.08)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
    
    // Orders Chart
    const ordCtx = document.getElementById('ordersChart');
    if (ordCtx) {
        new Chart(ordCtx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Orders',
                    data: ordersData,
                    backgroundColor: 'rgba(100, 160, 180, 0.5)',
                    borderColor: '#64a0b4',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(100, 160, 180, 0.08)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
    
    // Order Status Pie Chart
    const statusCtx = document.getElementById('orderStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Completed', 'Cancelled'],
                datasets: [{
                    data: [{{ $stats['pending_orders'] }}, {{ $stats['completed_orders'] }}, {{ $stats['cancelled_orders'] }}],
                    backgroundColor: [
                        'rgba(201, 168, 86, 0.7)',
                        'rgba(92, 184, 144, 0.7)',
                        'rgba(196, 112, 112, 0.7)'
                    ],
                    borderColor: [
                        '#c9a856',
                        '#5cb890',
                        '#c47070'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
    
    // Products by Game Type Chart
    const productsByGameCtx = document.getElementById('productsByGameChart');
    if (productsByGameCtx) {
        const productsByGameData = @json($productsByGameType);
        const gameTypeLabels = productsByGameData.map(item => {
            const types = {
                'diamond': 'Diamond',
                'coins': 'Coins',
                'gems': 'Gems',
                'robux': 'Robux',
                'voucher': 'Voucher',
                'other': 'Lainnya'
            };
            return types[item.game_type] || item.game_type;
        });
        const gameTypeCounts = productsByGameData.map(item => item.count);
        
        new Chart(productsByGameCtx, {
            type: 'bar',
            data: {
                labels: gameTypeLabels,
                datasets: [{
                    label: 'Jumlah Produk',
                    data: gameTypeCounts,
                    backgroundColor: [
                        'rgba(100, 160, 180, 0.6)',
                        'rgba(92, 184, 144, 0.6)',
                        'rgba(255, 193, 7, 0.6)',
                        'rgba(156, 39, 176, 0.6)',
                        'rgba(33, 150, 243, 0.6)',
                        'rgba(255, 152, 0, 0.6)'
                    ],
                    borderColor: [
                        '#64a0b4',
                        '#5cb890',
                        '#ffc107',
                        '#9c27b0',
                        '#2196f3',
                        '#ff9800'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(100, 160, 180, 0.08)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
    
    // Sales Performance Chart
    const salesCtx = document.getElementById('salesPerformanceChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Orders',
                    data: ordersData,
                    borderColor: '#64a0b4',
                    backgroundColor: 'rgba(100, 160, 180, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                }, {
                    label: 'Revenue',
                    data: revenueData,
                    borderColor: '#5cb890',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    fill: false,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(100, 160, 180, 0.08)' }
                    },
                    y1: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        ticks: {
                            callback: (v) => 'Rp ' + (v/1000).toFixed(0) + 'k'
                        },
                        grid: { display: false }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endsection
