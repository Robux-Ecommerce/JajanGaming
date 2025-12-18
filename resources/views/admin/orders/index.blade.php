@extends('layouts.app')

@section('title', 'Manage Orders - JajanGaming')

@section('content')
<style>
    .orders-page {
        background: linear-gradient(180deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
        min-height: 100vh;
        padding: 2rem 1.5rem;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(30, 45, 60, 0.95) 0%, rgba(20, 35, 50, 0.95) 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.75rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        backdrop-filter: blur(20px);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: #64a0b4;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-select {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.3);
        color: #ffffff;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-select:hover {
        background: rgba(100, 160, 180, 0.2);
        border-color: rgba(100, 160, 180, 0.5);
    }

    .btn-back {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(100, 160, 180, 0.3);
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.8), rgba(37, 53, 69, 0.8));
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .stat-card.pending { border-left: 4px solid #c9a856; }
    .stat-card.processing { border-left: 4px solid #64a0b4; }
    .stat-card.completed { border-left: 4px solid #5cb890; }
    .stat-card.cancelled { border-left: 4px solid #c47070; }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card.pending .stat-icon { background: rgba(201, 168, 86, 0.15); color: #c9a856; }
    .stat-card.processing .stat-icon { background: rgba(100, 160, 180, 0.15); color: #64a0b4; }
    .stat-card.completed .stat-icon { background: rgba(92, 184, 144, 0.15); color: #5cb890; }
    .stat-card.cancelled .stat-icon { background: rgba(196, 112, 112, 0.15); color: #c47070; }

    .stat-content {
        display: flex;
        flex-direction: column;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .order-card {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.6), rgba(37, 53, 69, 0.6));
        border-radius: 16px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(100, 160, 180, 0.2);
        border-color: rgba(100, 160, 180, 0.3);
    }

    .order-card-header {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.15), rgba(100, 160, 180, 0.05));
        padding: 1.5rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-id-section h4 {
        color: #64a0b4;
        font-size: 1.1rem;
        margin: 0;
        font-weight: 700;
    }

    .status-badge {
        padding: 0.4rem 0.95rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .status-badge.pending { background: rgba(201, 168, 86, 0.2); color: #c9a856; border: 1px solid rgba(201, 168, 86, 0.3); }
    .status-badge.processing { background: rgba(100, 160, 180, 0.2); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.3); }
    .status-badge.completed { background: rgba(92, 184, 144, 0.2); color: #5cb890; border: 1px solid rgba(92, 184, 144, 0.3); }
    .status-badge.cancelled { background: rgba(196, 112, 112, 0.2); color: #c47070; border: 1px solid rgba(196, 112, 112, 0.3); }

    .order-card-body {
        padding: 1.5rem;
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    }

    .customer-avatar {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .customer-name {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .customer-email {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .order-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .meta-item {
        background: rgba(0, 0, 0, 0.2);
        padding: 0.85rem;
        border-radius: 8px;
    }

    .meta-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }

    .meta-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
    }

    .meta-value.amount {
        color: #4ade80;
        font-size: 1rem;
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.7rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-view {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .btn-view:hover {
        background: rgba(100, 160, 180, 0.3);
    }

    .btn-status {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .btn-status:hover {
        background: rgba(100, 160, 180, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        margin: 0;
        font-size: 1.1rem;
    }

    @media (max-width: 1200px) {
        .stats-container { grid-template-columns: repeat(2, 1fr); }
        .orders-grid { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
    }

    @media (max-width: 768px) {
        .orders-page { padding: 1rem; }
        .page-header { flex-direction: column; text-align: center; }
        .page-title { font-size: 1.4rem; }
        .header-actions { width: 100%; flex-direction: column; }
        .filter-select, .btn-back { width: 100%; justify-content: center; }
        .stats-container { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
        .orders-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 480px) {
        .orders-grid { grid-template-columns: 1fr; }
    }

    /* Scrollbar Styling */
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

    .page-sidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(100, 160, 180, 0.2) transparent;
    }
</style>

<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'Orders'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <div class="orders-page">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <i class="fas fa-shopping-cart"></i>
                    {{ $user->isAdmin() ? 'Manage Orders' : 'My Orders' }}
                </div>
                <div class="header-actions">
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">⏳ Pending</option>
                        <option value="processing">⚙️ Processing</option>
                        <option value="completed">✅ Completed</option>
                        <option value="cancelled">❌ Cancelled</option>
                    </select>
                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-container">
                <div class="stat-card pending">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="stat-card processing">
                    <div class="stat-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $orders->where('status', 'processing')->count() }}</div>
                        <div class="stat-label">Processing</div>
                    </div>
                </div>
                <div class="stat-card completed">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $orders->where('status', 'completed')->count() }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
                <div class="stat-card cancelled">
                    <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $orders->where('status', 'cancelled')->count() }}</div>
                        <div class="stat-label">Cancelled</div>
                    </div>
                </div>
            </div>

            <!-- Orders Grid -->
            <div class="orders-grid">
                @forelse($orders as $order)
                <div class="order-card" data-status="{{ $order->status }}">
                    <!-- Card Header -->
                    <div class="order-card-header">
                        <div class="order-id-section">
                            <h4>
                                <i class="fas fa-receipt"></i>
                                #{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </h4>
                        </div>
                        <span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </div>

                    <!-- Card Body -->
                    <div class="order-card-body">
                        <!-- Customer Info -->
                        <div class="customer-info">
                            <div class="customer-avatar">
                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="customer-name">{{ $order->user->name }}</div>
                                <div class="customer-email">{{ $order->user->email }}</div>
                            </div>
                        </div>

                        <!-- Order Meta -->
                        <div class="order-meta">
                            <div class="meta-item">
                                <div class="meta-label">Items</div>
                                <div class="meta-value">{{ $order->orderItems ? $order->orderItems->count() : 0 }}</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Total</div>
                                <div class="meta-value amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Payment</div>
                                <div class="meta-value">
                                    <i class="fas fa-wallet"></i> E-Wallet
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Date</div>
                                <div class="meta-value">{{ $order->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn-action btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button class="btn-action btn-status" onclick="changeStatus({{ $order->id }}, '{{ $order->status }}')">
                                <i class="fas fa-sync"></i> Status
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <i class="fas fa-inbox"></i>
                    <p>No orders found</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('statusFilter')?.addEventListener('change', function() {
        const status = this.value;
        const cards = document.querySelectorAll('.order-card');
        
        cards.forEach(card => {
            if (!status || card.dataset.status === status) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    function changeStatus(orderId, currentStatus) {
        const statuses = ['pending', 'processing', 'completed', 'cancelled'];
        const currentIndex = statuses.indexOf(currentStatus);
        const nextStatus = statuses[(currentIndex + 1) % statuses.length];
        
        // Here you would make an AJAX call to update the status
        console.log(`Change order ${orderId} from ${currentStatus} to ${nextStatus}`);
    }
</script>
@endsection
