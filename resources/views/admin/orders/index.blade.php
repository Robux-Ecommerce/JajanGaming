@extends('layouts.app')

@section('title', 'Manage Orders - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    {{ $user->isAdmin() ? 'Manage Orders' : 'My Orders' }}
                </h1>
                <div class="d-flex">
                    <select class="form-select me-2" id="statusFilter" onchange="filterOrders()">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Roblox Username</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($order->roblox_username)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-gamepad me-1"></i>{{ $order->roblox_username }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="font-weight-bold">{{ $order->orderItems->count() }}</div>
                                    <small class="text-muted">items</small>
                                </div>
                            </td>
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge bg-info">Processing</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($order->payment_method === 'wallet')
                                    <span class="badge bg-primary">DompetKu</span>
                                @else
                                    <span class="badge bg-info">Payment Gateway</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $order->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status === 'pending' || $order->status === 'processing')
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown" title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-clock me-2"></i>Mark as Processing
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-check me-2"></i>Mark as Completed
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-times me-2"></i>Cancel Order
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                    <p>No orders found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function filterOrders() {
    const status = document.getElementById('statusFilter').value;
    const url = new URL(window.location);
    
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    
    window.location.href = url.toString();
}

// Set current filter value
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    if (status) {
        document.getElementById('statusFilter').value = status;
    }
});
</script>

<style>
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
    color: #5a5c69;
}

.table td {
    vertical-align: middle;
    border-color: #e3e6f0;
}

.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #4e73df;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.badge {
    font-size: 0.75rem;
}

.text-warning {
    color: #f6c23e !important;
}

.text-success {
    color: #1cc88a !important;
}

.text-primary {
    color: #4e73df !important;
}

.text-info {
    color: #36b9cc !important;
}

.text-danger {
    color: #e74a3b !important;
}

.text-muted {
    color: #858796 !important;
}

.dropdown-item:hover {
    background-color: #f8f9fc;
}

.dropdown-item.text-danger:hover {
    background-color: #f8d7da;
}
</style>
@endsection
