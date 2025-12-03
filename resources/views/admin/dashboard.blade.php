@extends('layouts.app')

@section('title', 'Admin Dashboard - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    {{ $user->isAdmin() ? 'Admin Dashboard' : 'Seller Dashboard' }}
                </h1>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center me-3">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="Profile" 
                                 class="rounded-circle me-2" 
                                 style="width: 32px; height: 32px; object-fit: cover;">
                        @else
                            <i class="fas fa-user-shield me-2"></i>
                        @endif
                        <div class="text-muted">
                            {{ $user->isAdmin() ? 'Administrator' : 'Seller: ' . $user->name }}
                        </div>
                    </div>
                    <a href="{{ route('admin.profile') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user-cog me-1"></i>Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Products
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_products']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cube fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Orders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_orders']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Revenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($user->isAdmin())
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_users']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Order Status Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Orders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['pending_orders']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed Orders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['completed_orders']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Cancelled Orders
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['cancelled_orders']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Charts for Sellers -->
        @if($user->isSeller())
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pendapatan Bulanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="110"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Order Selesai Bulanan</h6>
                </div>
                <div class="card-body">
                    <canvas id="ordersChart" height="110"></canvas>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Orders / Dompet Penghasilan for Seller -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $user->isSeller() ? 'Dompet Penghasilan' : 'Recent Orders' }}</h6>
                    @if($user->isSeller())
                        <a href="{{ route('wallet.index') }}" class="btn btn-sm btn-primary">Dompet Penghasilan</a>
                    @else
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary">View All</a>
                    @endif
                </div>
                <div class="card-body">
                    @if($user->isSeller())
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <div class="text-muted small">Pendapatan (Completed)</div>
                                <div class="h4 fw-bold text-success">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('wallet.index') }}" class="btn btn-success"><i class="fas fa-wallet me-1"></i>Lihat Dompet</a>
                                <a href="{{ route('wallet.index') }}#topup" class="btn btn-outline-primary"><i class="fas fa-plus me-1"></i>Top Up</a>
                            </div>
                        </div>
                        <hr>
                        <div class="small text-muted">Riwayat singkat transaksi terakhir Anda ditampilkan pada halaman Dompet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($order->status === 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: white; border-bottom: 1px solid #e3e6f0; border-radius: 15px 15px 0 0;">
                    <h6 class="m-0 font-weight-bold" style="color: #4e73df; font-size: 1rem;">Top Selling Products</h6>
                    <a href="{{ route('admin.products') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%); border: none; color: white; border-radius: 8px; padding: 6px 16px; font-weight: 500; text-decoration: none; transition: all 0.3s ease;">
                        View All
                    </a>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    @forelse($top_products as $product)
                    <div class="d-flex align-items-center mb-3" style="padding: 0.75rem 0; border-bottom: 1px solid #f8f9fc;">
                        <div class="me-3">
                            <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" 
                                 class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="color: #5a5c69; font-size: 0.95rem; margin-bottom: 2px;">{{ $product->name }}</div>
                            <div class="text-muted" style="font-size: 0.8rem;">{{ number_format($product->sales_count) }} sold</div>
                        </div>
                        <div class="fw-bold" style="color: #4e73df; font-size: 0.95rem;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-cube fa-2x mb-2" style="color: #dddfeb;"></i>
                        <div>No products found</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4 quick-actions-card">
                <div class="card-header py-4 text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="m-0 text-white font-weight-bold">
                        <i class="fas fa-rocket me-2"></i>Quick Actions
                    </h4>
                    <p class="text-white-50 mb-0 mt-2">Manage your store efficiently</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.products.create') }}" class="quick-action-btn btn-add-product">
                                <div class="quick-action-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="mb-1">Add Product</h6>
                                    <small class="text-muted">Create new product</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.products') }}" class="quick-action-btn btn-manage-products">
                                <div class="quick-action-icon">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="mb-1">Manage Products</h6>
                                    <small class="text-muted">Edit & organize</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.orders') }}" class="quick-action-btn btn-view-orders">
                                <div class="quick-action-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="mb-1">View Orders</h6>
                                    <small class="text-muted">Process orders</small>
                                </div>
                            </a>
                        </div>
                        @if(auth()->user()->isAdmin())
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.users') }}" class="quick-action-btn btn-manage-users">
                                <div class="quick-action-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="mb-1">Manage Users</h6>
                                    <small class="text-muted">User management</small>
                                </div>
                            </a>
                        </div>
                        @else
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('wallet.index') }}" class="quick-action-btn btn-wallet">
                                <div class="quick-action-icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="mb-1">My Wallet</h6>
                                    <small class="text-muted">Earnings & balance</small>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

/* Quick Actions Styling */
.quick-actions-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.quick-action-btn {
    display: flex;
    align-items: center;
    padding: 20px;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    height: 100%;
}

.quick-action-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    color: #333;
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 20px;
    color: white;
    transition: all 0.3s ease;
}

.quick-action-content h6 {
    font-weight: 600;
    margin-bottom: 4px;
    color: #333;
}

.quick-action-content small {
    color: #6c757d;
    font-size: 0.8rem;
}

/* Button Colors */
.btn-add-product .quick-action-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.btn-add-product:hover {
    border-color: #28a745;
}

.btn-manage-products .quick-action-icon {
    background: linear-gradient(135deg, #17a2b8 0%, #0dcaf0 100%);
}

.btn-manage-products:hover {
    border-color: #17a2b8;
}

.btn-view-orders .quick-action-icon {
    background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);
}

.btn-view-orders:hover {
    border-color: #fd7e14;
}

.btn-manage-users .quick-action-icon {
    background: linear-gradient(135deg, #6f42c1 0%, #6610f2 100%);
}

.btn-manage-users:hover {
    border-color: #6f42c1;
}

.btn-wallet .quick-action-icon {
    background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
}

.btn-wallet:hover {
    border-color: #00d4aa;
}

/* Responsive */
@media (max-width: 768px) {
    .quick-action-btn {
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .quick-action-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
        margin-right: 12px;
    }
    
    .quick-action-content h6 {
        font-size: 0.9rem;
    }
    
    .quick-action-content small {
        font-size: 0.75rem;
    }
}

.text-xs {
    font-size: 0.7rem;
}

.text-sm {
    font-size: 0.875rem;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-600 {
    color: #858796 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.btn-block {
    display: block;
    width: 100%;
}
</style>

@if($user->isSeller())
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
    const monthLabels = @json($months);
    const revenueData = @json(array_values($revenueSeries));
    const ordersData  = @json(array_values($ordersSeries));

    const revCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Rp',
                data: revenueData,
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28,200,138,0.15)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
                pointBackgroundColor: '#1cc88a'
            }]
        },
        options: { responsive: true, scales: { y: { ticks: { callback: (v)=> 'Rp ' + v.toLocaleString('id-ID') } } } }
    });

    const ordCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordCtx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Orders',
                data: ordersData,
                backgroundColor: '#4e73df'
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true, precision: 0 } } }
    });
});
</script>
@endif
@endsection
