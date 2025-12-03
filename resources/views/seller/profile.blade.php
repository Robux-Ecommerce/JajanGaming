@extends('layouts.app')

@section('title', $seller->name . ' - Seller Profile - JajanGaming')

@section('content')
<div class="container-fluid">
    <!-- Action Bar -->
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-start">
            <a href="{{ url('/') }}" class="back-btn-pill" onclick="event.preventDefault(); if(document.referrer){ window.history.back(); } else { window.location.href='{{ url('/') }}'; }">
                <i class="fas fa-arrow-left me-2"></i> Back to Products
            </a>
        </div>
    </div>

    <!-- Store Profile Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                <div class="card-body text-white p-4">
                    <div class="row align-items-center">
                        <!-- Store Avatar & Info -->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($seller->profile_photo)
                                        <img src="{{ asset('storage/' . $seller->profile_photo) }}" 
                                             alt="{{ $seller->name }}" 
                                             class="rounded-circle" 
                                             style="width: 80px; height: 80px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" 
                                             style="width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3);">
                                            <i class="fas fa-user fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="h3 mb-2 fw-bold">{{ $seller->name }}</h2>
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <span class="badge bg-warning-subtle text-dark border info-pill"><i class="fas fa-shield-alt me-1 text-warning"></i>Trusted</span>
                                        <span class="badge bg-light text-dark border info-pill"><i class="fas fa-share-alt me-1"></i>Bagikan</span>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="badge bg-white text-dark border info-pill"><i class="fas fa-calendar me-1 text-primary"></i>Sejak {{ $seller->created_at->format('d M Y') }}</span>
                                        <span class="badge bg-white text-dark border info-pill"><span class="status-dot me-1"></span>Online {{ rand(1, 60) }} mnt lalu</span>
                                        <span class="badge bg-white text-dark border info-pill"><i class="fas fa-clock me-1 text-success"></i>24 Jam</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Statistics -->
                        <div class="col-md-4">
                            <h5 class="fw-bold mb-3">Transaksi</h5>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-users me-2"></i>
                                    <span class="fw-medium">Pembeli</span>
                                </div>
                                <div class="ms-4">
                                    <span class="h5 mb-0">{{ number_format($uniqueBuyers) }} Orang</span>
                                    <small class="d-block text-light">(2 Minggu Terakhir)</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span class="fw-medium">Terjual</span>
                                </div>
                                <div class="ms-4">
                                    <span class="h5 mb-0">{{ $successRate }}% ({{ number_format($completedOrders) }} / {{ number_format($totalOrders) }})</span>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-clock me-2"></i>
                                    <span class="fw-medium">Rata-rata Pengiriman</span>
                                </div>
                                <div class="ms-4">
                                    <span class="h5 mb-0">
                                        @if($avgDeliveryHours > 0)
                                            {{ number_format($avgDeliveryHours, 1) }} jam
                                        @else
                                            <span class="text-muted">Belum ada data</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Section -->
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Rating</h5>
                                <a href="#" class="text-white text-decoration-none small">Lihat Semua Ulasan</a>
                            </div>
                            <div class="text-center mb-3">
                                <div class="display-6 fw-bold mb-1 text-shadow">{{ number_format($averageRating, 2) }}<span class="h5">/5</span></div>
                                <div class="mb-1">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa{{ $i <= floor($averageRating) ? 's' : 'r' }} fa-star text-warning"></i>
                                    @endfor
                                </div>
                                <div class="small text-light-50">{{ $totalRatings }} ulasan</div>
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