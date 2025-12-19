@extends('layouts.app')

@section('title', $seller->name . ' - Seller Profile - JajanGaming')

@section('content')
<style>
    .seller-profile-container {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .seller-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .seller-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid rgba(255, 255, 255, 0.3);
        margin-bottom: 1rem;
    }

    .seller-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .seller-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }

    .seller-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .seller-badge.trusted {
        background: rgba(255, 193, 7, 0.3);
        border-color: rgba(255, 193, 7, 0.5);
    }

    .seller-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .seller-meta-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.5rem 0.85rem;
        border-radius: 15px;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 2rem;
    }

    .stat-block h6 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .stat-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .stat-icon {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.85rem;
        opacity: 0.85;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.15rem;
        font-weight: 700;
    }

    .stat-sub {
        font-size: 0.75rem;
        opacity: 0.7;
    }

    .rating-section {
        text-align: right;
    }

    .rating-large {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .rating-stars-large {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .rating-count {
        font-size: 0.85rem;
        opacity: 0.8;
    }

    .rating-bars {
        margin-top: 1.5rem;
    }

    .rating-bar-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.65rem;
    }

    .rating-bar-label {
        font-size: 0.9rem;
        min-width: 15px;
    }

    .rating-bar-star {
        font-size: 0.85rem;
    }

    .rating-bar {
        flex: 1;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        overflow: hidden;
    }

    .rating-bar-fill {
        height: 100%;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .rating-bar-count {
        font-size: 0.85rem;
        min-width: 30px;
        text-align: right;
    }

    .products-section {
        margin-top: 2.5rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
    }

    .filter-dropdown {
        background: rgba(0, 212, 170, 0.1);
        border: 2px solid #00d4aa;
        color: #00d4aa;
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-dropdown:hover {
        background: rgba(0, 212, 170, 0.2);
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .empty-text {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.65rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateX(-5px);
    }

    .status-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #00d4aa;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .rating-section {
            text-align: left;
            margin-top: 1.5rem;
        }
    }
</style>

<div class="seller-profile-container">
    <div class="container">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>

        <!-- Seller Header Card -->
        <div class="seller-header-card">
            <div class="row">
                <div class="col-lg-4">
                    <div class="seller-avatar-large">
                        <i class="fas fa-store fa-3x" style="color: #667eea;"></i>
                    </div>
                    <h1 class="seller-name">{{ $seller->name }}</h1>
                    <div class="seller-badges">
                        <span class="seller-badge trusted">
                            <i class="fas fa-shield-alt"></i> Trusted
                        </span>
                        <span class="seller-badge">
                            <i class="fas fa-share-alt"></i> Bagikan
                        </span>
                    </div>
                    <div class="seller-meta">
                        <span class="seller-meta-item">
                            <i class="fas fa-calendar"></i> Sejak {{ $seller->created_at->format('d M Y') }}
                        </span>
                        <span class="seller-meta-item">
                            <span class="status-dot"></span> Online {{ rand(1, 60) }} mnt lalu
                        </span>
                        <span class="seller-meta-item">
                            <i class="fas fa-clock"></i> 24 Jam
                        </span>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="stats-grid">
                        <!-- Transaksi -->
                        <div class="stat-block">
                            <h6>Transaksi</h6>
                            <div class="stat-item">
                                <i class="fas fa-users stat-icon"></i>
                                <div class="stat-content">
                                    <div class="stat-label">Pembeli</div>
                                    <div class="stat-value">{{ number_format($uniqueBuyers) }} Orang</div>
                                    <div class="stat-sub">(2 Minggu Terakhir)</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle stat-icon"></i>
                                <div class="stat-content">
                                    <div class="stat-label">Terjual</div>
                                    <div class="stat-value">{{ $successRate }}% ({{ number_format($completedOrders) }} / {{ number_format($totalOrders) }})</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock stat-icon"></i>
                                <div class="stat-content">
                                    <div class="stat-label">Rata-rata Pengiriman</div>
                                    <div class="stat-value">
                                        @if($avgDeliveryHours > 0)
                                            {{ number_format($avgDeliveryHours, 1) }} jam
                                        @else
                                            Belum ada data
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="stat-block rating-section" style="grid-column: span 2;">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6>Rating</h6>
                                <a href="#" class="text-white text-decoration-none" style="font-size: 0.85rem;">Lihat Semua Ulasan</a>
                            </div>
                            <div class="rating-large">{{ number_format($averageRating, 2) }}<span style="font-size: 1.5rem;">/5</span></div>
                            <div class="rating-stars-large">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fa{{ $i <= floor($averageRating) ? 's' : 'r' }} fa-star text-warning"></i>
                                @endfor
                            </div>
                            <div class="rating-count">{{ $totalRatings }} ulasan</div>
                            
                            <div class="rating-bars">
                                @php $total = max($totalRatings, 1); @endphp
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $count = $ratingDistribution[$i] ?? 0;
                                        $percent = round(($count / $total) * 100);
                                    @endphp
                                    <div class="rating-bar-item">
                                        <span class="rating-bar-label">{{ $i }}</span>
                                        <i class="fas fa-star rating-bar-star text-warning"></i>
                                        <div class="rating-bar">
                                            <div class="rating-bar-fill" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="rating-bar-count">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="products-section">
            <div class="section-header">
                <h2 class="section-title">Produk {{ $seller->name }}</h2>
                <button class="filter-dropdown">
                    Tampilkan Semua Produk <i class="fas fa-chevron-down ms-2"></i>
                </button>
            </div>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card-landscape" onclick="window.location.href='{{ route('product.show', $product) }}'">
                                <div class="card-landscape-image">
                                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                                    @if($product->sales_count > 0)
                                        <div class="badge-overlay">
                                            <span class="badge bg-success">
                                                <i class="fas fa-fire me-1"></i>{{ $product->sales_count }} Terjual
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-landscape-content">
                                    <h6 class="product-title">{{ $product->name }}</h6>
                                    <div class="product-meta">
                                        <span class="badge badge-sm bg-primary">{{ $product->game_name }}</span>
                                    </div>
                                    <div class="product-footer">
                                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        <div class="product-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($product->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= $product->rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                            <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3 class="empty-title">No Products Found</h3>
                    <p class="empty-text">This seller hasn't added any products yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

                            <!-- Star Rating Breakdown -->
                            <div class="rating-breakdown">
                                @php
                                    $total = max($totalRatings, 1);
                                @endphp
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $count = $ratingDistribution[$i] ?? 0;
                                        $percent = round(($count / $total) * 100);
                                    @endphp
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2 small">{{ $i }}</span>
                                        <i class="fas fa-star text-warning me-2" style="font-size: 0.8rem;"></i>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-primary" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="small">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Produk {{ $seller->name }}</h4>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Tampilkan Semua Produk
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Semua Produk</a></li>
                        <li><a class="dropdown-item" href="#">Robux</a></li>
                        <li><a class="dropdown-item" href="#">Blox Fruits</a></li>
                        <li><a class="dropdown-item" href="#">Game Items</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm seller-product-card" style="cursor: pointer; border-radius: 15px; overflow: hidden;" 
                         onclick="window.location.href='{{ route('product.show', $product) }}'">
                        <div class="position-relative">
                            <img src="{{ asset('img/' . $product->image) }}" 
                                 class="card-img-top seller-product-image" 
                                 alt="{{ $product->name }}"
                                 style="height: 180px; object-fit: cover; object-position: center 65%;">
                            @if($product->sales_count > 0)
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-fire me-1"></i>{{ $product->sales_count }} Terjual
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="card-title mb-2 fw-bold">{{ $product->name }}</h6>
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $product->category }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="text-success mb-0 fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h5>
                                <div class="d-flex align-items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                            <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                        @elseif($i - 0.5 <= $product->rating)
                                            <i class="fas fa-star-half-alt text-warning" style="font-size: 0.8rem;"></i>
                                        @else
                                            <i class="far fa-star text-warning" style="font-size: 0.8rem;"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-1 small text-muted">{{ number_format($product->rating, 1) }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-success">
                                    <i class="fas fa-bolt me-1"></i>Pengiriman INSTAN
                                </small>
                                <small class="text-muted">{{ $product->stock }} tersedia</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Products Found</h4>
                    <p class="text-muted">This seller hasn't added any products yet.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
.seller-product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
}

