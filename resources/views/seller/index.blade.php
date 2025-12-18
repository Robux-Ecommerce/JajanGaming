@extends('layouts.app')

@section('title', 'Top Sellers - JajanGaming')

@section('content')
<style>
    .sellers-page {
        background: linear-gradient(180deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .sellers-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .page-title i {
        color: #64a0b4;
        font-size: 2rem;
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Stats Bar */
    .stats-bar {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #64a0b4;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 0.5rem;
    }

    /* Sellers Grid */
    .sellers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    /* Seller Card */
    .seller-card {
        background: linear-gradient(145deg, rgba(26, 42, 56, 0.8), rgba(37, 53, 69, 0.8));
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        overflow: hidden;
        transition: all 0.4s ease;
        cursor: pointer;
        position: relative;
    }

    .seller-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(100, 160, 180, 0.25);
        border-color: rgba(100, 160, 180, 0.4);
    }

    /* Top 3 Badge */
    .rank-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        z-index: 10;
    }

    .rank-badge.gold {
        background: linear-gradient(135deg, #ffd700, #ffaa00);
        color: #1a1a1a;
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
    }

    .rank-badge.silver {
        background: linear-gradient(135deg, #c0c0c0, #a0a0a0);
        color: #1a1a1a;
        box-shadow: 0 4px 15px rgba(192, 192, 192, 0.4);
    }

    .rank-badge.bronze {
        background: linear-gradient(135deg, #cd7f32, #b87333);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(205, 127, 50, 0.4);
    }

    /* Card Header */
    .seller-card-header {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.05));
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    }

    .seller-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        border: 3px solid rgba(100, 160, 180, 0.3);
        overflow: hidden;
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .seller-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .seller-avatar i {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .seller-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .seller-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 1rem;
        background: rgba(100, 160, 180, 0.15);
        border-radius: 20px;
        font-size: 0.75rem;
        color: #64a0b4;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .seller-badge i {
        font-size: 0.7rem;
    }

    /* Card Body */
    .seller-card-body {
        padding: 1.5rem 2rem 2rem;
    }

    /* Rating Section */
    .seller-rating {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .rating-stars {
        display: flex;
        gap: 3px;
    }

    .rating-stars i {
        color: #ffc107;
        font-size: 1rem;
    }

    .rating-stars i.empty {
        color: rgba(255, 255, 255, 0.2);
    }

    .rating-text {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .rating-text strong {
        color: #ffc107;
        font-weight: 700;
    }

    /* Stats Grid */
    .seller-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .seller-stat {
        text-align: center;
        padding: 1rem 0.5rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 12px;
    }

    .seller-stat-value {
        font-size: 1.4rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
    }

    .seller-stat-label {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.4rem;
    }

    .seller-stat.products .seller-stat-value { color: #64a0b4; }
    .seller-stat.sales .seller-stat-value { color: #4ade80; }
    .seller-stat.rating .seller-stat-value { color: #ffc107; }

    /* View Button */
    .btn-view-seller {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #64a0b4, #4a8a9e);
        border: none;
        border-radius: 12px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-view-seller:hover {
        background: linear-gradient(135deg, #7ab5c7, #5a98a8);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(100, 160, 180, 0.35);
        color: #ffffff;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        grid-column: 1 / -1;
    }

    .empty-state i {
        font-size: 4rem;
        color: rgba(100, 160, 180, 0.3);
        margin-bottom: 1.5rem;
    }

    .empty-state h4 {
        color: rgba(255, 255, 255, 0.6);
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sellers-container {
            padding: 0 1rem;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .stats-bar {
            gap: 2rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .sellers-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="sellers-page">
    <div class="sellers-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-store"></i>
                Our Top Sellers
            </h1>
            <p class="page-subtitle">
                Browse our verified sellers and find the best Roblox products from trusted resellers
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-number">{{ $sellers->count() }}</div>
                <div class="stat-label">Active Sellers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $sellers->sum('products_count') }}</div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $sellers->sum('total_sales') }}</div>
                <div class="stat-label">Products Sold</div>
            </div>
        </div>

        <!-- Sellers Grid -->
        <div class="sellers-grid">
            @forelse($sellers as $index => $seller)
            <div class="seller-card" onclick="window.location.href='{{ route('seller.profile', $seller->id) }}'">
                <!-- Rank Badge for Top 3 -->
                @if($index < 3)
                <div class="rank-badge {{ $index == 0 ? 'gold' : ($index == 1 ? 'silver' : 'bronze') }}">
                    #{{ $index + 1 }}
                </div>
                @endif

                <!-- Card Header -->
                <div class="seller-card-header">
                    <div class="seller-avatar">
                        @if($seller->profile_photo)
                            <img src="{{ asset('storage/' . $seller->profile_photo) }}" alt="{{ $seller->name }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <h3 class="seller-name">{{ $seller->name }}</h3>
                    <div class="seller-badge">
                        <i class="fas fa-check-circle"></i>
                        Verified Seller
                    </div>
                </div>

                <!-- Card Body -->
                <div class="seller-card-body">
                    <!-- Rating -->
                    <div class="seller-rating">
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($seller->average_rating))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $seller->average_rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="fas fa-star empty"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-text">
                            <strong>{{ number_format($seller->average_rating, 1) }}</strong> 
                            ({{ $seller->total_ratings }} reviews)
                        </span>
                    </div>

                    <!-- Stats -->
                    <div class="seller-stats">
                        <div class="seller-stat products">
                            <div class="seller-stat-value">{{ $seller->products_count }}</div>
                            <div class="seller-stat-label">Products</div>
                        </div>
                        <div class="seller-stat sales">
                            <div class="seller-stat-value">{{ $seller->total_sales }}</div>
                            <div class="seller-stat-label">Sold</div>
                        </div>
                        <div class="seller-stat rating">
                            <div class="seller-stat-value">{{ number_format($seller->average_rating, 1) }}</div>
                            <div class="seller-stat-label">Rating</div>
                        </div>
                    </div>

                    <!-- View Button -->
                    <a href="{{ route('seller.profile', $seller->id) }}" class="btn-view-seller">
                        <i class="fas fa-eye"></i>
                        View Products
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-store-slash"></i>
                <h4>No Sellers Available</h4>
                <p>There are no sellers registered yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
