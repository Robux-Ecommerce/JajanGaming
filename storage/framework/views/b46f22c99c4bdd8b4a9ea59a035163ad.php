

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
                <span class="user-role"><?php echo e(auth()->user()->isSeller() ? 'Penjual' : 'Pelanggan'); ?></span>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <a href="<?php echo e(route('home')); ?>" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
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
            <a href="<?php echo e(route('seller.reports.index')); ?>" class="menu-item active">
                <i class="fas fa-exclamation-circle"></i>
                <span>Laporan Saya</span>
            </a>
            <a href="<?php echo e(route('seller.profile')); ?>" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
<div style="margin-left: 0;">
    <div class="row">
        <div class="col-12" style="padding: 1.5rem 2rem;">
        <!-- Header -->
        <div class="mb-6" style="background: linear-gradient(135deg, rgba(100, 160, 180, 0.1) 0%, rgba(100, 160, 180, 0.05) 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #64a0b4; margin-bottom: 2rem;">
            <h1 class="h3 mb-2" style="font-size: 2rem; color: #ffffff; font-weight: 800; letter-spacing: -0.5px;">
                <i class="fas fa-bell me-2" style="color: #e8b056;"></i>Laporan tentang Saya
            </h1>
            <p class="mb-0" style="font-size: 0.9rem; color: #a0b5c5;">Lihat dan respons laporan dari pembeli</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 mb-6">
            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="stats-card warning">
                    <div class="stats-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stats-content">
                        <h6>Menunggu</h6>
                        <h3><?php echo e($pendingReports); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
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
        </div>

        <!-- Reports List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Laporan</h5>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Produk</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transaction-row">
                                <td>
                                    <strong><?php echo e($report->reporter->name); ?></strong><br>
                                    <small style="color: #7a8a9a;"><?php echo e($report->reporter->email); ?></small>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('product.show', $report->product)); ?>" style="color: #64a0b4; text-decoration: none;">
                                        <?php echo e(Str::limit($report->product->name, 30)); ?>

                                    </a>
                                </td>
                                <td>
                                    <span class="badge" style="background: linear-gradient(135deg, rgba(232, 176, 86, 0.3) 0%, rgba(216, 149, 64, 0.2) 100%); color: #ffa500; border: 1px solid rgba(232, 176, 86, 0.4); text-transform: capitalize;">
                                        <?php echo e(str_replace('_', ' ', $report->reason)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php switch($report->status):
                                        case ('pending'): ?>
                                            <span class="badge" style="background: linear-gradient(135deg, rgba(232, 176, 86, 0.3) 0%, rgba(216, 149, 64, 0.2) 100%); color: #ffa500; border: 1px solid rgba(232, 176, 86, 0.4);">Menunggu</span>
                                            <?php break; ?>
                                        <?php case ('responded'): ?>
                                            <span class="badge" style="background: linear-gradient(135deg, rgba(110, 190, 150, 0.3) 0%, rgba(82, 168, 118, 0.2) 100%); color: #6ebe96; border: 1px solid rgba(110, 190, 150, 0.4);">Sudah Direspons</span>
                                            <?php break; ?>
                                        <?php case ('resolved'): ?>
                                            <span class="badge" style="background: linear-gradient(135deg, rgba(100, 160, 180, 0.3) 0%, rgba(80, 140, 160, 0.2) 100%); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.4);">Selesai</span>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                </td>
                                <td style="color: #a0b5c5; font-size: 0.85rem;">
                                    <?php echo e($report->created_at->format('d M Y')); ?><br>
                                    <?php echo e($report->created_at->format('H:i')); ?>

                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal<?php echo e($report->id); ?>" style="background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(80, 140, 160, 0.15) 100%); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.3); text-decoration: none; font-weight: 600;">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </button>
                                </td>
                            </tr>

                            <!-- Report Detail Modal -->
                            <div class="modal fade" id="reportModal<?php echo e($report->id); ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="background: linear-gradient(135deg, #1a2a38 0%, #243645 100%); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0;">
                                        <div class="modal-header" style="border-bottom: 1px solid rgba(100, 160, 180, 0.2);">
                                            <h5 class="modal-title" style="color: #ffffff; font-weight: 700;">Detail Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(1.5);"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Pembeli:</label>
                                                <p style="color: #e0e0e0;"><?php echo e($report->reporter->name); ?> (<?php echo e($report->reporter->email); ?>)</p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Produk:</label>
                                                <p style="color: #64a0b4;"><?php echo e($report->product->name); ?></p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Alasan Laporan:</label>
                                                <p style="color: #e0e0e0; text-transform: capitalize;"><?php echo e(str_replace('_', ' ', $report->reason)); ?></p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Deskripsi:</label>
                                                <p style="color: #e0e0e0; line-height: 1.6; background: rgba(232, 176, 86, 0.1); padding: 1rem; border-left: 4px solid #e8b056; border-radius: 4px;">
                                                    <?php echo e($report->description); ?>

                                                </p>
                                            </div>

                                            <?php if($report->seller_response): ?>
                                                <div class="mb-3" style="background: rgba(110, 190, 150, 0.1); padding: 1rem; border-left: 4px solid #6ebe96; border-radius: 4px;">
                                                    <label class="form-label" style="color: #a0c5d5; font-weight: 600;">✓ Respons Anda:</label>
                                                    <p style="color: #e0e0e0; line-height: 1.6;"><?php echo e($report->seller_response); ?></p>
                                                </div>
                                            <?php else: ?>
                                                <div class="alert alert-info" style="background: rgba(94, 184, 196, 0.15); border-left: 4px solid #5eb8c4; color: #a0c5d5; border: none; border-radius: 4px;">
                                                    <i class="fas fa-info-circle me-2"></i> Anda belum merespons laporan ini. Silakan berikan penjelasan anda di bawah.
                                                </div>
                                            <?php endif; ?>

                                            <div class="mb-3">
                                                <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Tanggal Laporan:</label>
                                                <p style="color: #e0e0e0;"><?php echo e($report->created_at->format('d M Y H:i')); ?></p>
                                            </div>
                                        </div>

                                        <div class="modal-footer" style="border-top: 1px solid rgba(100, 160, 180, 0.2);">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: rgba(100, 160, 180, 0.2); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.3);">Tutup</button>

                                            <?php if($report->status === 'pending' && !$report->seller_response): ?>
                                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#respondModal<?php echo e($report->id); ?>" style="background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%); color: white; border: none; font-weight: 600;">
                                                    <i class="fas fa-reply me-1"></i> Respons
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Response Modal -->
                            <div class="modal fade" id="respondModal<?php echo e($report->id); ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="background: linear-gradient(135deg, #1a2a38 0%, #243645 100%); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0;">
                                        <div class="modal-header" style="border-bottom: 1px solid rgba(100, 160, 180, 0.2);">
                                            <h5 class="modal-title" style="color: #ffffff; font-weight: 700;">Respons Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(1.5);"></button>
                                        </div>
                                        <form action="<?php echo e(route('seller.reports.respond', $report->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <p style="color: #a0b5c5; margin-bottom: 1rem;">Berikan penjelasan atau respons terhadap laporan ini. Admin akan meninjau respons anda.</p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Respons Anda:</label>
                                                    <textarea name="response" class="form-control" required rows="4" placeholder="Jelaskan posisi anda tentang laporan ini..." style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(100, 160, 180, 0.3); color: #e0e0e0; border-radius: 8px;" minlength="10" maxlength="1000"></textarea>
                                                    <small style="color: #7a8a9a;">Minimal 10 karakter, maksimal 1000 karakter</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid rgba(100, 160, 180, 0.2);">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: rgba(100, 160, 180, 0.2); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.3);">Batal</button>
                                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #6ebe96 0%, #48a070 100%); color: white; border: none; font-weight: 600;">
                                                    <i class="fas fa-paper-plane me-1"></i> Kirim Respons
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox" style="font-size: 2rem; color: #5a7a8a; margin-bottom: 1rem;"></i>
                                    <p style="color: #a0b5c5;">Tidak ada laporan tentang anda. Terus jaga kualitas layanan anda!</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($reports->hasPages()): ?>
                <div class="d-flex justify-content-center py-3">
                    <?php echo e($reports->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<style>
/* Statistics Cards */
.stats-card {
    padding: 1.2rem 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 1rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.15);
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(30%, -30%);
    pointer-events: none;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
    border-color: rgba(255, 255, 255, 0.25);
}

.stats-card.total {
    background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
    border: 2px solid rgba(100, 160, 180, 0.3);
}

.stats-card.warning {
    background: linear-gradient(135deg, #e8b056 0%, #d68940 100%);
    border: 2px solid rgba(232, 176, 86, 0.3);
}

.stats-card.success {
    background: linear-gradient(135deg, #6ebe96 0%, #48a070 100%);
    border: 2px solid rgba(110, 190, 150, 0.3);
}

.stats-icon {
    font-size: 2rem;
    opacity: 1;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.stats-content {
    position: relative;
    z-index: 1;
}

.stats-content h6 {
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
    opacity: 1;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.stats-content h3 {
    font-size: 1.6rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
    border: 1px solid rgba(100, 160, 180, 0.2);
    color: #ffffff;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid rgba(100, 160, 180, 0.2);
    border-radius: 10px 10px 0 0 !important;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    color: white;
    font-weight: 600;
    padding: 1rem 1.5rem;
}

.card-header h5 {
    color: white;
    margin: 0;
}

/* Table Styling */
.table-responsive {
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
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

/* Form Controls */
.form-control {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(100, 160, 180, 0.3);
    color: #e0e0e0;
    border-radius: 8px;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(100, 160, 180, 0.6);
    color: #ffffff;
    box-shadow: 0 0 0 0.2rem rgba(100, 160, 180, 0.25);
}

.form-label {
    color: #a0c5d5;
    font-weight: 600;
}

.btn {
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
    border: none;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.alert {
    padding: 0.75rem 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}
</style>
        </div>
    </div>
</div>
    </main>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/seller/reports/index.blade.php ENDPATH**/ ?>