.seller-product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s ease;
    z-index: 1;
}

.seller-product-card:hover::before {
    left: 100%;
}

.seller-product-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 
        0 20px 40px rgba(0,0,0,0.1),
        0 8px 16px rgba(0,0,0,0.08),
        inset 0 1px 0 rgba(255,255,255,0.2);
    border-color: rgba(102, 126, 234, 0.2);
}

.seller-product-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    object-position: center;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.seller-product-card:hover .seller-product-image {
    transform: scale(1.05);
    filter: brightness(1.05) contrast(1.02) saturate(1.1);
}

.rating-breakdown .progress {
    background-color: rgba(255,255,255,0.2);
    border-radius: 4px;
}

.rating-breakdown .progress-bar {
    background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 4px;
}

/* Pills and accents */
.info-pill { border-radius: 999px; padding: 6px 10px; font-weight: 600; }
.status-dot { width: 8px; height: 8px; background: #28a745; border-radius: 50%; display: inline-block; }
.text-shadow { text-shadow: 0 2px 8px rgba(0,0,0,0.2); }

/* Back button pill */
        .back-btn-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border: 1px solid rgba(108,117,125,.4);
            border-radius: 15px;
            color: #343a40;
            font-weight: 500;
            text-decoration: none;
            background: #f8f9fa;
            transition: all .2s ease;
            box-shadow: 0 1px 0 rgba(0,0,0,0.01) inset;
            font-size: 0.7rem;
            width: auto !important;
            max-width: max-content;
            white-space: nowrap;
        }
.back-btn-pill:hover { color: #343a40; border-color: rgba(108,117,125,.9); background: #ffffff; box-shadow: 0 6px 16px rgba(0,0,0,0.06); transform: translateY(-1px); }
.back-btn-pill:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
</style>
@endsection