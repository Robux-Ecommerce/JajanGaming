@extends('layouts.app')

@section('title', 'Manage Products - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-cube me-2"></i>
                    {{ $user->isAdmin() ? 'Manage Products' : 'My Products' }}
                </h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $user->isAdmin() ? 'All Products' : 'My Products' }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Game</th>
                            @if($user->isAdmin())
                            <th>Seller</th>
                            @endif
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Sales</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" 
                                     class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            </td>
                            <td>
                                <div class="font-weight-bold">{{ $product->name }}</div>
                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $product->game_name }}</span>
                                <br>
                                <small class="text-muted">{{ $product->game_type }}</small>
                            </td>
                            @if($user->isAdmin())
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('img/sellers/' . $product->seller_photo) }}" alt="{{ $product->seller_name }}" 
                                         class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
                                    <span>{{ $product->seller_name }}</span>
                                </div>
                            </td>
                            @endif
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge {{ $product->quantity > 10 ? 'bg-success' : ($product->quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">
                                    {{ number_format($product->sales_count) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </span>
                                    <span class="ms-1">{{ number_format($product->rating, 1) }}</span>
                                </div>
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $user->isAdmin() ? '10' : '9' }}" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-cube fa-3x mb-3"></i>
                                    <p>No products found</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Your First Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
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

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.text-warning {
    color: #f6c23e !important;
}

.text-primary {
    color: #4e73df !important;
}

.text-success {
    color: #1cc88a !important;
}

.text-danger {
    color: #e74a3b !important;
}

.text-muted {
    color: #858796 !important;
}
</style>
@endsection
