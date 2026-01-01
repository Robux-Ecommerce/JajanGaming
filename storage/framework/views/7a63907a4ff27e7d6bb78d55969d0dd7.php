

<?php $__env->startSection('styles'); ?>
<style>
/* Dashboard Styling untuk Report Pages */
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

.sidebar-avatar, .sidebar-avatar-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-avatar-placeholder {
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
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

.dashboard-main {
    flex: 1;
    margin-left: 280px;
    padding: 30px;
    min-height: 100vh;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-wrapper">
    <!-- Dashboard Sidebar -->
    <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-brand">
            <i class="fas fa-gamepad"></i>
            <span>JajanGaming</span>
        </div>
        
        <div class="sidebar-user">
            <?php if(auth()->user()->profile_photo): ?>
                <img src="<?php echo e(asset('storage/' . auth()->user()->profile_photo)); ?>" alt="Profile" class="sidebar-avatar">
            <?php else: ?>
                <div class="sidebar-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            <?php endif; ?>
            <div class="sidebar-user-info">
                <h6><?php echo e(auth()->user()->name); ?></h6>
                <span class="user-role"><?php echo e(auth()->user()->isAdmin() ? 'Administrator' : (auth()->user()->isSeller() ? 'Penjual' : 'Pelanggan')); ?></span>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dasbor</span>
            </a>
            <a href="<?php echo e(route('admin.products')); ?>" class="menu-item">
                <i class="fas fa-cube"></i>
                <span>Produk</span>
            </a>
            <a href="<?php echo e(route('admin.orders')); ?>" class="menu-item">
                <i class="fas fa-shopping-bag"></i>
                <span>Pesanan</span>
            </a>
            <?php if(auth()->user()->isAdmin()): ?>
            <a href="<?php echo e(route('admin.users')); ?>" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Pengguna</span>
            </a>
            <a href="<?php echo e(route('admin.transactions')); ?>" class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
            <?php endif; ?>
            
            <div class="menu-label">Manajemen</div>
            <a href="<?php echo e(route('admin.wallet.index')); ?>" class="menu-item">
                <i class="fas fa-wallet"></i>
                <span>Dompet Sistem</span>
            </a>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="menu-item active">
                <i class="fas fa-exclamation-circle"></i>
                <span>Laporan</span>
            </a>
            <a href="<?php echo e(route('admin.profile')); ?>" class="menu-item">
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
<div style="margin-left: 0;">
    <div class="row">
        <div class="col-12" style="padding: 1.5rem 2rem;">
        <div class="mb-6" style="background: linear-gradient(135deg, rgba(100, 160, 180, 0.1) 0%, rgba(100, 160, 180, 0.05) 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #64a0b4; margin-bottom: 2rem;">
            <h1 class="h3 mb-2" style="font-size: 2rem; color: #ffffff; font-weight: 800; letter-spacing: -0.5px;">
                <i class="fas fa-exclamation-circle me-3" style="color: #e8b056;"></i>Manajemen Laporan
            </h1>
            <p class="mb-0" style="font-size: 1rem; color: #a0b5c5;">Kelola laporan dari pembeli tentang seller bermasalah</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-8" style="margin-bottom: 3rem;">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card total">
                    <div class="stats-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h6>Total Laporan</h6>
                        <h3><?php echo e($totalReports); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card warning">
                    <div class="stats-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stats-content">
                        <h6>Pending</h6>
                        <h3><?php echo e($pendingReports); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card success">
                    <div class="stats-icon">
                        <i class="fas fa-reply"></i>
                    </div>
                    <div class="stats-content">
                        <h6>Sudah Direspons</h6>
                        <h3><?php echo e($respondedReports); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stats-card danger">
                    <div class="stats-icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="stats-content">
                        <h6>Seller Blacklist</h6>
                        <h3><?php echo e($blacklistedSellers); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sellers with Reports -->
        <div class="card mb-6" style="margin-top: 2rem;">
            <div class="card-header" style="padding: 1.75rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-size: 1.2rem;">Seller Bermasalah (Diurutkan dari Laporan Terbanyak)</h5>
                    <a href="<?php echo e(route('admin.reports.export')); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%); color: white; font-weight: 700; border: none; padding: 0.65rem 1.25rem; border-radius: 8px; transition: all 0.3s;">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                </div>
            </div>

            <div class="table-responsive" style="border-radius: 0 0 12px 12px;">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr style="background: rgba(100, 160, 180, 0.1);">
                            <th style="padding: 1.25rem 1rem; font-weight: 700; color: #64a0b4; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Seller</th>
                            <th style="padding: 1.25rem 1rem; font-weight: 700; color: #64a0b4; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Total Laporan</th>
                            <th style="padding: 1.25rem 1rem; font-weight: 700; color: #64a0b4; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Status</th>
                            <th style="padding: 1.25rem 1rem; font-weight: 700; color: #64a0b4; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Peringkat Masalah</th>
                            <th style="padding: 1.25rem 1rem; font-weight: 700; color: #64a0b4; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transaction-row" style="border-bottom: 1px solid rgba(100, 160, 180, 0.1); transition: all 0.3s;">
                                <td style="padding: 1.25rem 1rem; vertical-align: middle;">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if($seller->profile_photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $seller->profile_photo)); ?>" alt="Avatar" class="avatar-mini rounded-circle" style="width: 42px; height: 42px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="avatar-mini" style="width: 42px; height: 42px; font-size: 1.1rem;"><?php echo e(strtoupper(substr($seller->name, 0, 1))); ?></div>
                                        <?php endif; ?>
                                        <div>
                                            <strong style="display: block; color: #ffffff; margin-bottom: 0.25rem;"><?php echo e($seller->name); ?></strong>
                                            <small style="color: #7a8a9a; font-size: 0.85rem;"><?php echo e($seller->email); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem 1rem; vertical-align: middle;">
                                    <span class="badge" style="background: linear-gradient(135deg, rgba(232, 176, 86, 0.2) 0%, rgba(216, 149, 64, 0.1) 100%); color: #ffa500; border: 1px solid rgba(232, 176, 86, 0.4); font-size: 0.9rem; padding: 0.65rem 1rem; font-weight: 700;">
                                        <?php echo e($seller->reports_against_count); ?> laporan
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 1rem; vertical-align: middle;">
                                    <?php if($seller->is_blacklisted): ?>
                                        <span class="badge" style="background: linear-gradient(135deg, rgba(224, 120, 86, 0.2) 0%, rgba(200, 92, 64, 0.1) 100%); color: #ff9999; border: 1px solid rgba(224, 120, 86, 0.4); font-size: 0.9rem; padding: 0.65rem 1rem; font-weight: 700;">
                                            <i class="fas fa-lock me-1"></i> Blacklist
                                        </span>
                                    <?php else: ?>
                                        <span class="badge" style="background: linear-gradient(135deg, rgba(110, 190, 150, 0.2) 0%, rgba(82, 168, 118, 0.1) 100%); color: #6ebe96; border: 1px solid rgba(110, 190, 150, 0.4); font-size: 0.9rem; padding: 0.65rem 1rem; font-weight: 700;">
                                            <i class="fas fa-check-circle me-1"></i> Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 1.25rem 1rem; vertical-align: middle;">
                                    <?php
                                        $level = match(true) {
                                            $seller->reports_against_count >= 10 => ['Sangat Tinggi', '#e07856'],
                                            $seller->reports_against_count >= 5 => ['Tinggi', '#e8b056'],
                                            $seller->reports_against_count >= 3 => ['Sedang', '#5eb8c4'],
                                            default => ['Rendah', '#6ebe96'],
                                        };
                                    ?>
                                    <span style="color: <?php echo e($level[1]); ?>; font-weight: 700; font-size: 0.95rem;"><?php echo e($level[0]); ?></span>
                                </td>
                                <td style="padding: 1.25rem 1rem; vertical-align: middle;">
                                    <a href="<?php echo e(route('admin.reports.detail', $seller->id)); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, rgba(100, 160, 180, 0.15) 0%, rgba(80, 140, 160, 0.1) 100%); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.3); text-decoration: none; font-weight: 700; padding: 0.65rem 1.25rem; border-radius: 8px; transition: all 0.3s; display: inline-block;">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5" style="padding: 2.5rem 1rem !important;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; color: #5a7a8a; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p style="color: #a0b5c5; font-size: 1rem; margin-top: 1rem;">Tidak ada seller dengan laporan</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($sellers->hasPages()): ?>
                <div class="d-flex justify-content-center py-3">
                    <?php echo e($sellers->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<style>
/* Statistics Cards */
.stats-card {
    padding: 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    color: white;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    pointer-events: none;
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
    border-color: rgba(255, 255, 255, 0.2);
}

.stats-card.total {
    background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
}

.stats-card.success {
    background: linear-gradient(135deg, #6ebe96 0%, #48a070 100%);
}

.stats-card.warning {
    background: linear-gradient(135deg, #e8b056 0%, #d68940 100%);
}

.stats-card.danger {
    background: linear-gradient(135deg, #e07856 0%, #c84c40 100%);
}

.stats-icon {
    font-size: 2.5rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.stats-content {
    position: relative;
    z-index: 1;
    flex: 1;
}

.stats-content h6 {
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    opacity: 0.95;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.stats-content h3 {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
    border: 1px solid rgba(100, 160, 180, 0.15);
    color: #ffffff;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
    transform: translateY(-2px);
}

.card-header {
    border-bottom: 1px solid rgba(100, 160, 180, 0.2);
    border-radius: 10px 10px 0 0 !important;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    color: white;
    font-weight: 600;
    padding: 1.5rem;
}

.card-header h5 {
    margin: 0;
    color: white;
    font-size: 1.1rem;
}

/* Table Styling */
.table-responsive {
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
    border-radius: 0 0 12px 12px;
}

.table {
    font-size: 0.9rem;
    color: #e0e0e0;
    margin-bottom: 0;
}

.table thead {
    background-color: rgba(100, 160, 180, 0.15);
    border-bottom: 2px solid rgba(100, 160, 180, 0.3);
}

.table thead th {
    color: #a0c5d5;
    font-weight: 700;
    padding: 0.85rem 0.85rem;
    border: none;
    letter-spacing: 0.3px;
}

.table tbody td {
    padding: 0.75rem 0.85rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    color: #e0e0e0;
}

.transaction-row:hover {
    background-color: rgba(100, 160, 180, 0.1) !important;
}

/* Pagination */
.pagination {
    gap: 0.2rem;
}

.page-link {
    color: #64a0b4;
    border-color: rgba(100, 160, 180, 0.3);
    border-radius: 4px;
    padding: 0.5rem 0.65rem;
    font-size: 0.9rem;
    background: rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.page-link:hover {
    color: #ffffff;
    background-color: rgba(100, 160, 180, 0.2);
    border-color: rgba(100, 160, 180, 0.4);
}

.page-link.active {
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    border-color: #64a0b4;
    color: #ffffff;
}

/* Utilities */
.gap-2 {
    gap: 0.5rem;
}

.avatar-mini {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    box-shadow: 0 2px 8px rgba(100, 160, 180, 0.3);
}

.btn {
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}
</style>
        </div>
    </div>
</div>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>