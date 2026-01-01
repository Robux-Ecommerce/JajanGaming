@extends('layouts.app')

@section('title', 'JajanGaming - Top Up Robux Roblox')

@section('content')
    <!-- Hero Section - Roblox Gaming Style -->
    <div class="hero-wrapper">
        <!-- Floating Particles -->
        <div class="hero-particles">
            <span class="particle particle-1">💎</span>
            <span class="particle particle-2">🎮</span>
            <span class="particle particle-3">⭐</span>
            <span class="particle particle-4">🎯</span>
            <span class="particle particle-5">🔥</span>
            <span class="particle particle-6">💰</span>
        </div>

        <!-- Hero Slider Card (Left) -->
        <div class="hero-slider-card">
            <div class="hero-slider">
                <div class="hero-slide active"></div>
                <div class="hero-slide"></div>
                <div class="hero-slide"></div>
                <div class="hero-slide"></div>
                <div class="hero-slide"></div>
                <div class="hero-slide"></div>
            </div>

            <!-- Dark Overlay for text contrast -->
            <div class="dark-overlay"></div>

            <!-- Hero Content -->
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="badge-icon">💎</span>
                    <span class="badge-text">ROBUX MARKETPLACE #1</span>
                </div>

                <h1 class="hero-title" id="heroTitle">
                    Top Up <span class="highlight-text">Robux</span> Murah & Cepat!
                </h1>

                <p class="hero-description" id="heroDescription">
                    🎮 Temukan reseller terpercaya dengan harga terbaik. Transaksi aman, proses cepat, dan rating pengguna
                    nyata!
                </p>

                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fas fa-bolt"></i>
                        <span>Proses Instan</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>100% Aman</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-star"></i>
                        <span>Terpercaya</span>
                    </div>
                </div>

                <div class="hero-buttons mt-4">
                    <a href="#products" class="btn btn-hero-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Beli Robux
                    </a>
                    <a href="{{ route('browse') }}" class="btn btn-hero-secondary">
                        <i class="fas fa-search me-2"></i>Cari Reseller
                    </a>
                </div>
            </div>
        </div>

        <!-- Thumbnail List Card (Right) -->
        <div class="hero-thumbnails-list">
            <div class="hero-thumb-item active" onclick="goToHeroSlide(0)">
                <img src="{{ asset('img/rbg1.jpg') }}" alt="Slide 1">
                <span class="thumb-title">Robux Murah</span>
            </div>
            <div class="hero-thumb-item" onclick="goToHeroSlide(1)">
                <img src="{{ asset('img/rbg2.jpg') }}" alt="Slide 2">
                <span class="thumb-title">Flash Sale</span>
            </div>
            <div class="hero-thumb-item" onclick="goToHeroSlide(2)">
                <img src="{{ asset('img/rbg3.jpg') }}" alt="Slide 3">
                <span class="thumb-title">Reseller Top</span>
            </div>
            <div class="hero-thumb-item" onclick="goToHeroSlide(3)">
                <img src="{{ asset('img/rbg4.jpg') }}" alt="Slide 4">
                <span class="thumb-title">Promo Spesial</span>
            </div>
            <div class="hero-thumb-item" onclick="goToHeroSlide(4)">
                <img src="{{ asset('img/rbg5.jpg') }}" alt="Slide 5">
                <span class="thumb-title">Best Seller</span>
            </div>
            <div class="hero-thumb-item" onclick="goToHeroSlide(5)">
                <img src="{{ asset('img/rbg6.jpg') }}" alt="Slide 6">
                <span class="thumb-title">Terpercaya</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section - Calculator & Search -->
    <div class="quick-actions-section">
        <div class="quick-actions-section">
            <div class="container">
                <div class="row g-4">
                    <!-- Kalkulator Column -->
                    <div class="col-lg-6">
                        <div class="robux-calculator-card">
                            <h3 class="calculator-title">
                                <i class="fas fa-coins me-2"></i>Robux Price Estimator
                            </h3>
                            <p class="calculator-subtitle">Estimasi harga sebelum membeli Robux</p>

                            <div class="calculator-input-group">
                                <label for="robuxAmount" class="calculator-label">Masukkan jumlah Robux:</label>
                                <input type="number" id="robuxAmount" class="calculator-input" placeholder="Contoh: 1000"
                                    min="1" oninput="calculateRobuxPrice()">
                            </div>

                            <div class="calculator-result" id="calculatorResult" style="display: none;">
                                <div class="result-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                                <div class="result-text">
                                    <span class="result-label">Perkiraan harga termurah:</span>
                                    <span class="result-price" id="estimatedPrice">Rp 0</span>
                                </div>
                            </div>

                            <a href="#products" class="btn btn-calculator-search">
                                <i class="fas fa-search me-2"></i>Cari Reseller Termurah
                            </a>
                        </div>
                    </div>

                    <!-- Search Filter Column -->
                    <div class="col-lg-6">
                        <div class="search-filter-card">
                            <h3 class="filter-title">
                                <i class="fas fa-search me-2"></i>Cari Paket Robux
                            </h3>
                            <p class="filter-subtitle">Temukan paket terbaik untuk kebutuhan Anda</p>

                            <form method="GET" action="{{ route('home') }}" class="search-filter-form">
                                <div class="search-input-wrapper mb-3">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Cari paket Robux..." value="{{ request('search') }}">
                                </div>

                                <div class="category-select-wrapper mb-3">
                                    <select class="form-select" name="category">
                                        <option value="">🏷️ Semua Kategori</option>
                                        <option value="popular" {{ request('category') == 'popular' ? 'selected' : '' }}>
                                            🔥 Game Popular
                                        </option>
                                        <option value="top_seller"
                                            {{ request('category') == 'top_seller' ? 'selected' : '' }}>
                                            👑 Penjual Terbanyak
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-search-filter">
                                    <i class="fas fa-search me-2"></i>Cari Sekarang
                                </button>
                            </form>

                            @auth
                                <div class="wallet-info mt-3">
                                    <i class="fas fa-wallet me-2"></i>
                                    <span>Saldo: <strong>Rp
                                            {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}</strong></span>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="container">
            <!-- Products results start here -->
        </div>

        <!-- Top Selling Products Section -->
        <div class="container mt-5 mb-5">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h2 class="mb-0">
                        <i class="fas fa-fire me-2"></i>Paket Robux Terlaris
                        <i class="fas fa-chevron-right ms-2"></i>
                    </h2>
                </div>
            </div>

            <div class="upcoming-games-wrapper position-relative">
                <button class="upcoming-nav upcoming-nav-prev" onclick="scrollUpcomingGames(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="upcoming-games-container">
                    @forelse($topSellingProducts as $index => $topProduct)
                        <div class="upcoming-game-card">
                            <div class="upcoming-game-image">
                                @php
                                    $topImageUrl = file_exists(public_path('storage/' . $topProduct->image)) ? asset('storage/' . $topProduct->image) : asset('img/' . $topProduct->image);
                                @endphp
                                <img src="{{ $topImageUrl }}" alt="{{ $topProduct->name }}">
                                <button class="favorite-btn" onclick="toggleFavorite(this, {{ $topProduct->id }})">
                                    <i class="far fa-heart"></i>
                                </button>
                                @if ($index === 0)
                                    <div class="best-seller-badge">
                                        <i class="fas fa-crown"></i> #1 Best Seller
                                    </div>
                                @endif
                            </div>
                            <div class="upcoming-game-info">
                                <h5 class="upcoming-game-title">{{ $topProduct->name }}</h5>
                                <p class="upcoming-game-description">{{ Str::limit($topProduct->description, 60) }}</p>

                                <!-- Seller Info -->
                                <div class="mb-2" style="position: relative; z-index: 5;">
                                    @if ($topProduct->seller && $topProduct->seller->id)
                                        <a href="{{ route('seller.profile', $topProduct->seller->id) }}"
                                            class="d-flex align-items-center text-decoration-none seller-link-upcoming"
                                            style="position: relative; z-index: 10;"
                                            title="View {{ $topProduct->seller_name }}'s profile">
                                            <div class="seller-avatar me-2">
                                                @if ($topProduct->seller->profile_photo)
                                                    <img src="{{ asset('storage/' . $topProduct->seller->profile_photo) }}"
                                                        alt="{{ $topProduct->seller_name }}" class="rounded-circle"
                                                        style="width: 28px; height: 28px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle"
                                                        style="width: 28px; height: 28px;">
                                                        <i class="fas fa-user fa-xs text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Seller:</small>
                                                <span class="fw-medium text-white" style="font-size: 0.85rem;">
                                                    {{ $topProduct->seller_name }}
                                                    <i class="fas fa-external-link-alt ms-1"
                                                        style="font-size: 0.6rem;"></i>
                                                </span>
                                            </div>
                                        </a>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <div class="seller-avatar me-2">
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 28px; height: 28px;">
                                                    <i class="fas fa-user fa-xs text-muted"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.75rem;">Seller:</small>
                                                <span class="fw-medium text-white"
                                                    style="font-size: 0.85rem;">{{ $topProduct->seller_name }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="rating me-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($topProduct->averageRating()))
                                                    <i class="fas fa-star text-warning"></i>
                                                @elseif($i - 0.5 <= $topProduct->averageRating())
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small
                                            class="text-muted">{{ number_format($topProduct->averageRating(), 1) }}</small>
                                    </div>
                                    <small class="text-success">
                                        <i
                                            class="fas fa-shopping-cart me-1"></i>{{ number_format($topProduct->sales_count) }}
                                        terjual
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="upcoming-game-price">Rp
                                        {{ number_format($topProduct->price, 0, ',', '.') }}</span>
                                    <a href="{{ route('products.show', $topProduct) }}" class="btn btn-upcoming">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">Belum ada produk terlaris</p>
                        </div>
                    @endforelse
                </div>

                <button class="upcoming-nav upcoming-nav-next" onclick="scrollUpcomingGames(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Products Section -->
        <div class="container" id="products">
            <div class="row">
                <div class="col-12 mb-4">
                    <h2 class="text-center mb-4">
                        <i class="fas fa-gamepad me-2"></i>Paket Robux Tersedia
                    </h2>
                </div>
            </div>

            <div class="row">
                @forelse($products as $product)
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="card-landscape h-100"
                            onclick="window.location='{{ route('products.show', $product) }}'">
                            <div class="card-landscape-image">
                                @php
                                    $imageUrl = $product->image_url ?? (file_exists(public_path('storage/' . $product->image)) ? asset('storage/' . $product->image) : asset('img/' . $product->image));
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                <button class="favorite-btn-landscape"
                                    onclick="event.stopPropagation(); toggleFavorite(this, {{ $product->id }})">
                                    <i class="far fa-heart"></i>
                                </button>
                                @if (request('category') == 'top_seller' || $product->sales_count > 100)
                                    <div class="discount-badge-landscape">
                                        -55%
                                    </div>
                                @endif
                            </div>

                            <div class="card-landscape-content">
                                <h5 class="card-landscape-title">{{ $product->name }}</h5>

                                <p class="card-landscape-description">{{ Str::limit($product->description, 60) }}</p>

                                <div class="d-flex align-items-center gap-1 mb-2">
                                    @if ($product->sales_count > 50)
                                        <span class="badge bg-success"
                                            style="font-size: 0.7rem; padding: 0.3rem 0.55rem;">
                                            <i class="fas fa-crown me-1"></i>Top Seller
                                        </span>
                                    @endif
                                    <span class="badge bg-primary"
                                        style="font-size: 0.7rem; padding: 0.3rem 0.55rem;">{{ $product->game_type }}</span>
                                </div>

                                <!-- Seller Info -->
                                <div class="mb-2" style="position: relative; z-index: 5;">
                                    @if ($product->seller && $product->seller->id)
                                        <a href="{{ route('seller.profile', $product->seller->id) }}"
                                            class="d-flex align-items-center text-decoration-none seller-link-landscape"
                                            style="position: relative; z-index: 10;"
                                            title="View {{ $product->seller_name }}'s profile">
                                            <div class="seller-avatar me-2">
                                                @if ($product->seller->profile_photo)
                                                    <img src="{{ asset('storage/' . $product->seller->profile_photo) }}"
                                                        alt="{{ $product->seller_name }}" class="rounded-circle"
                                                        style="width: 20px; height: 20px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle"
                                                        style="width: 20px; height: 20px;">
                                                        <i class="fas fa-user fa-xs text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.65rem; line-height: 1;">Seller:</small>
                                                <span class="text-white" style="font-size: 0.75rem; line-height: 1.2;">
                                                    {{ $product->seller_name }}
                                                    <i class="fas fa-external-link-alt ms-1"
                                                        style="font-size: 0.55rem;"></i>
                                                </span>
                                            </div>
                                        </a>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <div class="seller-avatar me-2">
                                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 20px; height: 20px;">
                                                    <i class="fas fa-user fa-xs text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block"
                                                    style="font-size: 0.65rem; line-height: 1;">Seller:</small>
                                                <span class="text-white"
                                                    style="font-size: 0.8rem; line-height: 1.2;">{{ $product->seller_name }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Rating and Sales -->
                                <div class="d-flex justify-content-between align-items-center"
                                    style="margin-bottom: 0.5rem;">
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="rating" style="font-size: 0.75rem;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($product->averageRating()))
                                                    <i class="fas fa-star text-warning"></i>
                                                @elseif($i - 0.5 <= $product->averageRating())
                                                    <i class="fas fa-star-half-alt text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted"
                                            style="font-size: 0.7rem; font-weight: 500;">{{ number_format($product->averageRating(), 1) }}</small>
                                    </div>
                                    <small class="text-success" style="font-size: 0.7rem; font-weight: 500;">
                                        <i class="fas fa-shopping-cart me-1"
                                            style="font-size: 0.65rem;"></i>{{ number_format($product->sales_count) }}
                                        terjual
                                    </small>
                                </div>

                                <div class="card-landscape-footer">
                                    <div class="d-flex flex-column">
                                        @if (request('category') == 'top_seller' || $product->sales_count > 100)
                                            <span class="original-price-landscape">Rp
                                                {{ number_format($product->price * 2.22, 0, ',', '.') }}</span>
                                        @endif
                                        <span class="current-price-landscape">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                    <button class="btn-add-to-cart-landscape"
                                        onclick="event.stopPropagation(); addToCartLandscape({{ $product->id }})">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3>Paket Robux tidak ditemukan</h3>
                            <p class="text-muted">Coba ubah kriteria pencarian Anda</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="pagination-info mb-3">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                        results
                    </div>
                    {{ $products->links('pagination.bootstrap-5') }}
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>Mengapa Memilih JajanGaming?</h2>
                    <p class="text-muted">Platform terpercaya untuk top up Robux Roblox</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">100% Aman</h5>
                            <p class="card-text">Transaksi aman dengan enkripsi SSL dan sistem keamanan terbaik.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-bolt fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Proses Cepat</h5>
                            <p class="card-text">Robux langsung masuk ke akun Roblox Anda dalam hitungan menit.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-headset fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Support 24/7</h5>
                            <p class="card-text">Tim support siap membantu Anda kapan saja, setiap hari.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Sellers Section -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2>Top Sellers</h2>
                    <p class="text-muted">Penjual terpercaya dengan produk berkualitas</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('sellers.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-store me-2"></i>Lihat Semua Sellers
                    </a>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Prevent card click when clicking seller link
                document.querySelectorAll('.seller-link').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.stopPropagation();
                        // Add visual feedback
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    });
                });

                // Prevent card click when clicking add to cart button
                document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();
                        // Add visual feedback
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    });
                });

                // Prevent card click when clicking quantity input
                document.querySelectorAll('input[type="number"]').forEach(function(input) {
                    input.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                });

                // Prevent card click when clicking quantity selector
                document.querySelectorAll('.quantity-selector').forEach(function(selector) {
                    selector.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                });
            });

            // Initialize hero slider - SIMPLE AND DIRECT
            console.log('HOME: Starting hero slider initialization...');

            if (document.readyState === 'loading') {
                // DOM not ready yet
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('HOME: DOM ready, calling initHeroSlider');
                    if (window.initHeroSlider) {
                        window.initHeroSlider();
                    }
                });
            } else {
                // DOM already ready
                console.log('HOME: DOM already ready, calling initHeroSlider');
                if (window.initHeroSlider) {
                    window.initHeroSlider();
                } else {
                    // Function not loaded yet, wait a bit
                    setTimeout(function() {
                        console.log('HOME: Retry calling initHeroSlider');
                        if (window.initHeroSlider) {
                            window.initHeroSlider();
                        }
                    }, 100);
                }
            }


            // Quantity control functions
            function increaseQuantity(productId) {
                const input = document.getElementById(`quantity-${productId}`);
                const currentValue = parseInt(input.value) || 1;
                input.value = currentValue + 1;

                // Add visual feedback
                const btn = event.target.closest('.quantity-btn');
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    btn.style.transform = '';
                }, 150);
            }

            function decreaseQuantity(productId) {
                const input = document.getElementById(`quantity-${productId}`);
                const currentValue = parseInt(input.value) || 1;
                const minValue = parseInt(input.min) || 1;

                if (currentValue > minValue) {
                    input.value = currentValue - 1;

                    // Add visual feedback
                    const btn = event.target.closest('.quantity-btn');
                    btn.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        btn.style.transform = '';
                    }, 150);
                }
            }

            // Robux Calculator Function
            function calculateRobuxPrice() {
                const robuxAmount = document.getElementById('robuxAmount').value;
                const resultDiv = document.getElementById('calculatorResult');
                const priceSpan = document.getElementById('estimatedPrice');

                if (!robuxAmount || robuxAmount <= 0) {
                    resultDiv.style.display = 'none';
                    return;
                }

                // Asumsi harga: Rp 35 per 400 Robux (sesuai data produk Anda)
                // Jadi 1 Robux ≈ Rp 87.5
                const pricePerRobux = 87.5;
                const estimatedPrice = Math.ceil(robuxAmount * pricePerRobux);

                // Format harga dengan separator ribuan
                const formattedPrice = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(estimatedPrice);

                priceSpan.textContent = formattedPrice;
                resultDiv.style.display = 'flex';

                // Add animation
                resultDiv.style.animation = 'none';
                setTimeout(() => {
                    resultDiv.style.animation = 'fadeInUp 0.5s ease-out';
                }, 10);
            }

            // Add fadeInUp animation
            const style = document.createElement('style');
            style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
            document.head.appendChild(style);
        </script>
