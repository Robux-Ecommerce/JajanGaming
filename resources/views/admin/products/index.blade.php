@extends('layouts.app')

@section('title', 'Manage Products - JajanGaming')

@section('content')
<style>
    .products-page {
        background: linear-gradient(180deg, #121a24 0%, #1a2a38 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .page-title {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: #64a0b4;
        font-size: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        transform: translateY(-2px);
    }

    .btn-add-product {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
    }

    .btn-add-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(100, 160, 180, 0.4);
        color: white;
    }

    .products-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .card-header-custom {
        background: rgba(100, 160, 180, 0.1);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.15);
    }

    .card-header-custom h6 {
        color: #64a0b4;
        font-weight: 600;
        margin: 0;
        font-size: 1rem;
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    .products-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .products-table thead th {
        background: rgba(100, 160, 180, 0.1);
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
        white-space: nowrap;
    }

    .products-table thead th:first-child {
        border-radius: 12px 0 0 12px;
    }

    .products-table thead th:last-child {
        border-radius: 0 12px 12px 0;
    }

    .products-table tbody tr {
        background: rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .products-table tbody tr:hover {
        background: rgba(100, 160, 180, 0.1);
        transform: scale(1.01);
    }

    .products-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.85);
        vertical-align: middle;
    }

    .product-img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid rgba(100, 160, 180, 0.3);
        transition: all 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.1);
        border-color: #64a0b4;
    }

    .product-name {
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.25rem;
    }

    .product-desc {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }

    .badge-game {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-type {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }

    .seller-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .seller-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(100, 160, 180, 0.3);
    }

    .seller-name {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.875rem;
    }

    .price-tag {
        color: #5cb85c;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .stock-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .stock-high {
        background: rgba(92, 184, 92, 0.2);
        color: #5cb85c;
    }

    .stock-medium {
        background: rgba(240, 173, 78, 0.2);
        color: #f0ad4e;
    }

    .stock-low {
        background: rgba(217, 83, 79, 0.2);
        color: #d9534f;
    }

    .sales-count {
        color: #64a0b4;
        font-weight: 600;
    }

    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .rating-stars i {
        color: #f0ad4e;
        font-size: 0.8rem;
    }

    .rating-value {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        margin-left: 0.25rem;
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-active {
        background: rgba(92, 184, 92, 0.2);
        color: #5cb85c;
    }

    .status-inactive {
        background: rgba(217, 83, 79, 0.2);
        color: #d9534f;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-edit {
        background: rgba(100, 160, 180, 0.2);
        color: #64a0b4;
    }

    .btn-edit:hover {
        background: #64a0b4;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: rgba(217, 83, 79, 0.2);
        color: #d9534f;
    }

    .btn-delete:hover {
        background: #d9534f;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: rgba(100, 160, 180, 0.3);
        margin-bottom: 1rem;
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination-wrapper .pagination {
        gap: 0.5rem;
    }

    .pagination-wrapper .page-link {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: rgba(255, 255, 255, 0.7);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .pagination-wrapper .page-link:hover {
        background: rgba(100, 160, 180, 0.2);
        color: #ffffff;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: #64a0b4;
        border-color: #64a0b4;
        color: white;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .header-actions {
            margin-top: 1rem;
            width: 100%;
        }

        .btn-back, .btn-add-product {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="products-page">
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="page-title">
                    <i class="fas fa-cube"></i>
                    {{ $user->isAdmin() ? 'Manage Products' : 'My Products' }}
                </h1>
                <div class="header-actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn-add-product">
                        <i class="fas fa-plus"></i>Add New Product
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Table Card -->
        <div class="products-card">
            <div class="card-header-custom">
                <h6><i class="fas fa-list me-2"></i>{{ $user->isAdmin() ? 'All Products' : 'My Products' }}</h6>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="products-table">
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
                                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                                </td>
                                <td>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-desc">{{ Str::limit($product->description, 50) }}</div>
                                </td>
                                <td>
                                    <span class="badge-game">{{ $product->game_name }}</span>
                                    <span class="badge-type">{{ $product->game_type }}</span>
                                </td>
                                @if($user->isAdmin())
                                <td>
                                    <div class="seller-info">
                                        <img src="{{ asset('img/sellers/' . $product->seller_photo) }}" alt="{{ $product->seller_name }}" class="seller-avatar">
                                        <span class="seller-name">{{ $product->seller_name }}</span>
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <span class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="stock-badge {{ $product->quantity > 10 ? 'stock-high' : ($product->quantity > 0 ? 'stock-medium' : 'stock-low') }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td>
                                    <span class="sales-count">{{ number_format($product->sales_count) }}</span>
                                </td>
                                <td>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                                        @endfor
                                        <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $user->isAdmin() ? '10' : '9' }}">
                                    <div class="empty-state">
                                        <i class="fas fa-cube"></i>
                                        <p>No products found</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn-add-product">
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
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
