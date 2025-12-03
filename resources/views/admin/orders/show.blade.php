@extends('layouts.app')

@section('title', 'Order Details - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>Order #{{ $order->id }}
                </h1>
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Order Details</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Order ID:</strong></td>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Date:</strong></td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
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
                                </tr>
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td>
                                        @if($order->payment_method === 'wallet')
                                            <span class="badge bg-primary">DompetKu</span>
                                        @else
                                            <span class="badge bg-info">Payment Gateway</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Customer Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $order->user->email }}</td>
                                </tr>
                                @if($order->roblox_username)
                                <tr>
                                    <td><strong><i class="fas fa-gamepad me-1"></i>Roblox Username:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $order->roblox_username }}</span>
                                        <small class="text-muted d-block">For top-up delivery</small>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Wallet Balance:</strong></td>
                                    <td>Rp {{ number_format($order->user->wallet_balance, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('img/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                                 class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                            <div>
                                                <div class="font-weight-bold">{{ $item->product->name }}</div>
                                                <small class="text-muted">{{ $item->product->game_type }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="3" class="text-right">Total Amount:</td>
                                    <td class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Actions</h6>
                </div>
                <div class="card-body">
                    @if($order->status === 'pending' || $order->status === 'processing')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        This order is {{ $order->status }} and cannot be modified.
                    </div>
                    @endif

                    <div class="mt-4">
                        <h6 class="font-weight-bold">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="mailto:{{ $order->user->email }}" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-2"></i>Contact Customer
                            </a>
                            <button class="btn btn-outline-info" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Items ({{ $order->orderItems->count() }}):</span>
                        <span>Rp {{ number_format($order->orderItems->sum(function($item) { return $item->price * $item->quantity; }), 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Total:</span>
                        <span class="text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

@media print {
    .btn, .card-header, .alert {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
}
</style>
@endsection
