@extends('layouts.app')

@section('title', 'JajanGaming - Top Up Robux Roblox')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <!-- Hero Slider -->
    <div class="hero-slider">
        <div class="hero-slide active"></div>
        <div class="hero-slide"></div>
        <div class="hero-slide"></div>
    </div>
    
    <!-- Dark Overlay for text contrast -->
    <div class="dark-overlay"></div>
    
    <!-- Navigation Arrows -->
    <button class="hero-nav hero-nav-prev" onclick="changeHeroSlide(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-nav hero-nav-next" onclick="changeHeroSlide(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Content -->
            <div class="col-lg-6 hero-content-left">
                <h1 class="hero-title">
                    <i class="fas fa-hand-wave me-2"></i>Selamat Datang di Marketplace Robux Terpercaya
                </h1>
                <p class="hero-description">
                    Kami memudahkan kamu menemukan reseller Robux yang aman, cepat, dan berharga terbaik. Semua reseller melalui proses verifikasi dan rating dari pengguna.
                </p>
                <div class="hero-stats mt-4">
                    <div class="stat-item">
                        <i class="fas fa-clock me-2"></i>
                        <span>Update harga Robux real-time</span>
                    </div>
                    <div class="stat-item mt-2">
                        <i class="fas fa-check-circle me-2"></i>
                        <span>Ribuan transaksi berhasil setiap hari</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Content -->
            <div class="col-lg-6 hero-content-right">
                <!-- Robux Calculator -->
                <div class="robux-calculator">
                    <h3 class="calculator-title">
                        <i class="fas fa-calculator me-2"></i>Kalkulator Robux
                    </h3>
                    <p class="calculator-subtitle">Hitung cepat: "Saya mau beli berapa Robux?"</p>
                    
                    <div class="calculator-input-group">
                        <label for="robuxAmount" class="calculator-label">Masukkan jumlah Robux:</label>
                        <input type="number" 
                               id="robuxAmount" 
                               class="calculator-input" 
                               placeholder="Contoh: 1000"
                               min="1"
                               oninput="calculateRobuxPrice()">
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
        </div>
    </div>
</div>

<!-- Search Section -->
<div class="container">
        <div class="search-section">
            <div class="row align-items-center">
                <div class="col-md-10">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 me-4">
                            <i class="fas fa-search me-2"></i>Cari Paket Robux
                        </h4>
                        <form method="GET" action="{{ route('home') }}" class="d-flex flex-grow-1">
                            <div class="me-2 flex-grow-1">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Cari paket Robux..." value="{{ request('search') }}">
                            </div>
                            <div class="me-2" style="min-width: 180px;">
                                <select class="form-select" name="category">
                                    <option value="">🏷️ Semua Kategori</option>
                                    <option value="popular" {{ request('category') == 'popular' ? 'selected' : '' }}>
                                        🔥 Game Popular
                                    </option>
                                    <option value="top_seller" {{ request('category') == 'top_seller' ? 'selected' : '' }}>
                                        👑 Penjual Terbanyak
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-3">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    @auth
                        <div class="wallet-balance" style="max-width: 160px;">
                            <i class="fas fa-wallet me-2"></i>
                            Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}
                        </div>
                    @endauth
                </div>
            </div>
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
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                 <div class="card h-100" style="cursor: pointer;" onclick="addToCart({{ $product->id }})">
                    <div class="product-image">
                        <img src="{{ asset('img/' . $product->image) }}" 
                             class="img-fluid" alt="{{ $product->name }}">
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <!-- Product Name -->
                        <div class="mb-2">
                            <h5 class="card-title mb-1">{{ $product->name }}</h5>
                        </div>
                        
                        <!-- Product Description -->
                        <div class="mb-2">
                            <p class="card-text text-muted small">{{ $product->description }}</p>
                        </div>
                        
                        <!-- Game Category -->
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ $product->game_type }}</span>
                            @if(request('category') == 'popular' && $product->rating >= 4.5)
                                <span class="badge bg-warning text-dark ms-1">
                                    <i class="fas fa-fire me-1"></i>Popular
                                </span>
                            @endif
                            @if(request('category') == 'top_seller')
                                <span class="badge bg-success ms-1">
                                    <i class="fas fa-crown me-1"></i>Top Seller
                                </span>
                            @endif
                        </div>
                        
                        <!-- Seller Info -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="seller-avatar me-2">
                                    @if($product->seller && $product->seller->id && $product->seller->profile_photo)
                                        <img src="{{ asset('storage/' . $product->seller->profile_photo) }}" 
                                             alt="{{ $product->seller_name }}" 
                                             class="rounded-circle" 
                                             style="width: 24px; height: 24px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" 
                                             style="width: 24px; height: 24px;">
                                            <i class="fas fa-user fa-xs text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <small class="text-muted d-block">Seller:</small>
                                    @if($product->seller && $product->seller->id)
                                        <a href="{{ route('seller.profile', $product->seller->id) }}" 
                                           class="fw-medium text-dark text-decoration-none seller-link">
                                            {{ $product->seller_name }}
                                            <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i>
                                        </a>
                                    @else
                                        <span class="fw-medium text-dark">{{ $product->seller_name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            <span class="price-display">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Rating -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rating me-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                            <i class="fas fa-star text-warning"></i>
                                        @elseif($i - 0.5 <= $product->rating)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted me-2">{{ number_format($product->averageRating(), 1) }}</small>
                                <img src="{{ asset('img/download.jpg') }}" 
                                     alt="Robux" 
                                     class="robux-icon" 
                                     style="width: 20px; height: 20px; object-fit: cover;">
                            </div>
                        </div>
                        
                        <!-- Sales Count -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shopping-cart text-success me-2"></i>
                                <small class="text-muted">Terjual:</small>
                                <small class="fw-medium text-success ms-1">{{ number_format($product->sales_count) }}</small>
                            </div>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <div class="mt-auto">
                            @auth
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="quantity-selector">
                                        <button type="button" class="quantity-btn" onclick="event.stopPropagation(); decreaseQuantity({{ $product->id }})">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" id="quantity-{{ $product->id }}" value="1" min="1" 
                                               class="quantity-input" readonly
                                               onclick="event.stopPropagation();">
                                        <button type="button" class="quantity-btn" onclick="event.stopPropagation(); increaseQuantity({{ $product->id }})">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted ms-2">Tersedia {{ $product->quantity }}</small>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-primary btn-sm w-100 add-to-cart-btn" 
                                            onclick="event.stopPropagation(); addToCart({{ $product->id }});">
                                        <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                    </button>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100" onclick="event.stopPropagation();">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Buy
                                </a>
                            @endauth
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
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
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

// Initialize hero slider for home page - OUTSIDE DOMContentLoaded
console.log('🚀 Home page script loaded');
console.log('🔍 Checking for initHeroSlider function...');

if (typeof initHeroSlider === 'function') {
    console.log('✅ initHeroSlider found, calling it now...');
    initHeroSlider();
} else {
    console.warn('❌ initHeroSlider not found!');
    
    // Try again after a short delay
    setTimeout(() => {
        if (typeof initHeroSlider === 'function') {
            console.log('✅ initHeroSlider found on retry, calling it now...');
            initHeroSlider();
        } else {
            console.error('❌ initHeroSlider still not found after delay');
        }
    }, 200);
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
