@extends('layouts.app')

@section('title', 'Admin Dashboard - JajanGaming')

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
            <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('admin.products') }}" class="menu-item">
                <i class="fas fa-cube"></i>
                <span>Produk</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="menu-item">
                <i class="fas fa-shopping-bag"></i>
                <span>Pesanan</span>
                @if($stats['pending_orders'] > 0)
                    <span class="menu-badge">{{ $stats['pending_orders'] }}</span>
                @endif
            </a>
            @if($user->isAdmin())
            <a href="{{ route('admin.users') }}" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('admin.transactions') }}" class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
            @endif
            
            <div class="menu-label">Manajemen</div>
            <a href="{{ route('admin.wallet.index') }}" class="menu-item">
                <i class="fas fa-wallet"></i>
                <span>Dompet Sistem</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="menu-item">
                <i class="fas fa-exclamation-circle"></i>
                <span>Laporan</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="menu-item">
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
                    {{ $user->isAdmin() ? 'Dasbor Admin' : ($user->isSeller() ? 'Dasbor Penjual' : 'Dasbor Pelanggan') }}
                </h1>
                <p class="header-subtitle">{{ $user->isAdmin() ? 'Selamat datang kembali, ' . $user->name . '! Berikut adalah ringkasan Anda.' : ($user->isSeller() ? 'Selamat datang kembali, ' . $user->name . '! Berikut adalah ringkasan penjualan Anda.' : 'Selamat datang kembali, ' . $user->name . '! Berikut adalah ringkasan belanja Anda.') }}</p>
            </div>
            <div class="header-right">
                <div class="header-date">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total_products']) }}</h3>
                    <p>Total Produk</p>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
            
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total_orders']) }}</h3>
                    <p>Total Pesanan</p>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
            
            <a href="{{ route('admin.transactions') }}" class="stat-card stat-card-clickable stat-info" style="text-decoration: none; color: inherit;">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-content">
                    <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            @if($user->isAdmin())
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['total_users']) }}</h3>
                    <p>Total Pengguna</p>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>

            <a href="{{ route('admin.wallet.index') }}" class="stat-card stat-card-clickable" style="text-decoration: none; color: inherit;">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-content">
                    <h3>Rp {{ number_format($stats['admin_wallet_balance'] ?? 0, 0, ',', '.') }}</h3>
                    <p>Dompet Admin</p>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            @else
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <h3>Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</h3>
                    <p>Pendapatan</p>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
            @endif
        </div>

        <!-- Order Status Cards -->
        <div class="order-status-grid">
            <div class="order-status-card pending">
                <div class="status-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="status-content">
                    <span class="status-count">{{ number_format($stats['pending_orders']) }}</span>
                    <span class="status-label">Tertunda</span>
                </div>
            </div>
            <div class="order-status-card processing">
                <div class="status-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="status-content">
                    <span class="status-count">0</span>
                    <span class="status-label">Diproses</span>
                </div>
            </div>
            <div class="order-status-card completed">
                <div class="status-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="status-content">
                    <span class="status-count">{{ number_format($stats['completed_orders']) }}</span>
                    <span class="status-label">Selesai</span>
                </div>
            </div>
            <div class="order-status-card cancelled">
                <div class="status-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="status-content">
                    <span class="status-count">{{ number_format($stats['cancelled_orders']) }}</span>
                    <span class="status-label">Dibatalkan</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-card large">
                <div class="chart-header">
                    <h4><i class="fas fa-chart-line"></i> Analitik Pendapatan</h4>
                    <div class="chart-period">
                        <span class="active">Tahun Ini</span>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-chart-bar"></i> Ringkasan Pesanan</h4>
                </div>
                <div class="chart-body">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-chart-pie"></i> Status Pesanan</h4>
                </div>
                <div class="chart-body">
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
                    <a href="{{ route('admin.orders') }}" class="view-all-btn">Lihat Semua <i class="fas fa-arrow-right"></i></a>
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
                    <a href="{{ route('admin.products') }}" class="view-all-btn">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="data-body">
                    <div class="top-products-list">
                        @forelse($top_products as $index => $product)
                        <div class="product-item">
                            <span class="product-rank">#{{ $index + 1 }}</span>
                            <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
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

        @if($user->isAdmin())
        <!-- Admin Only: User Activity & System Info -->
        <div class="admin-section">
            <div class="data-card">
                <div class="data-header">
                    <h4><i class="fas fa-chart-area"></i> Sales Performance</h4>
                </div>
                <div class="data-body">
                    <canvas id="salesPerformanceChart"></canvas>
                </div>
            </div>
            
            <div class="data-card info-card">
                <div class="data-header">
                    <h4><i class="fas fa-info-circle"></i> Quick Stats</h4>
                </div>
                <div class="data-body">
                    <div class="quick-stats-list">
                        <div class="quick-stat-item">
                            <i class="fas fa-percentage"></i>
                            <div class="stat-details">
                                <span class="stat-value">{{ $stats['total_orders'] > 0 ? round(($stats['completed_orders'] / $stats['total_orders']) * 100, 1) : 0 }}%</span>
                                <span class="stat-label">Completion Rate</span>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <i class="fas fa-coins"></i>
                            <div class="stat-details">
                                <span class="stat-value">Rp {{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 0, ',', '.') : 0 }}</span>
                                <span class="stat-label">Avg. Order Value</span>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <i class="fas fa-box-open"></i>
                            <div class="stat-details">
                                <span class="stat-value">{{ $top_products->count() > 0 ? Str::limit($top_products->first()->name, 15) : 'N/A' }}</span>
                                <span class="stat-label">Best Seller</span>
                            </div>
                        </div>
                        <div class="quick-stat-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="stat-details">
                                <span class="stat-value">{{ $stats['total_orders'] > 0 ? round(($stats['cancelled_orders'] / $stats['total_orders']) * 100, 1) : 0 }}%</span>
                                <span class="stat-label">Cancel Rate</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
            <div class="actions-grid">
                <a href="{{ route('admin.products.create') }}" class="action-card add-product">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Product</span>
                </a>
                <a href="{{ route('admin.products') }}" class="action-card manage-products">
                    <i class="fas fa-boxes"></i>
                    <span>Manage Products</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="action-card view-orders">
                    <i class="fas fa-clipboard-list"></i>
                    <span>View Orders</span>
                </a>
                @if($user->isAdmin())
                <a href="{{ route('admin.users') }}" class="action-card manage-users">
                    <i class="fas fa-user-friends"></i>
                    <span>Manage Users</span>
                </a>
                @else
                <a href="{{ route('wallet.index') }}" class="action-card wallet">
                    <i class="fas fa-wallet"></i>
                    <span>My Wallet</span>
                </a>
                @endif
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
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
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
    
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .stats-grid,
    .order-status-grid,
    .actions-grid {
        grid-template-columns: 1fr;
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
    
    // Sales Performance Chart (Admin only)
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
