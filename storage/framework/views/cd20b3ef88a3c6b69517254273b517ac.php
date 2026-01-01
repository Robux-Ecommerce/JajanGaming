<?php $__env->startSection('title', $product->name . ' - JajanGaming'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .product-detail-container {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            padding: 1rem 0;
        }

        .product-hero {
            background: rgba(42, 42, 62, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 212, 170, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .product-title {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .product-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            margin-bottom: 0;
            line-height: 1.4;
        }

        .product-main-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .product-image-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            width: 100%;
            background:
                radial-gradient(circle at 25px 25px, rgba(0, 212, 170, 0.15) 2px, transparent 2px),
                radial-gradient(circle at 75px 75px, rgba(102, 126, 234, 0.15) 2px, transparent 2px),
                radial-gradient(circle at 125px 125px, rgba(255, 193, 7, 0.1) 2px, transparent 2px),
                linear-gradient(45deg, rgba(42, 42, 62, 0.95) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(42, 42, 62, 0.95) 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, rgba(42, 42, 62, 0.95) 75%),
                linear-gradient(-45deg, transparent 75%, rgba(42, 42, 62, 0.95) 75%);
            background-size: 50px 50px, 50px 50px, 50px 50px, 20px 20px, 20px 20px, 20px 20px, 20px 20px;
            background-position: 0 0, 25px 25px, 50px 50px, 0 0, 0 10px, 10px -10px, -10px 0px;
            backdrop-filter: blur(10px);
            box-shadow:
                inset 0 2px 15px rgba(0, 0, 0, 0.4),
                inset 0 -2px 15px rgba(255, 255, 255, 0.08),
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .product-image-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.8s ease;
            z-index: 4;
            border-radius: 16px;
        }

        .product-image-wrapper:hover::before {
            left: 100%;
        }

        .product-image-wrapper .image-decoration {
            position: absolute;
            top: 15px;
            left: 15px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.8), rgba(102, 126, 234, 0.8));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            z-index: 5;
            opacity: 0;
            transform: scale(0) rotate(-180deg);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .product-image-wrapper:hover .image-decoration {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }

        .product-image-wrapper:hover {
            border-color: rgba(0, 212, 170, 0.6);
            box-shadow:
                inset 0 2px 15px rgba(0, 0, 0, 0.4),
                inset 0 -2px 15px rgba(255, 255, 255, 0.08),
                0 15px 45px rgba(0, 212, 170, 0.3),
                0 0 0 1px rgba(0, 212, 170, 0.2);
            background:
                radial-gradient(circle at 20% 80%, rgba(0, 212, 170, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 193, 7, 0.08) 0%, transparent 50%),
                linear-gradient(135deg, rgba(42, 42, 62, 0.95) 0%, rgba(33, 37, 41, 0.95) 100%);
        }

        .main-product-image {
            width: 100%;
            height: 100%;
            min-height: 300px;
            max-height: 400px;
            object-fit: contain;
            object-position: center center;
            display: block;
            position: relative;
            z-index: 1;
            transition: all 0.4s ease;
            border-radius: 12px;
        }

        .product-image-wrapper::after {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.8), rgba(102, 126, 234, 0.8));
            border-radius: 50%;
            opacity: 0;
            transform: scale(0);
            transition: all 0.4s ease;
            z-index: 3;
        }

        .product-image-wrapper:hover::after {
            opacity: 1;
            transform: scale(1);
        }

        .product-image-wrapper::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: -2px;
            width: 15px;
            height: 15px;
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.8), rgba(0, 212, 170, 0.8));
            border-radius: 50%;
            opacity: 0;
            transform: scale(0);
            transition: all 0.4s ease 0.1s;
            z-index: 3;
        }

        .product-image-wrapper:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        .product-image-wrapper:hover .main-product-image {
            transform: scale(1.05);
            filter: brightness(1.1) contrast(1.05);
        }

        .image-info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.8rem;
            margin-top: 1rem;
            margin-bottom: 0;
        }

        .info-card-mini {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 0.65rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .info-card-mini:hover {
            background: rgba(0, 0, 0, 0.4);
            border-color: rgba(0, 212, 170, 0.3);
            transform: translateY(-2px);
        }

        .info-card-mini .icon {
            font-size: 1.15rem;
            margin-bottom: 0.35rem;
            display: block;
        }

        .info-card-mini.stock .icon {
            color: #00d4aa;
        }

        .info-card-mini.rating .icon {
            color: #ffc107;
        }

        .info-card-mini.sales .icon {
            color: #667eea;
        }

        .info-card-mini .label {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .info-card-mini .value {
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
        }

        .product-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .price-card {
            background: rgba(0, 0, 0, 0.4);
            padding: 1.2rem;
            border-radius: 10px;
            border: 1px solid rgba(0, 212, 170, 0.25);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            gap: 2rem;
        }

        .price-card-left {
            flex: 1 !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .price-card-right {
            flex: 1 !important;
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .price-card-left h4 {
            color: #ffffff;
            margin: 0.5rem 0 0 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .price-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.7rem;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-price {
            color: #00d4aa;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
            text-shadow: 0 2px 10px rgba(0, 212, 170, 0.3);
        }

        .price-idr {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .rating-stars {
            display: flex;
            gap: 0.2rem;
            font-size: 0.85rem;
        }

        .rating-stars i {
            color: #ffc107;
        }

        .rating-info {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.7rem;
            background: rgba(0, 212, 170, 0.15);
            border-radius: 8px;
            color: #00d4aa;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .seller-card {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 0.85rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .seller-card:hover {
            background: rgba(0, 0, 0, 0.4);
            border-color: rgba(0, 212, 170, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .seller-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .seller-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .seller-info {
            flex: 1;
        }

        .seller-label {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .seller-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .seller-verified {
            color: #00d4aa;
            font-size: 0.85rem;
        }

        .seller-stats {
            display: flex;
            gap: 0.6rem;
            padding-top: 0.35rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            align-items: flex-start;
        }

        .seller-stat {
            flex: 1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            padding: 0.35rem 0;
        }

        .seller-stat-value {
            font-size: 0.95rem;
            font-weight: 800;
            color: #00d4aa;
            display: block;
        }

        .seller-stat-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.75);
            display: block;
        }

        .seller-stat-value {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            justify-content: center;
        }

        .stat-icon {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.85);
        }

        .rating-icon {
            color: #ffc107;
        }

        .products-icon {
            color: #00d4aa;
        }

        .seller-stat-label i {
            margin-right: 0.35rem;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.8rem;
            vertical-align: middle;
        }

        .seller-stat i {
            color: rgba(255, 255, 255, 0.75);
        }

        .comments-section {
            background: rgba(42, 42, 62, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            max-height: min(70vh, 480px);
            overflow-y: auto;
            padding-bottom: 0.75rem;
        }

        .comment-item {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 0.6rem;
            margin-bottom: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.03);
            transition: all 0.2s ease;
        }

        .comment-item:last-child {
            margin-bottom: 0;
        }

        .comment-item:hover {
            background: rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 212, 170, 0.08);
        }

        .comment-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.35rem;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: white;
            font-weight: 700;
        }

        .comment-name {
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .comment-date {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.65rem;
            margin-left: auto;
        }

        .comment-rating {
            color: #ffc107;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }

        .comment-text {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.77rem;
            line-height: 1.45;
            margin: 0;
        }

        .view-all-comments {
            display: block;
            text-align: center;
            color: #00d4aa;
            font-size: 0.77rem;
            font-weight: 700;
            padding: 0.45rem;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-top: 0.45rem;
        }

        .view-all-comments:hover {
            background: rgba(0, 212, 170, 0.08);
            color: #00a8cc;
        }

        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-buy-now {
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            color: white;
            border: none;
            padding: 0.7rem 0.85rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.4);
            text-align: center;
            text-decoration: none;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-buy-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 170, 0.5);
            color: white;
        }

        .btn-secondary-action {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 0.75rem;
        }

        .btn-secondary-action:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .product-meta-card {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .meta-title {
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid rgba(0, 212, 170, 0.3);
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .meta-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .meta-label {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }

        .meta-value {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.75rem;
            text-align: right;
        }

        .description-section {
            background: rgba(42, 42, 62, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .product-bottom-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .comments-section-bottom {
            background: rgba(42, 42, 62, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 0.75rem;
            margin-top: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            max-height: 420px;
            overflow-y: auto;
        }

        .section-title {
            color: #ffffff;
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 32px;
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            border-radius: 2px;
        }

        .description-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list-item {
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .info-list-item:hover {
            background: rgba(0, 0, 0, 0.3);
            transform: translateX(5px);
        }

        .info-list-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
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
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
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
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .product-bottom-section {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .product-hero {
                padding: 1.25rem;
            }

            .product-title {
                font-size: 1.35rem;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .main-product-image {
                /* aspect-ratio removed for natural image display */
            }
        }

        @media (max-width: 768px) {
            .product-hero {
                padding: 1.5rem;
            }

            .product-title {
                font-size: 1.75rem;
            }

            .main-product-image {
                height: 300px;
                max-height: 300px;
            }

            .product-price {
                font-size: 1.75rem;
            }

            .product-bottom-section {
                grid-template-columns: 1fr;
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
                <h1 class="product-title"><?php echo e($product->name); ?></h1>
                <p class="product-subtitle"><?php echo e($product->game_name); ?> - <?php echo e($product->game_type); ?></p>
            </div>

            <!-- Main Section -->
            <div class="product-main-section">
                <!-- Product Image -->
                <div>
                    <div class="product-image-wrapper">
                        <div class="image-decoration">
                            <i class="fas fa-gem"></i>
                        </div>
                        <?php
                            $fallback = 'img/sellers/robux dikit 1.png';

                            // Map product name/price to specific image
                            if (
                                strpos(strtolower($product->name), '320') !== false ||
                                ($product->price >= 40000 && $product->price <= 60000)
                            ) {
                                $fallback = 'img/sellers/robux banyak 2.png';
                            } elseif (
                                strpos(strtolower($product->name), '800') !== false ||
                                ($product->price >= 90000 && $product->price <= 110000)
                            ) {
                                $fallback = 'img/sellers/robux.png';
                            } elseif (strpos(strtolower($product->name), '80') !== false || $product->price <= 20000) {
                                $fallback = 'img/sellers/robux dikit 1.png';
                            } elseif (
                                strpos(strtolower($product->name), '170') !== false ||
                                ($product->price >= 20000 && $product->price <= 35000)
                            ) {
                                $fallback = 'img/sellers/robux sedang 2.png';
                            }
                        ?>
                        <?php if($product->image && file_exists(public_path('storage/' . $product->image))): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>"
                                class="main-product-image">
                        <?php else: ?>
                            <img src="<?php echo e(asset($fallback)); ?>" alt="Random Product Image" class="main-product-image">
                        <?php endif; ?>
                    </div>

                    <!-- Info Cards Below Image -->
                    <div class="image-info-cards">
                        <div class="info-card-mini stock">
                            <i class="fas fa-box icon"></i>
                            <div class="label">Stock</div>
                            <div class="value"><?php echo e($product->stock); ?></div>
                        </div>
                        <div class="info-card-mini rating">
                            <i class="fas fa-star icon"></i>
                            <div class="label">Rating</div>
                            <div class="value"><?php echo e(number_format($product->ratings_avg_rating ?? 0, 1)); ?></div>
                        </div>
                        <div class="info-card-mini sales">
                            <i class="fas fa-fire icon"></i>
                            <div class="label">Sold</div>
                            <div class="value"><?php echo e($product->total_sold ?? 0); ?></div>
                        </div>
                    </div>

                    <!-- Comments card moved here -->
                    <div class="comments-section-bottom">
                        <div class="comments-header">
                            <i class="fas fa-comments"></i>
                            Reviews & Comments
                        </div>

                        <?php if(auth()->guard()->check()): ?>
                            <?php
                                $userHasPurchased = false;
                                if (auth()->check()) {
                                    $userHasPurchased = \App\Models\OrderItem::whereHas('order', function ($q) {
                                        $q->where('user_id', auth()->id());
                                    })
                                        ->where('product_id', $product->id)
                                        ->exists();
                                }
                            ?>
                            <?php if($userHasPurchased): ?>
                                <form action="<?php echo e(route('ratings.store')); ?>" method="POST" class="mb-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                    <div class="mb-2">
                                        <label class="text-muted" style="font-size:0.8rem;">Your rating</label>
                                        <select name="rating" class="form-select"
                                            style="width:120px; display:inline-block; margin-left:0.5rem;">
                                            <option value="">Rate</option>
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?>

                                                    star<?php echo e($i > 1 ? 's' : ''); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="review" class="form-control" rows="2" placeholder="Write your review..." style="resize:none;"></textarea>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary" type="submit">Submit Review</button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div style="margin-bottom:0.5rem; font-size:0.9rem; color:rgba(255,255,255,0.8);">You can leave
                                    a review after purchasing this product. <a href="<?php echo e(route('orders.index')); ?>"
                                        style="color:#00d4aa;">See your orders</a></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div style="margin-bottom:0.5rem; font-size:0.9rem; color:rgba(255,255,255,0.8);">Please <a
                                    href="<?php echo e(route('login')); ?>" style="color:#00d4aa;">login</a> to leave a review.</div>
                        <?php endif; ?>

                        <?php $__empty_1 = true; $__currentLoopData = $product->ratings()->latest()->take(6)->with('user')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="comment-item">
                                <div class="comment-author">
                                    <div class="comment-avatar"><?php echo e(strtoupper(substr($rating->user->name ?? 'U', 0, 1))); ?>

                                    </div>
                                    <span class="comment-name"><?php echo e($rating->user->name ?? 'Anonymous'); ?></span>
                                    <span class="comment-rating">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $rating->rating): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="comment-date"><?php echo e($rating->created_at->diffForHumans()); ?></span>
                                </div>
                                <p class="comment-text"><?php echo e($rating->review ?? 'Great product! Recommended!'); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="comment-item">
                                <div class="comment-author">
                                    <div class="comment-avatar">A</div>
                                    <span class="comment-name">Ahmad Gaming</span>
                                    <span class="comment-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="comment-date">2 days ago</span>
                                </div>
                                <p class="comment-text">Fast delivery, trusted seller! Recommended!</p>
                            </div>
                        <?php endif; ?>

                        <a href="#reviews" class="view-all-comments">
                            View All Reviews <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="product-sidebar">
                    <!-- Price Card -->
                    <div class="price-card">
                        <div class="price-card-left">
                            <div class="price-label">Product</div>
                            <h4 style="color: #ffffff; margin: 0; font-weight: 600;"><?php echo e($product->name); ?></h4>
                        </div>
                        <div class="price-card-right">
                            <div class="price-label">Harga</div>
                            <div class="product-price">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                            <div class="price-idr">$<?php echo e(number_format($product->price / 15000, 2)); ?> USD</div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="rating-section">
                        <div class="rating-stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= floor($product->averageRating())): ?>
                                    <i class="fas fa-star"></i>
                                <?php elseif($i - 0.5 <= $product->averageRating()): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="rating-info">
                            <strong><?php echo e(number_format($product->averageRating(), 1)); ?></strong>
                            (<?php echo e($product->totalRatings()); ?> reviews)
                        </div>
                    </div>

                    <!-- Stock Badge -->
                    <div>
                        <span class="stock-badge">
                            <i class="fas fa-check-circle"></i>
                            <?php echo e($product->quantity); ?> In Stock
                        </span>
                    </div>

                    <!-- Actions -->
                    <?php if(auth()->guard()->check()): ?>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">

                            <div class="product-actions">
                                <button type="submit" class="btn-buy-now">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                                <button type="button" class="btn-secondary-action" data-bs-toggle="modal" data-bs-target="#reportModal" <?php if(auth()->user()->id === $product->seller_id): ?> disabled <?php endif; ?>>
                                    <i class="fas fa-flag me-2"></i>Report Product
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="product-actions">
                            <a href="<?php echo e(route('login')); ?>" class="btn-buy-now">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Purchase
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Product Meta -->
                    <div class="product-meta-card">
                        <h3 class="meta-title">Product Information</h3>
                        <div class="meta-row">
                            <span class="meta-label">Game</span>
                            <span class="meta-value"><?php echo e($product->game_name); ?></span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Type</span>
                            <span class="meta-value"><?php echo e($product->game_type); ?></span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Seller</span>
                            <span class="meta-value"><?php echo e($product->seller_name); ?></span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Total Sales</span>
                            <span class="meta-value"><?php echo e(number_format($product->sales_count)); ?> sold</span>
                        </div>
                    </div>

                    <!-- Seller Profile -->
                    <a href="<?php echo e(route('seller.profile', ['sellerId' => $product->seller_id ?? 1])); ?>"
                        class="seller-card">
                        <div class="seller-header">
                            <div class="seller-avatar">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="seller-info">
                                <div class="seller-label">Seller</div>
                                <div class="seller-name">
                                    <?php echo e($product->seller_name ?? 'GameHub Official'); ?>

                                    <i class="fas fa-check-circle seller-verified" title="Verified Seller"></i>
                                </div>
                            </div>
                        </div>
                        <div class="seller-stats">
                            <div class="seller-stat">
                                <span class="seller-stat-value"><i
                                        class="fas fa-star stat-icon rating-icon"></i>98%</span>
                                <span class="seller-stat-label">Rating</span>
                            </div>
                            <div class="seller-stat">
                                <span class="seller-stat-value"><i
                                        class="fas fa-boxes stat-icon products-icon"></i>1.2k</span>
                                <span class="seller-stat-label">Products</span>
                            </div>
                        </div>
                    </a>

                    <!-- About (moved under seller) -->
                    <div class="product-about-card description-section">
                        <h2 class="section-title">About This Product</h2>
                        <p class="description-text">
                            <?php echo e($product->description ?? $product->name . ' adalah paket ' . $product->game_type . ' untuk ' . $product->game_name . '. Dapatkan dengan harga terbaik dan proses yang cepat. Top up mudah, aman, dan terpercaya untuk kebutuhan gaming Anda.'); ?>

                        </p>

                        <h3 class="section-title">Product Details</h3>
                        <ul class="info-list">
                            <li class="info-list-item">
                                <span class="info-label">
                                    <i class="fas fa-gamepad me-2"></i>Game
                                </span>
                                <span class="info-value"><?php echo e($product->game_name); ?></span>
                            </li>
                            <li class="info-list-item">
                                <span class="info-label">
                                    <i class="fas fa-tag me-2"></i>Category
                                </span>
                                <span class="info-value"><?php echo e($product->game_type); ?></span>
                            </li>
                            <li class="info-list-item">
                                <span class="info-label">
                                    <i class="fas fa-boxes me-2"></i>Stock Available
                                </span>
                                <span class="info-value"><?php echo e($product->quantity); ?> units</span>
                            </li>
                            <li class="info-list-item">
                                <span class="info-label">
                                    <i class="fas fa-shopping-bag me-2"></i>Total Purchases
                                </span>
                                <span class="info-value"><?php echo e(number_format($product->sales_count)); ?> transactions</span>
                            </li>
                            <li class="info-list-item">
                                <span class="info-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Listed Date
                                </span>
                                <span class="info-value"><?php echo e($product->created_at->format('F d, Y')); ?></span>
                            </li>
                        </ul>
                    </div>




                    <!-- Back Button -->
                    <div class="mt-4 mb-4">
                        <a href="<?php echo e(route('home')); ?>" class="back-button">
                            <i class="fas fa-arrow-left"></i>
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>

            <!-- Report Product Modal -->
            <?php if(auth()->guard()->check()): ?>
                <div class="modal fade" id="reportModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content" style="background: linear-gradient(135deg, #1a2a38 0%, #243645 100%); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0;">
                            <div class="modal-header" style="border-bottom: 1px solid rgba(100, 160, 180, 0.2);">
                                <h5 class="modal-title" style="color: #ffffff; font-weight: 700;">
                                    <i class="fas fa-flag me-2" style="color: #e8b056;"></i>Laporkan Produk Ini
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(1.5);"></button>
                            </div>

                            <form action="<?php echo e(route('product.report', $product)); ?>" method="POST" id="reportForm">
                                <?php echo csrf_field(); ?>

                                <div class="modal-body">
                                    <p style="color: #a0b5c5; margin-bottom: 1.5rem;">Laporan anda akan membantu kami menjaga kualitas platform. Silakan jelaskan masalah anda secara detail.</p>

                                    <div class="mb-3">
                                        <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Alasan Laporan *</label>
                                        <select name="reason" class="form-select" required style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(100, 160, 180, 0.3); color: #e0e0e0; border-radius: 8px; padding: 0.75rem;">
                                            <option value="">-- Pilih Alasan --</option>
                                            <option value="poor_quality">Kualitas Produk Buruk</option>
                                            <option value="fake_product">Produk Palsu/Tidak Sesuai</option>
                                            <option value="unsafe">Tidak Aman/Berbahaya</option>
                                            <option value="inappropriate">Konten Tidak Layak</option>
                                            <option value="other">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="color: #a0c5d5; font-weight: 600;">Deskripsi Detail *</label>
                                        <textarea name="description" class="form-control" required rows="4" placeholder="Jelaskan masalah anda secara detail..." style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(100, 160, 180, 0.3); color: #e0e0e0; border-radius: 8px; resize: none;" minlength="10" maxlength="500"></textarea>
                                        <small style="color: #7a8a9a;">Minimal 10 karakter, maksimal 500 karakter</small>
                                    </div>

                                    <div style="background: rgba(100, 160, 180, 0.1); border-left: 4px solid #64a0b4; padding: 0.75rem 1rem; border-radius: 4px; color: #a0c5d5; font-size: 0.85rem;">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Laporan palsu atau spam akan membuat akun anda kehilangan kepercayaan.
                                    </div>
                                </div>

                                <div class="modal-footer" style="border-top: 1px solid rgba(100, 160, 180, 0.2);">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: rgba(100, 160, 180, 0.2); color: #64a0b4; border: 1px solid rgba(100, 160, 180, 0.3); text-decoration: none; font-weight: 600; padding: 0.5rem 1.5rem; border-radius: 8px;">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #e8b056 0%, #d68940 100%); color: white; border: none; text-decoration: none; font-weight: 600; padding: 0.5rem 1.5rem; border-radius: 8px;">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp5\htdocs\JajanGaming1\resources\views/products/show.blade.php ENDPATH**/ ?>