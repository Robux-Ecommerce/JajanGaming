@extends('layouts.app')

@section('title', isset($selectedSeller) ? $selectedSeller->name . ' Products - JajanGaming' : 'Manage Products - JajanGaming')

@section('content')
<style>
    .products-page {
        background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Page Header - Compact */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .page-title i { color: #64a0b4; }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn-back, .btn-add {
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    .btn-add {
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.25);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(100, 160, 180, 0.35);
        color: white;
    }

    /* Search & Filter Bar */
    .filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 12px;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-box input::placeholder { color: rgba(255, 255, 255, 0.4); }

    .search-box input:focus {
        outline: none;
        border-color: rgba(100, 160, 180, 0.5);
        background: rgba(255, 255, 255, 0.08);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(100, 160, 180, 0.6);
    }

    .stats-pills {
        display: flex;
        gap: 0.75rem;
    }

    .stat-pill {
        padding: 0.6rem 1rem;
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.15);
        border-radius: 20px;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stat-pill strong {
        color: #64a0b4;
        font-weight: 700;
    }

    /* ==================== COMPACT SELLERS TABLE ==================== */
    .sellers-table {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 16px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
    }

    .sellers-table-header {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 120px;
        padding: 1rem 1.5rem;
        background: rgba(100, 160, 180, 0.08);
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(100, 160, 180, 0.8);
        font-weight: 600;
    }

    .seller-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 120px;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        align-items: center;
        transition: all 0.25s ease;
        cursor: pointer;
    }

    .seller-row:hover {
        background: rgba(100, 160, 180, 0.08);
    }

    .seller-row:last-child {
        border-bottom: none;
    }

    .seller-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .seller-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .seller-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .seller-avatar i {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .seller-details h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
        margin: 0 0 0.25rem 0;
    }

    .seller-details span {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .seller-stat {
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
    }

    .seller-stat.products { color: #64a0b4; }
    .seller-stat.sales { color: #4ade80; }

    .btn-view {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
        border: 1px solid rgba(100, 160, 180, 0.25);
        border-radius: 8px;
        color: #64a0b4;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: rgba(100, 160, 180, 0.25);
        color: #8ecad8;
        transform: translateX(3px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: rgba(100, 160, 180, 0.3);
    }

    /* ==================== PRODUCTS GRID ==================== */
    .selected-seller-bar {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.12), rgba(100, 160, 180, 0.05));
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        margin-bottom: 1.5rem;
    }

    .selected-seller-bar .seller-avatar {
        width: 48px;
        height: 48px;
    }

    .selected-seller-bar h4 {
        color: #fff;
        font-size: 1.1rem;
        margin: 0;
    }

    .selected-seller-bar p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        margin: 0.2rem 0 0;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .product-card {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.7), rgba(37, 53, 69, 0.7));
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(100, 160, 180, 0.15);
        border-color: rgba(100, 160, 180, 0.25);
    }

    .product-image {
        width: 100%;
        height: 120px;
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.08), rgba(100, 160, 180, 0.03));
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image i {
        font-size: 2.5rem;
        color: rgba(100, 160, 180, 0.25);
    }

    .product-status {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 0.25rem 0.6rem;
        border-radius: 15px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .product-status.active {
        background: rgba(74, 222, 128, 0.2);
        color: #4ade80;
    }

    .product-status.inactive {
        background: rgba(196, 112, 112, 0.2);
        color: #c47070;
    }

    .product-body {
        padding: 1rem;
    }

    .product-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.4rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-type {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.4);
        margin-bottom: 0.75rem;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .product-price {
        font-size: 1rem;
        font-weight: 700;
        color: #4ade80;
    }

    .product-sales {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .product-actions {
        display: flex;
        gap: 0.4rem;
    }

    .btn-edit, .btn-delete {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn-edit {
        background: rgba(100, 160, 180, 0.12);
        color: #64a0b4;
    }

    .btn-edit:hover {
        background: rgba(100, 160, 180, 0.2);
    }

    .btn-delete {
        background: rgba(196, 112, 112, 0.12);
        color: #c47070;
    }

    .btn-delete:hover {
        background: rgba(196, 112, 112, 0.2);
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.4rem;
    }

    .pagination-wrapper .page-link {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.15);
        color: #64a0b4;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        transition: all 0.25s ease;
    }

    .pagination-wrapper .page-link:hover {
        background: rgba(100, 160, 180, 0.2);
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        border-color: transparent;
        color: white;
    }

    /* Scrollbar */
    .page-sidebar::-webkit-scrollbar { width: 5px; }
    .page-sidebar::-webkit-scrollbar-track { background: transparent; }
    .page-sidebar::-webkit-scrollbar-thumb { background: rgba(100, 160, 180, 0.2); border-radius: 3px; }
    .page-sidebar { scrollbar-width: thin; scrollbar-color: rgba(100, 160, 180, 0.2) transparent; }

    /* Responsive */
    @media (max-width: 992px) {
        .sellers-table-header { display: none; }
        .seller-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 1rem;
        }
        .seller-info { flex: 1; min-width: 200px; }
        .stats-pills { display: none; }
    }

    @media (max-width: 768px) {
        .products-page { padding: 1rem; }
        .page-header { flex-direction: column; }
        .header-actions { width: 100%; justify-content: center; }
        .products-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .products-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'Products'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <div class="products-page">
            @if(isset($selectedSeller))
                {{-- ==================== PRODUCTS VIEW ==================== --}}
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-cube"></i>
                        Products
                    </h1>
                    <div class="header-actions">
                        @if($user->isAdmin())
                        <a href="{{ route('admin.products') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Sellers
                        </a>
                        @endif
                        <a href="{{ route('admin.products.create') }}" class="btn-add">
                            <i class="fas fa-plus"></i> Add
                        </a>
                    </div>
                </div>

                <!-- Selected Seller Bar -->
                <div class="selected-seller-bar">
                    <div class="seller-avatar">
                        @if($selectedSeller->profile_photo)
                            <img src="{{ asset('storage/' . $selectedSeller->profile_photo) }}" alt="{{ $selectedSeller->name }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div>
                        <h4>{{ $selectedSeller->name }}</h4>
                        <p>{{ $products->total() }} products • {{ $selectedSeller->email }}</p>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                                @php
                                    $randomImages = [
                                        'img/rbg1.jpg', 'img/rbg2.jpg', 'img/rbg3.jpg', 'img/rbg4.jpg', 'img/rbg5.jpg', 'img/rbg6.jpg',
                                        'img/roblox.jpg', 'img/download.jpg', 'img/download.png', 'img/gambar 1.jpeg', 'img/gambar 2.webp', 'img/gambar 3.jpg'
                                    ];
                                    $fallback = $randomImages[array_rand($randomImages)];
                                @endphp
                                <img src="{{ asset($fallback) }}" alt="Random Product Image">
                            @endif
                            <span class="product-status {{ $product->is_active ? 'active' : 'inactive' }}">
                                {{ $product->is_active ? 'Active' : 'Off' }}
                            </span>
                        </div>
                        <div class="product-body">
                            <h4 class="product-name" title="{{ $product->name }}">{{ $product->name }}</h4>
                            <p class="product-type">{{ $product->game_type ?? 'Roblox' }}</p>
                            <div class="product-meta">
                                <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="product-sales">{{ $product->sales_count ?? 0 }} sold</span>
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" style="width: 100%;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-box-open"></i>
                        <h4>No Products</h4>
                        <p>This seller has no products yet.</p>
                    </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->appends(['seller_id' => $selectedSeller->id])->links() }}
                </div>
                @endif

            @else
                {{-- ==================== SELLERS LIST VIEW ==================== --}}
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="fas fa-store"></i>
                        Sellers
                    </h1>
                    <div class="header-actions">
                        <a href="{{ route('admin.dashboard') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn-add">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="filter-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="sellerSearch" placeholder="Search sellers..." onkeyup="filterSellers()">
                    </div>
                    <div class="stats-pills">
                        <div class="stat-pill">
                            <i class="fas fa-users"></i>
                            <strong>{{ $sellers->count() }}</strong> Sellers
                        </div>
                        <div class="stat-pill">
                            <i class="fas fa-cube"></i>
                            <strong>{{ $sellers->sum('total_products') }}</strong> Products
                        </div>
                        <div class="stat-pill">
                            <i class="fas fa-shopping-cart"></i>
                            <strong>{{ $sellers->sum('total_sales') }}</strong> Sales
                        </div>
                    </div>
                </div>

                <!-- Sellers Table -->
                <div class="sellers-table">
                    <div class="sellers-table-header">
                        <div>Seller</div>
                        <div>Products</div>
                        <div>Sales</div>
                        <div>Action</div>
                    </div>
                    <div id="sellersContainer">
                        @forelse($sellers as $seller)
                        <div class="seller-row" data-name="{{ strtolower($seller->name) }}" onclick="window.location.href='{{ route('admin.products', ['seller_id' => $seller->id]) }}'">
                            <div class="seller-info">
                                <div class="seller-avatar">
                                    @if($seller->profile_photo)
                                        <img src="{{ asset('storage/' . $seller->profile_photo) }}" alt="{{ $seller->name }}">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
                                <div class="seller-details">
                                    <h4>{{ $seller->name }}</h4>
                                    <span>{{ $seller->email }}</span>
                                </div>
                            </div>
                            <div class="seller-stat products">{{ $seller->total_products }}</div>
                            <div class="seller-stat sales">{{ $seller->total_sales }}</div>
                            <div>
                                <a href="{{ route('admin.products', ['seller_id' => $seller->id]) }}" class="btn-view" onclick="event.stopPropagation();">
                                    View <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-store-slash"></i>
                            <h4>No Sellers</h4>
                            <p>No sellers registered yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function filterSellers() {
    const searchValue = document.getElementById('sellerSearch').value.toLowerCase();
    const rows = document.querySelectorAll('.seller-row');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        if (name.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
