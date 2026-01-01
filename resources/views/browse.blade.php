@extends('layouts.app')

@section('title', 'Browse Games - JajanGaming')

@section('content')
    <!-- Special Events Banner -->
    <div class="container mt-4">
        <div class="special-events-section">
            <h2 class="special-events-title mb-4">
                <i class="fas fa-star me-2"></i>Special Events
            </h2>
            <div class="special-banner">
                <div class="special-banner-content">
                    <div class="special-banner-text">
                        <span class="special-banner-subtitle">Summer</span>
                        <h1 class="special-banner-title">Savings</h1>
                        <p class="special-banner-date">August 7 - August 21</p>
                        <p class="special-banner-description">
                            Enjoy the summer!<br>
                            Get big discounts on top up Robux!<br>
                            Summer sale is now live!<br>
                            Grab your favorites now - up to<br>
                            70% OFF for a limited time
                        </p>
                        <button class="btn btn-special-banner">
                            Browse Now
                        </button>
                    </div>
                    <div class="special-banner-visual">
                        <h1 class="special-visual-text">Summer</h1>
                        <h2 class="special-visual-sale">SALE</h2>
                        <div class="special-visual-discount">UP TO 70% DISCOUNT</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Browse Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="browse-sidebar">
                    <div class="filter-section mb-4">
                        <h5 class="filter-title">
                            Filters ({{ $products->total() }})
                            @if (request()->hasAny(['search', 'category', 'min_price', 'max_price', 'game_type']))
                                <button class="btn-reset-filter" onclick="window.location='{{ route('browse') }}'">
                                    reset
                                </button>
                            @endif
                        </h5>
                    </div>

                    <!-- Search Keywords -->
                    <div class="filter-section mb-4">
                        <form method="GET" action="{{ route('browse') }}" id="searchForm">
                            <div class="search-filter-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" class="form-control-filter" placeholder="Keywords"
                                    value="{{ request('search') }}"
                                    onchange="document.getElementById('searchForm').submit()">
                            </div>

                            <!-- Hidden inputs to preserve other filters -->
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            <input type="hidden" name="game_type" value="{{ request('game_type') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        </form>
                    </div>

                    <!-- Sort By -->
                    <div class="filter-section mb-4">
                        <div class="filter-header" onclick="toggleFilter('sortFilter')">
                            <h6>Sort by</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="filter-content" id="sortFilter">
                            <form method="GET" action="{{ route('browse') }}" id="sortForm">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                <input type="hidden" name="game_type" value="{{ request('game_type') }}">

                                <label class="filter-option">
                                    <input type="radio" name="sort" value="newest"
                                        {{ request('sort', 'newest') == 'newest' ? 'checked' : '' }}
                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Newest</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="sort" value="popular"
                                        {{ request('sort') == 'popular' ? 'checked' : '' }}
                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Most Popular</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="sort" value="price_low"
                                        {{ request('sort') == 'price_low' ? 'checked' : '' }}
                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Price: Low to High</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="sort" value="price_high"
                                        {{ request('sort') == 'price_high' ? 'checked' : '' }}
                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Price: High to Low</span>
                                </label>
                            </form>
                        </div>
                    </div>

                    <!-- Genres (Categories) -->
                    <div class="filter-section mb-4">
                        <div class="filter-header" onclick="toggleFilter('genresFilter')">
                            <h6>Genres</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="filter-content" id="genresFilter">
                            <form method="GET" action="{{ route('browse') }}" id="categoryForm">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                <input type="hidden" name="game_type" value="{{ request('game_type') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">

                                <label class="filter-option">
                                    <input type="radio" name="category" value=""
                                        {{ !request('category') ? 'checked' : '' }}
                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>All Games</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="category" value="popular"
                                        {{ request('category') == 'popular' ? 'checked' : '' }}
                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>Popular</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="category" value="top_seller"
                                        {{ request('category') == 'top_seller' ? 'checked' : '' }}
                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>Top Seller</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="category" value="new_releases"
                                        {{ request('category') == 'new_releases' ? 'checked' : '' }}
                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>New Releases</span>
                                </label>
                            </form>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-section mb-4">
                        <div class="filter-header" onclick="toggleFilter('priceFilter')">
                            <h6>Price</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="filter-content" id="priceFilter">
                            <form method="GET" action="{{ route('browse') }}" id="priceForm">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="game_type" value="{{ request('game_type') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">

                                <div class="price-inputs mb-3">
                                    <input type="number" name="min_price" class="form-control-filter" placeholder="Min"
                                        value="{{ request('min_price') }}">
                                    <span class="mx-2">-</span>
                                    <input type="number" name="max_price" class="form-control-filter" placeholder="Max"
                                        value="{{ request('max_price') }}">
                                </div>
                                <button type="submit" class="btn btn-filter-apply w-100">Apply</button>
                            </form>
                        </div>
                    </div>

                    <!-- Game Types -->
                    <div class="filter-section mb-4">
                        <div class="filter-header" onclick="toggleFilter('typesFilter')">
                            <h6>Types</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="filter-content" id="typesFilter">
                            <form method="GET" action="{{ route('browse') }}" id="typeForm">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">

                                <label class="filter-option">
                                    <input type="radio" name="game_type" value=""
                                        {{ !request('game_type') ? 'checked' : '' }}
                                        onchange="document.getElementById('typeForm').submit()">
                                    <span>All Types</span>
                                </label>
                                @foreach ($gameTypes as $type)
                                    <label class="filter-option">
                                        <input type="radio" name="game_type" value="{{ $type }}"
                                            {{ request('game_type') == $type ? 'checked' : '' }}
                                            onchange="document.getElementById('typeForm').submit()">
                                        <span>{{ $type }}</span>
                                    </label>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-12 col-lg-6 mb-4">
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
                                    @if ($product->sales_count > 100)
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
                                                    <span class="text-white"
                                                        style="font-size: 0.75rem; line-height: 1.2;">
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
                                            @if ($product->sales_count > 100)
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
                                <h3>No products found</h3>
                                <p class="text-muted">Try adjusting your filters</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        {{ $products->appends(request()->query())->links('pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFilter(filterId) {
            const filter = document.getElementById(filterId);
            const header = filter.previousElementSibling;
            const icon = header.querySelector('i');

            filter.classList.toggle('active');

            if (filter.classList.contains('active')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        // Toggle favorite function
        function toggleFavorite(btn, productId) {
            event.stopPropagation();
            const icon = btn.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                btn.style.color = '#ff4757';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                btn.style.color = '#ffffff';
            }
        }

        // Add to cart for landscape cards
        function addToCartLandscape(productId) {
            @auth
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('cart.add') }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = productId;

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = 1;

            form.appendChild(csrfToken);
            form.appendChild(productInput);
            form.appendChild(quantityInput);

            document.body.appendChild(form);
            form.submit();
        @else
            window.location.href = '{{ route('login') }}';
        @endauth
        }

        // Initialize - open all filters by default
        document.addEventListener('DOMContentLoaded', function() {
            const filters = ['sortFilter', 'genresFilter', 'priceFilter', 'typesFilter'];
            filters.forEach(filterId => {
                document.getElementById(filterId).classList.add('active');
                const header = document.getElementById(filterId).previousElementSibling;
                const icon = header.querySelector('i');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            });
        });
    </script>
@endsection
