@extends('layouts.app')

@section('title', $product->name . ' - JajanGaming')

@section('content')
<style>
    .product-detail-container {
        background: linear-gradient(180deg, #121a24 0%, #1a2a38 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .product-hero {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .product-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .product-subtitle {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-subtitle .badge {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .product-main-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .product-image-wrapper {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(100, 160, 180, 0.2);
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .product-image-wrapper::after {
        content: '';
        position: absolute;
        inset: -2px;
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.3), rgba(74, 138, 158, 0.3), rgba(92, 184, 92, 0.3));
        border-radius: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
        filter: blur(20px);
    }

    .product-image-wrapper:hover {
        border-color: rgba(100, 160, 180, 0.4);
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
    }

    .product-image-wrapper:hover::after {
        opacity: 1;
    }

    .main-product-image {
        width: 100%;
        aspect-ratio: 2/1;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .image-info-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .info-card-mini {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(100, 160, 180, 0.15);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .info-card-mini:hover {
        background: rgba(100, 160, 180, 0.1);
        border-color: rgba(100, 160, 180, 0.3);
        transform: translateY(-3px);
    }

    .info-card-mini .icon {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-card-mini.stock .icon {
        color: #5cb85c;
    }

    .info-card-mini.rating .icon {
        color: #f0ad4e;
    }

    .info-card-mini.sales .icon {
        color: #64a0b4;
    }

    .info-card-mini .label {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-card-mini .value {
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
    }

    .product-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .price-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(100, 160, 180, 0.2);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .price-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .product-price {
        color: #5cb85c;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(92, 184, 92, 0.3);
    }

    .price-idr {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
    }

    .rating-section {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem;
        background: rgba(240, 173, 78, 0.1);
        border-radius: 10px;
        border: 1px solid rgba(240, 173, 78, 0.2);
    }

    .rating-stars {
        display: flex;
        gap: 0.2rem;
        font-size: 0.9rem;
    }

    .rating-stars i {
        color: #f0ad4e;
    }

    .rating-info {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.6rem 1rem;
        background: rgba(92, 184, 92, 0.15);
        border-radius: 10px;
        color: #5cb85c;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid rgba(92, 184, 92, 0.2);
    }

    .seller-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(100, 160, 180, 0.15);
        border-radius: 14px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .seller-card:hover {
        background: rgba(100, 160, 180, 0.1);
        border-color: rgba(100, 160, 180, 0.3);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .seller-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .seller-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .seller-info {
        flex: 1;
    }

    .seller-label {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.2rem;
    }

    .seller-name {
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .seller-verified {
        color: #5cb85c;
        font-size: 0.9rem;
    }

    .seller-stats {
        display: flex;
        gap: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .seller-stat {
        flex: 1;
        text-align: center;
    }

    .seller-stat-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #64a0b4;
        display: block;
    }

    .seller-stat-label {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        display: block;
    }

    .product-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-buy-now {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        border: none;
        padding: 0.9rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
        text-align: center;
        text-decoration: none;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-buy-now:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(100, 160, 180, 0.4);
        color: white;
    }

    .btn-secondary-action {
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: block;
        font-size: 0.85rem;
    }

    .btn-secondary-action:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-2px);
    }

    .product-meta-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        padding: 1.25rem;
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.15);
    }

    .meta-title {
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(100, 160, 180, 0.3);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .meta-title i {
        color: #64a0b4;
    }

    .meta-row {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .meta-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .meta-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }

    .meta-value {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
        font-size: 0.8rem;
        text-align: right;
    }

    .description-section {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .section-title {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 28px;
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        border-radius: 2px;
    }

    .description-text {
        color: rgba(255, 255, 255, 0.75);
        font-size: 1rem;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list-item {
        padding: 1rem 1.25rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(100, 160, 180, 0.1);
    }

    .info-list-item:hover {
        background: rgba(100, 160, 180, 0.1);
        transform: translateX(5px);
        border-color: rgba(100, 160, 180, 0.2);
    }

    .info-list-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: rgba(255, 255, 255, 0.6);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: #64a0b4;
        width: 20px;
        text-align: center;
    }

    .info-value {
        color: #ffffff;
        font-weight: 600;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.85rem 1.75rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(-5px);
    }

    @media (max-width: 992px) {
        .product-main-section {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .product-hero {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.35rem;
        }

        .product-price {
            font-size: 1.5rem;
        }

        .main-product-image {
            aspect-ratio: 16/9;
        }
    }

    @media (max-width: 768px) {
        .product-detail-container {
            padding: 1rem 0;
        }

        .product-hero {
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .product-title {
            font-size: 1.25rem;
        }

        .image-info-cards {
            gap: 0.5rem;
        }

        .info-card-mini {
            padding: 0.75rem;
        }

        .description-section {
            padding: 1.5rem;
        }
    }
</style>

<div class="product-detail-container">
    <div class="container">
        <!-- Hero Header -->
        <div class="product-hero">
            <h1 class="product-title">{{ $product->name }}</h1>
            <p class="product-subtitle">
                <span class="badge">{{ $product->game_name }}</span>
                <span>{{ $product->game_type }}</span>
            </p>
        </div>

        <!-- Main Section -->
        <div class="product-main-section">
            <!-- Product Image -->
            <div>
                <div class="product-image-wrapper">
                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="main-product-image">
                </div>

                <!-- Info Cards Below Image -->
                <div class="image-info-cards">
                    <div class="info-card-mini stock">
                        <i class="fas fa-box icon"></i>
                        <div class="label">Stock</div>
                        <div class="value">{{ $product->stock }}</div>
                    </div>
                    <div class="info-card-mini rating">
                        <i class="fas fa-star icon"></i>
                        <div class="label">Rating</div>
                        <div class="value">{{ number_format($product->ratings_avg_rating ?? 0, 1) }}</div>
                    </div>
                    <div class="info-card-mini sales">
                        <i class="fas fa-fire icon"></i>
                        <div class="label">Sold</div>
                        <div class="value">{{ $product->total_sold ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="product-sidebar">
                <!-- Price Card -->
                <div class="price-card">
                    <div class="price-label">Harga</div>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="price-idr">${{ number_format($product->price / 15000, 2) }} USD</div>
                </div>

                <!-- Rating -->
                <div class="rating-section">
                    <div class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($product->averageRating()))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $product->averageRating())
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="rating-info">
                        <strong>{{ number_format($product->averageRating(), 1) }}</strong>
                        ({{ $product->totalRatings() }} reviews)
                    </div>
                </div>

                <!-- Stock Badge -->
                <div>
                    <span class="stock-badge">
                        <i class="fas fa-check-circle"></i>
                        {{ $product->quantity }} In Stock
                    </span>
                </div>

                <!-- Seller Profile -->
                <a href="{{ route('seller.profile', ['sellerId' => $product->seller_id ?? 1]) }}" class="seller-card">
                    <div class="seller-header">
                        <div class="seller-avatar">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="seller-info">
                            <div class="seller-label">Seller</div>
                            <div class="seller-name">
                                {{ $product->seller_name ?? 'GameHub Official' }}
                                <i class="fas fa-check-circle seller-verified" title="Verified Seller"></i>
                            </div>
                        </div>
                    </div>
                    <div class="seller-stats">
                        <div class="seller-stat">
                            <span class="seller-stat-value">98%</span>
                            <span class="seller-stat-label">Rating</span>
                        </div>
                        <div class="seller-stat">
                            <span class="seller-stat-value">1.2k</span>
                            <span class="seller-stat-label">Products</span>
                        </div>
                    </div>
                </a>

                <!-- Actions -->
                @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">

                        <div class="product-actions">
                            <button type="submit" class="btn-buy-now">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                            <a href="{{ route('home') }}" class="btn-secondary-action">
                                <i class="fas fa-heart me-2"></i>Add to Wishlist
                            </a>
                        </div>
                    </form>
                @else
                    <div class="product-actions">
                        <a href="{{ route('login') }}" class="btn-buy-now">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Purchase
                        </a>
                    </div>
                @endauth

                <!-- Product Meta -->
                <div class="product-meta-card">
                    <h3 class="meta-title"><i class="fas fa-info-circle"></i> Product Information</h3>
                    <div class="meta-row">
                        <span class="meta-label">Game</span>
                        <span class="meta-value">{{ $product->game_name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Type</span>
                        <span class="meta-value">{{ $product->game_type }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Seller</span>
                        <span class="meta-value">{{ $product->seller_name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Total Sales</span>
                        <span class="meta-value">{{ number_format($product->sales_count) }} sold</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="description-section">
            <h2 class="section-title">About This Product</h2>
            <p class="description-text">
                {{ $product->description ?? $product->name . ' adalah paket ' . $product->game_type . ' untuk ' . $product->game_name . '. Dapatkan dengan harga terbaik dan proses yang cepat. Top up mudah, aman, dan terpercaya untuk kebutuhan gaming Anda.' }}
            </p>

            <h3 class="section-title">Product Details</h3>
            <ul class="info-list">
                <li class="info-list-item">
                    <span class="info-label">
                        <i class="fas fa-gamepad"></i>Game
                    </span>
                    <span class="info-value">{{ $product->game_name }}</span>
                </li>
                <li class="info-list-item">
                    <span class="info-label">
                        <i class="fas fa-tag"></i>Category
                    </span>
                    <span class="info-value">{{ $product->game_type }}</span>
                </li>
                <li class="info-list-item">
                    <span class="info-label">
                        <i class="fas fa-boxes"></i>Stock Available
                    </span>
                    <span class="info-value">{{ $product->quantity }} units</span>
                </li>
                <li class="info-list-item">
                    <span class="info-label">
                        <i class="fas fa-shopping-bag"></i>Total Purchases
                    </span>
                    <span class="info-value">{{ number_format($product->sales_count) }} transactions</span>
                </li>
                <li class="info-list-item">
                    <span class="info-label">
                        <i class="fas fa-calendar-alt"></i>Listed Date
                    </span>
                    <span class="info-value">{{ $product->created_at->format('F d, Y') }}</span>
                </li>
            </ul>
        </div>

        <!-- Back Button -->
        <div class="mt-4 mb-4">
            <a href="{{ route('home') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Products
            </a>
        </div>
    </div>
</div>
@endsection
