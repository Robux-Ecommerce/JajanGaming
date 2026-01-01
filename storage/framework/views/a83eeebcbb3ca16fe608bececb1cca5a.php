

<?php $__env->startSection('title', 'Detail Transaksi - Seller'); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-wrapper">
    <!-- Dashboard Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-brand">
            <i class="fas fa-gamepad"></i>
            <span>JajanGaming</span>
        </div>
        
        <div class="sidebar-user">
            <?php if($seller->profile_photo): ?>
                <img src="<?php echo e(asset('storage/' . $seller->profile_photo)); ?>" alt="Profile" class="sidebar-avatar">
            <?php else: ?>
                <div class="sidebar-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            <?php endif; ?>
            <div class="sidebar-user-info">
                <h6><?php echo e($seller->name); ?></h6>
                <span class="user-role">Penjual</span>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <a href="<?php echo e(route('seller.dashboard')); ?>" class="menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dasbor</span>
            </a>
            <a href="<?php echo e(route('seller.products.index')); ?>" class="menu-item">
                <i class="fas fa-cube"></i>
                <span>Produk Saya</span>
            </a>
            <a href="<?php echo e(route('seller.orders.index')); ?>" class="menu-item">
                <i class="fas fa-shopping-bag"></i>
                <span>Pesanan</span>
            </a>
            
            <div class="menu-label">Manajemen</div>
            <a href="<?php echo e(route('seller.products.create')); ?>" class="menu-item">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="<?php echo e(route('seller.wallet')); ?>" class="menu-item">
                <i class="fas fa-wallet"></i>
                <span>Pendapatan</span>
            </a>
            <a href="<?php echo e(route('seller.reports.index')); ?>" class="menu-item">
                <i class="fas fa-exclamation-circle"></i>
                <span>Laporan Saya</span>
                <?php
                    $pendingReportsCount = \App\Models\Report::where('seller_id', auth()->user()->id)
                        ->where('status', 'pending')
                        ->count();
                ?>
                <?php if($pendingReportsCount > 0): ?>
                    <span class="menu-badge"><?php echo e($pendingReportsCount); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('seller.transactions')); ?>" class="menu-item active">
                <i class="fas fa-receipt"></i>
                <span>Detail Transaksi</span>
            </a>
            <a href="<?php echo e(route('seller.profile')); ?>" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            
            <div class="menu-label">Navigasi</div>
            <a href="<?php echo e(route('home')); ?>" class="menu-item">
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
                    <i class="fas fa-receipt"></i>
                    Detail Transaksi
                </h1>
                <p class="header-subtitle">Ringkasan pemesanan dan transaksi produk Anda</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="seller-stats-section">
            <div class="seller-stats-grid">
                <div class="seller-stat-card seller-stat-orders">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3><?php echo e(number_format($stats['total_orders'])); ?></h3>
                        <p>Total Pesanan</p>
                    </div>
                </div>

                <div class="seller-stat-card seller-stat-rating">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3><?php echo e(number_format($stats['completed_orders'])); ?></h3>
                        <p>Pesanan Selesai</p>
                    </div>
                </div>

                <div class="seller-stat-card seller-stat-satisfaction">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3><?php echo e(number_format($stats['pending_orders'])); ?></h3>
                        <p>Pesanan Pending</p>
                    </div>
                </div>

                <div class="seller-stat-card seller-stat-products">
                    <div class="seller-stat-icon-wrapper">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="seller-stat-content">
                        <h3>Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></h3>
                        <p>Total Pendapatan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="data-card">
            <div class="data-header">
                <h4><i class="fas fa-list"></i> Daftar Transaksi</h4>
            </div>
            <div class="data-body">
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    // Get seller's products in this order
                                    $sellerProductIds = \App\Models\Product::where(function($query) use ($seller) {
                                        if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'seller_id')) {
                                            $query->where('seller_id', $seller->id);
                                        } else {
                                            $query->where('seller_name', $seller->name);
                                        }
                                    })->pluck('id');
                                    
                                    $sellerOrderItems = $order->orderItems->filter(function($item) use ($sellerProductIds) {
                                        return $sellerProductIds->contains($item->product_id);
                                    });
                                    $sellerOrderTotal = $sellerOrderItems->sum(function($item) {
                                        return $item->quantity * $item->price;
                                    });
                                ?>
                                <tr>
                                    <td>
                                        <span class="order-id">#<?php echo e($order->id); ?></span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <span class="customer-name"><?php echo e($order->user->name); ?></span>
                                            <small style="color: rgba(255, 255, 255, 0.5); display: block; font-size: 0.75rem;">
                                                <?php echo e($order->user->email); ?>

                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-list-mini">
                                            <?php $__currentLoopData = $sellerOrderItems->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div style="margin-bottom: 4px;">
                                                    <span style="color: #64a0b4;"><?php echo e($item->product->name); ?></span>
                                                    <small style="color: rgba(255, 255, 255, 0.5); display: block;">
                                                        Qty: <?php echo e($item->quantity); ?> × Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                                    </small>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($sellerOrderItems->count() > 2): ?>
                                                <small style="color: rgba(255, 255, 255, 0.5);">
                                                    +<?php echo e($sellerOrderItems->count() - 2); ?> produk lainnya
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color: #ffffff; font-weight: 600;">
                                            <?php echo e($sellerOrderItems->sum('quantity')); ?> item
                                        </span>
                                    </td>
                                    <td>
                                        <span class="amount">Rp <?php echo e(number_format($sellerOrderTotal, 0, ',', '.')); ?></span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo e($order->status); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="date"><?php echo e($order->created_at->format('d M Y')); ?></span>
                                        <small style="color: rgba(255, 255, 255, 0.5); display: block; font-size: 0.75rem;">
                                            <?php echo e($order->created_at->format('H:i')); ?>

                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>Belum ada transaksi</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($orders->hasPages()): ?>
                    <div class="d-flex justify-content-center pt-3 border-top">
                        <?php echo e($orders->links()); ?>

                    </div>
                <?php endif; ?>
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

/* Seller Stats Cards */
.seller-stats-section {
    margin-bottom: 30px;
}

.seller-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
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
}

.seller-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
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
    background: linear-gradient(135deg, rgba(201, 168, 86, 0.25) 0%, rgba(201, 168, 86, 0.15) 100%);
    color: #c9a856;
}

.seller-stat-products .seller-stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.25) 0%, rgba(100, 160, 180, 0.15) 100%);
    color: #64a0b4;
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

/* Data Card */
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

.product-list-mini {
    max-width: 250px;
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

@media (max-width: 992px) {
    .dashboard-sidebar {
        transform: translateX(-100%);
    }
    
    .dashboard-main {
        margin-left: 0;
        padding: 20px;
    }
    
    .seller-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .seller-stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/seller/transactions.blade.php ENDPATH**/ ?>