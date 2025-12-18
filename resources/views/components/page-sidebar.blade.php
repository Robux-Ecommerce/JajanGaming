<!-- Page Sidebar Navigation -->
<div class="page-sidebar">
    <div class="sidebar-header">
        <h3 class="sidebar-title">{{ $sidebarTitle ?? 'Menu' }}</h3>
        <button class="sidebar-close" onclick="closeSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <nav class="sidebar-menu">
        {{-- Admin Menu --}}
        @if(auth()->check() && auth()->user()->is_admin)
                <div class="sidebar-section">
                    <span class="section-label">Admin Panel</span>
                    <ul class="menu-list">
                        <li class="menu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}" class="menu-link">
                                <i class="fas fa-box-open"></i>
                                <span>Products</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}" class="menu-link">
                                <i class="fas fa-shopping-bag"></i>
                                <span>Orders</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <i class="fas fa-users"></i>
                                <span>Users</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.transactions.index') }}" class="menu-link">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Transactions</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
        @endif

        {{-- User Menu --}}
        @if(auth()->check())
            <div class="sidebar-section">
                <span class="section-label">My Account</span>
                <ul class="menu-list">
                    <li class="menu-item {{ request()->routeIs('wallet.index') ? 'active' : '' }}">
                        <a href="{{ route('wallet.index') }}" class="menu-link">
                            <i class="fas fa-wallet"></i>
                            <span>My Wallet</span>
                            <span class="menu-badge">Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('topup') ? 'active' : '' }}">
                        <a href="{{ route('topup') }}" class="menu-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Top Up</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.profile.index') }}" class="menu-link">
                            <i class="fas fa-user-circle"></i>
                            <span>Profile</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        @endif

        {{-- Shopping Menu --}}
        <div class="sidebar-section">
            <span class="section-label">Shopping</span>
            <ul class="menu-list">
                <li class="menu-item {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                    <a href="{{ route('cart.index') }}" class="menu-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                        @if($cartCount ?? 0 > 0)
                            <span class="menu-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="menu-link">
                        <i class="fas fa-store"></i>
                        <span>Browse Products</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Notifications --}}
        @if(auth()->check())
            <div class="sidebar-section">
                <span class="section-label">Activity</span>
                <ul class="menu-list">
                    <li class="menu-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                        <a href="{{ route('notifications.index') }}" class="menu-link">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                            @if($unreadNotifications ?? 0 > 0)
                                <span class="menu-badge notification">{{ $unreadNotifications }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="sidebar-action">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>
    </div>
</div>

<style>
/* Page Sidebar Navigation */
.page-sidebar {
    width: 280px;
    background: linear-gradient(180deg, rgba(30, 42, 56, 0.95) 0%, rgba(25, 35, 48, 0.95) 100%);
    border-right: 1px solid rgba(100, 160, 180, 0.15);
    display: flex;
    flex-direction: column;
    height: calc(100vh - 80px);
    position: sticky;
    top: 80px;
    overflow-y: auto;
    border-radius: 0 16px 0 0;
}

.sidebar-header {
    padding: 1.25rem 1rem;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
}

.sidebar-title {
    font-size: 1rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.sidebar-close {
    display: none;
    width: 32px;
    height: 32px;
    border: none;
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.6);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.sidebar-close:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.sidebar-menu {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
}

.sidebar-section {
    padding: 0.75rem 1rem;
    margin-bottom: 0.5rem;
}

.section-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: rgba(100, 160, 180, 0.6);
    margin-bottom: 0.5rem;
    padding: 0 0.5rem;
}

.menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.menu-item {
    position: relative;
}

.menu-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.65rem 0.75rem;
    background: transparent;
    color: rgba(255, 255, 255, 0.65);
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.25s ease;
    font-size: 0.9rem;
    font-weight: 500;
}

.menu-link:hover {
    background: rgba(100, 160, 180, 0.1);
    color: #ffffff;
}

.menu-link i:first-child {
    font-size: 0.95rem;
    color: rgba(100, 160, 180, 0.7);
    min-width: 20px;
}

.menu-link:hover i:first-child {
    color: #64b5c6;
}

.menu-item.active .menu-link {
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.25) 0%, rgba(100, 160, 180, 0.12) 100%);
    color: #ffffff;
    border-left: 3px solid #64b5c6;
    padding-left: 0.75rem;
}

.menu-item.active .menu-link i:first-child {
    color: #64b5c6;
}

.menu-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.25rem 0.6rem;
    background: rgba(100, 160, 180, 0.2);
    color: #64b5c6;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
}

.menu-badge.notification {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.3) 0%, rgba(231, 76, 60, 0.2) 100%);
    color: #ff6b6b;
}

.menu-item.active .menu-link .menu-badge {
    background: rgba(100, 160, 180, 0.4);
}

.menu-link > i:last-child {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.3);
    margin-left: auto;
}

.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid rgba(100, 160, 180, 0.1);
}

.sidebar-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    padding: 0.75rem 1rem;
    background: rgba(100, 160, 180, 0.1);
    color: #64b5c6;
    border: 1px solid rgba(100, 160, 180, 0.25);
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.sidebar-action:hover {
    background: rgba(100, 160, 180, 0.15);
    border-color: rgba(100, 160, 180, 0.4);
    color: #ffffff;
}

/* Custom Scrollbar */
.sidebar-menu::-webkit-scrollbar,
.page-sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar-menu::-webkit-scrollbar-track,
.page-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-menu::-webkit-scrollbar-thumb,
.page-sidebar::-webkit-scrollbar-thumb {
    background: rgba(100, 160, 180, 0.2);
    border-radius: 3px;
}

.sidebar-menu::-webkit-scrollbar-thumb:hover,
.page-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(100, 160, 180, 0.35);
}

/* Responsive */
@media (max-width: 1024px) {
    .page-sidebar {
        width: 240px;
        height: calc(100vh - 70px);
        top: 70px;
    }
    
    .sidebar-section {
        padding: 0.65rem 0.75rem;
    }
}

@media (max-width: 768px) {
    .page-sidebar {
        position: fixed;
        left: -280px;
        top: 0;
        height: 100vh;
        width: 280px;
        border-radius: 0;
        border-right: 1px solid rgba(100, 160, 180, 0.15);
        z-index: 998;
        transition: left 0.3s ease;
    }
    
    .page-sidebar.show {
        left: 0;
    }
    
    .sidebar-close {
        display: block;
    }
}

@media (max-width: 480px) {
    .page-sidebar {
        width: 100%;
        left: -100%;
    }
}
</style>

<script>
function closeSidebar() {
    const sidebar = document.querySelector('.page-sidebar');
    sidebar.classList.remove('show');
}

// Close sidebar when clicking on a link
document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            closeSidebar();
        }
    });
});
</script>
