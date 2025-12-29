<?php $__env->startSection('title', 'Browse Games - JajanGaming'); ?>

<?php $__env->startSection('content'); ?>
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
                            Filters (<?php echo e($products->total()); ?>)
                            <?php if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'game_type'])): ?>
                                <button class="btn-reset-filter" onclick="window.location='<?php echo e(route('browse')); ?>'">
                                    reset
                                </button>
                            <?php endif; ?>
                        </h5>
                    </div>

                    <!-- Search Keywords -->
                    <div class="filter-section mb-4">
                        <form method="GET" action="<?php echo e(route('browse')); ?>" id="searchForm">
                            <div class="search-filter-box">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" class="form-control-filter" placeholder="Keywords"
                                    value="<?php echo e(request('search')); ?>"
                                    onchange="document.getElementById('searchForm').submit()">
                            </div>

                            <!-- Hidden inputs to preserve other filters -->
                            <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                            <input type="hidden" name="min_price" value="<?php echo e(request('min_price')); ?>">
                            <input type="hidden" name="max_price" value="<?php echo e(request('max_price')); ?>">
                            <input type="hidden" name="game_type" value="<?php echo e(request('game_type')); ?>">
                            <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
                        </form>
                    </div>

                    <!-- Sort By -->
                    <div class="filter-section mb-4">
                        <div class="filter-header" onclick="toggleFilter('sortFilter')">
                            <h6>Sort by</h6>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="filter-content" id="sortFilter">
                            <form method="GET" action="<?php echo e(route('browse')); ?>" id="sortForm">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                                <input type="hidden" name="min_price" value="<?php echo e(request('min_price')); ?>">
                                <input type="hidden" name="max_price" value="<?php echo e(request('max_price')); ?>">
                                <input type="hidden" name="game_type" value="<?php echo e(request('game_type')); ?>">

                                <label class="filter-option">
                                    <input type="radio" name="sort" value="newest"
                                        <?php echo e(request('sort', 'newest') == 'newest' ? 'checked' : ''); ?>

                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Newest</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="sort" value="popular"
                                        <?php echo e(request('sort') == 'popular' ? 'checked' : ''); ?>

                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Most Popular</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="sort" value="price_low"
                                        <?php echo e(request('sort') == 'price_low' ? 'checked' : ''); ?>

                                        onchange="document.getElementById('sortForm').submit()">
                                    <span>Price: Low to High</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="sort" value="price_high"
                                        <?php echo e(request('sort') == 'price_high' ? 'checked' : ''); ?>

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
                            <form method="GET" action="<?php echo e(route('browse')); ?>" id="categoryForm">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <input type="hidden" name="min_price" value="<?php echo e(request('min_price')); ?>">
                                <input type="hidden" name="max_price" value="<?php echo e(request('max_price')); ?>">
                                <input type="hidden" name="game_type" value="<?php echo e(request('game_type')); ?>">
                                <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">

                                <label class="filter-option">
                                    <input type="radio" name="category" value=""
                                        <?php echo e(!request('category') ? 'checked' : ''); ?>

                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>All Games</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="category" value="popular"
                                        <?php echo e(request('category') == 'popular' ? 'checked' : ''); ?>

                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>Popular</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="category" value="top_seller"
                                        <?php echo e(request('category') == 'top_seller' ? 'checked' : ''); ?>

                                        onchange="document.getElementById('categoryForm').submit()">
                                    <span>Top Seller</span>
                                </label>
                                <label class="filter-option">
                                    <input type="radio" name="category" value="new_releases"
                                        <?php echo e(request('category') == 'new_releases' ? 'checked' : ''); ?>

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
                            <form method="GET" action="<?php echo e(route('browse')); ?>" id="priceForm">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                                <input type="hidden" name="game_type" value="<?php echo e(request('game_type')); ?>">
                                <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">

                                <div class="price-inputs mb-3">
                                    <input type="number" name="min_price" class="form-control-filter" placeholder="Min"
                                        value="<?php echo e(request('min_price')); ?>">
                                    <span class="mx-2">-</span>
                                    <input type="number" name="max_price" class="form-control-filter" placeholder="Max"
                                        value="<?php echo e(request('max_price')); ?>">
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
                            <form method="GET" action="<?php echo e(route('browse')); ?>" id="typeForm">
                                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                                <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                                <input type="hidden" name="min_price" value="<?php echo e(request('min_price')); ?>">
                                <input type="hidden" name="max_price" value="<?php echo e(request('max_price')); ?>">
                                <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">

                                <label class="filter-option">
                                    <input type="radio" name="game_type" value=""
                                        <?php echo e(!request('game_type') ? 'checked' : ''); ?>

                                        onchange="document.getElementById('typeForm').submit()">
                                    <span>All Types</span>
                                </label>
                                <?php $__currentLoopData = $gameTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="filter-option">
                                        <input type="radio" name="game_type" value="<?php echo e($type); ?>"
                                            <?php echo e(request('game_type') == $type ? 'checked' : ''); ?>

                                            onchange="document.getElementById('typeForm').submit()">
                                        <span><?php echo e($type); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-12 col-lg-6 mb-4">
                            <div class="card-landscape h-100"
                                onclick="window.location='<?php echo e(route('products.show', $product)); ?>'">
                                <div class="card-landscape-image">
                                    <img src="<?php echo e(asset('img/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>">
                                    <button class="favorite-btn-landscape"
                                        onclick="event.stopPropagation(); toggleFavorite(this, <?php echo e($product->id); ?>)">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <?php if($product->sales_count > 100): ?>
                                        <div class="discount-badge-landscape">
                                            -55%
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-landscape-content">
                                    <h5 class="card-landscape-title"><?php echo e($product->name); ?></h5>

                                    <p class="card-landscape-description"><?php echo e(Str::limit($product->description, 60)); ?></p>

                                    <div class="d-flex align-items-center gap-1 mb-2">
                                        <?php if($product->sales_count > 50): ?>
                                            <span class="badge bg-success"
                                                style="font-size: 0.7rem; padding: 0.3rem 0.55rem;">
                                                <i class="fas fa-crown me-1"></i>Top Seller
                                            </span>
                                        <?php endif; ?>
                                        <span class="badge bg-primary"
                                            style="font-size: 0.7rem; padding: 0.3rem 0.55rem;"><?php echo e($product->game_type); ?></span>
                                    </div>

                                    <!-- Seller Info -->
                                    <div class="mb-2" style="position: relative; z-index: 5;">
                                        <?php if($product->seller && $product->seller->id): ?>
                                            <a href="<?php echo e(route('seller.profile', $product->seller->id)); ?>"
                                                class="d-flex align-items-center text-decoration-none seller-link-landscape"
                                                style="position: relative; z-index: 10;"
                                                title="View <?php echo e($product->seller_name); ?>'s profile">
                                                <div class="seller-avatar me-2">
                                                    <?php if($product->seller->profile_photo): ?>
                                                        <img src="<?php echo e(asset('storage/' . $product->seller->profile_photo)); ?>"
                                                            alt="<?php echo e($product->seller_name); ?>" class="rounded-circle"
                                                            style="width: 20px; height: 20px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle"
                                                            style="width: 20px; height: 20px;">
                                                            <i class="fas fa-user fa-xs text-white"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block"
                                                        style="font-size: 0.65rem; line-height: 1;">Seller:</small>
                                                    <span class="text-white"
                                                        style="font-size: 0.75rem; line-height: 1.2;">
                                                        <?php echo e($product->seller_name); ?>

                                                        <i class="fas fa-external-link-alt ms-1"
                                                            style="font-size: 0.55rem;"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        <?php else: ?>
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
                                                        style="font-size: 0.8rem; line-height: 1.2;"><?php echo e($product->seller_name); ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Rating and Sales -->
                                    <div class="d-flex justify-content-between align-items-center"
                                        style="margin-bottom: 0.5rem;">
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="rating" style="font-size: 0.75rem;">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <?php if($i <= floor($product->averageRating())): ?>
                                                        <i class="fas fa-star text-warning"></i>
                                                    <?php elseif($i - 0.5 <= $product->averageRating()): ?>
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star text-warning"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <small class="text-muted"
                                                style="font-size: 0.7rem; font-weight: 500;"><?php echo e(number_format($product->averageRating(), 1)); ?></small>
                                        </div>
                                        <small class="text-success" style="font-size: 0.7rem; font-weight: 500;">
                                            <i class="fas fa-shopping-cart me-1"
                                                style="font-size: 0.65rem;"></i><?php echo e(number_format($product->sales_count)); ?>

                                            terjual
                                        </small>
                                    </div>

                                    <div class="card-landscape-footer">
                                        <div class="d-flex flex-column">
                                            <?php if($product->sales_count > 100): ?>
                                                <span class="original-price-landscape">Rp
                                                    <?php echo e(number_format($product->price * 2.22, 0, ',', '.')); ?></span>
                                            <?php endif; ?>
                                            <span class="current-price-landscape">Rp
                                                <?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                                        </div>
                                        <button class="btn-add-to-cart-landscape"
                                            onclick="event.stopPropagation(); addToCartLandscape(<?php echo e($product->id); ?>)">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h3>No products found</h3>
                                <p class="text-muted">Try adjusting your filters</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-12">
                        <?php echo e($products->appends(request()->query())->links('pagination.bootstrap-5')); ?>

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
            <?php if(auth()->guard()->check()): ?>
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo e(route('cart.add')); ?>';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '<?php echo e(csrf_token()); ?>';

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
        <?php else: ?>
            window.location.href = '<?php echo e(route('login')); ?>';
        <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/browse.blade.php ENDPATH**/ ?>