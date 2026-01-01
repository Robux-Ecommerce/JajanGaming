<!-- Page Sidebar - Sama dengan Dashboard Sidebar -->
<style>
    .page-sidebar {
        width: 280px;
        background: linear-gradient(180deg, #0f1a24 0%, #162030 100%);
        border-right: 1px solid rgba(100, 160, 180, 0.1);
        display: flex;
        flex-direction: column;
        height: calc(100vh - 76px);
        position: fixed;
        top: 76px;
        left: 0;
        overflow-y: auto;
        z-index: 1000;
        flex-shrink: 0;
    }

    /* Push content to the right of sidebar */
    body {
        display: flex;
        flex-direction: column;
    }

    body > main,
    body > .content-wrapper {
        margin-left: 280px;
    }

    /* Alternative for flex layouts */
    div[style*="flex: 1"] {
        margin-left: 280px;
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
        flex-shrink: 0;
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
        flex: 1;
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

    .menu-item:hover i {
        color: #64a0b4;
    }

    .menu-item.active {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        border-left-color: #64a0b4;
    }

    .menu-item.active i {
        color: #64a0b4;
    }

    .menu-item i {
        width: 20px;
        font-size: 1rem;
        color: inherit;
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

    .page-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .page-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .page-sidebar::-webkit-scrollbar-thumb {
        background: rgba(100, 160, 180, 0.2);
        border-radius: 3px;
    }

    .page-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(100, 160, 180, 0.35);
    }

    @media (max-width: 1024px) {
        .page-sidebar {
            width: 240px;
        }
    }

    @media (max-width: 768px) {
        .page-sidebar {
            position: fixed;
            left: -280px;
            top: 76px;
            height: calc(100vh - 76px);
            width: 280px;
            z-index: 998;
            transition: left 0.3s ease;
        }
        
        .page-sidebar.show {
            left: 0;
        }

        body > main,
        body > .content-wrapper,
        div[style*="flex: 1"] {
            margin-left: 0;
        }
    }

    @media (max-width: 480px) {
        .page-sidebar {
            width: 100%;
            left: -100%;
            top: 76px;
            height: calc(100vh - 76px);
        }

        body > main,
        body > .content-wrapper,
        div[style*="flex: 1"] {
            margin-left: 0;
        }
    }
</style>

<!-- Sidebar Content -->
<aside class="page-sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <i class="fas fa-gamepad"></i>
        <span>JajanGaming</span>
    </div>

    <!-- User Profile -->
    <?php if(auth()->check()): ?>
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
    <?php endif; ?>

    <!-- Menu -->
    <nav class="sidebar-menu">
        <!-- Menu Utama -->
        <?php if(auth()->check()): ?>
            <?php if(auth()->user()->isAdmin()): ?>
                <!-- Menu Admin -->
                <div class="menu-label">Menu Utama</div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dasbor</span>
                </a>
                <a href="<?php echo e(route('admin.products')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.products*') ? 'active' : ''); ?>">
                    <i class="fas fa-cube"></i>
                    <span>Produk</span>
                </a>
                <a href="<?php echo e(route('admin.orders')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Pesanan</span>
                </a>
                <a href="<?php echo e(route('admin.users')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span>
                </a>
                <a href="<?php echo e(route('admin.transactions')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.transactions*') ? 'active' : ''); ?>">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
                
                <div class="menu-label">Manajemen</div>
                <a href="<?php echo e(route('admin.wallet.index')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.wallet*') ? 'active' : ''); ?>">
                    <i class="fas fa-wallet"></i>
                    <span>Dompet Sistem</span>
                </a>
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Laporan</span>
                </a>
                <a href="<?php echo e(route('admin.profile')); ?>" class="menu-item <?php echo e(request()->routeIs('admin.profile') ? 'active' : ''); ?>">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>

            <?php elseif(auth()->user()->isSeller()): ?>
                <!-- Menu Penjual -->
                <div class="menu-label">Menu Utama</div>
                <a href="<?php echo e(route('seller.dashboard')); ?>" class="menu-item <?php echo e(request()->routeIs('seller.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dasbor</span>
                </a>
                <a href="<?php echo e(route('seller.products.index')); ?>" class="menu-item <?php echo e(request()->routeIs('seller.products*') ? 'active' : ''); ?>">
                    <i class="fas fa-cube"></i>
                    <span>Produk Saya</span>
                </a>
                <a href="<?php echo e(route('seller.orders.index')); ?>" class="menu-item <?php echo e(request()->routeIs('seller.orders*') ? 'active' : ''); ?>">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Pesanan</span>
                </a>
                
                <div class="menu-label">Manajemen</div>
                <a href="<?php echo e(route('seller.products.create')); ?>" class="menu-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Produk</span>
                </a>
                <a href="<?php echo e(route('seller.reports.index')); ?>" class="menu-item <?php echo e(request()->routeIs('seller.reports*') ? 'active' : ''); ?>">
                    <i class="fas fa-bell"></i>
                    <span>Laporan Saya</span>
                </a>
                <a href="<?php echo e(route('seller.wallet')); ?>" class="menu-item <?php echo e(request()->routeIs('seller.wallet') ? 'active' : ''); ?>">
                    <i class="fas fa-chart-line"></i>
                    <span>Pendapatan</span>
                </a>
                <a href="<?php echo e(route('seller.profile')); ?>" class="menu-item <?php echo e(request()->routeIs('seller.profile*') ? 'active' : ''); ?>">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>

            <?php else: ?>
                <!-- Menu Pelanggan -->
                <div class="menu-label">Akun</div>
                <a href="<?php echo e(route('profile.index')); ?>" class="menu-item <?php echo e(request()->routeIs('profile.index') ? 'active' : ''); ?>">
                    <i class="fas fa-user"></i>
                    <span>Profil Saya</span>
                </a>
                <a href="<?php echo e(route('wallet.index')); ?>" class="menu-item <?php echo e(request()->routeIs('wallet.index') ? 'active' : ''); ?>">
                    <i class="fas fa-wallet"></i>
                    <span>Dompet Saya</span>
                    <span class="menu-badge">Rp <?php echo e(number_format(auth()->user()->wallet_balance, 0, ',', '.')); ?></span>
                </a>
                <a href="<?php echo e(url('/payment/topup')); ?>" class="menu-item <?php echo e(request()->routeIs('payment.topup') ? 'active' : ''); ?>">
                    <i class="fas fa-credit-card"></i>
                    <span>Top Up</span>
                </a>

                <div class="menu-label">Belanja</div>
                <a href="<?php echo e(route('cart.index')); ?>" class="menu-item <?php echo e(request()->routeIs('cart.index') ? 'active' : ''); ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Keranjang</span>
                    <?php
                        $cartCount = auth()->user()->carts()->count();
                    ?>
                    <?php if($cartCount > 0): ?>
                        <span class="menu-badge"><?php echo e($cartCount); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('orders.index')); ?>" class="menu-item <?php echo e(request()->routeIs('orders.index') ? 'active' : ''); ?>">
                    <i class="fas fa-receipt"></i>
                    <span>Pesanan Saya</span>
                </a>
                <a href="<?php echo e(route('wishlist.index')); ?>" class="menu-item <?php echo e(request()->routeIs('wishlist.index') ? 'active' : ''); ?>" style="--icon-color: #ff3c5a;">
                    <i class="fas fa-heart"></i>
                    <span>Wishlist</span>
                </a>
                <a href="<?php echo e(route('home')); ?>" class="menu-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                    <i class="fas fa-th"></i>
                    <span>Jelajahi</span>
                </a>

                <div class="menu-label">Aktivitas</div>
                <a href="<?php echo e(route('notifications.index')); ?>" class="menu-item <?php echo e(request()->routeIs('notifications.index') ? 'active' : ''); ?>">
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                    <?php
                        $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                    ?>
                    <?php if($unreadCount > 0): ?>
                        <span class="menu-badge"><?php echo e($unreadCount); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Navigasi -->
        <div class="menu-label">Navigasi</div>
        <a href="<?php echo e(route('home')); ?>" class="menu-item">
            <i class="fas fa-home"></i>
            <span>Kembali ke Toko</span>
        </a>
    </nav>
</aside>

<script>
function closeSidebar() {
    const sidebar = document.querySelector('.page-sidebar');
    if (sidebar) {
        sidebar.classList.remove('show');
    }
}

document.querySelectorAll('.menu-item').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            closeSidebar();
        }
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSidebar();
    }
});
</script>
<?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>