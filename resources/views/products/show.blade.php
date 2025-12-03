@extends('layouts.app')

@section('title', $product->name . ' - JajanGaming')

@section('content')
<style>
    @media (max-width: 768px) {
        .product-details {
            margin-bottom: 2rem;
        }
        
        .product-details .card-body {
            padding: 1rem;
        }
        
        .product-image {
            margin-bottom: 1.5rem;
        }
        
        .product-image .card-body {
            text-align: center;
        }
        
        .product-image .product-icon {
            font-size: 4rem;
        }
        
        .product-info {
            margin-bottom: 1.5rem;
        }
        
        .product-info h2 {
            font-size: 1.5rem;
        }
        
        .product-info h5 {
            font-size: 1.1rem;
        }
        
        .product-info .badge {
            font-size: 0.8rem;
        }
        
        .product-actions {
            margin-top: 1.5rem;
        }
        
        .product-actions .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .product-actions .btn:last-child {
            margin-bottom: 0;
        }
        
        .product-detail-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            object-position: center;
        }
    }
    
    @media (max-width: 576px) {
        .product-details .card-body {
            padding: 0.8rem;
        }
        
        .product-image .product-icon {
            font-size: 3rem;
        }
        
        .product-info h2 {
            font-size: 1.3rem;
        }
        
        .product-info h5 {
            font-size: 1rem;
        }
        
        .product-info .badge {
            font-size: 0.75rem;
        }
        
        .product-info .card-text {
            font-size: 0.9rem;
        }
        
        .product-actions .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('img/' . $product->image) }}" 
                 class="img-fluid rounded product-detail-image" alt="{{ $product->name }}">
        </div>
        
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->game_name }} - {{ $product->game_type }}</p>
            
            <div class="mb-3">
                <span class="badge bg-success fs-6">{{ $product->game_type }}</span>
            </div>
            
            <div class="mb-4">
                <h3 class="text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
            </div>
            
            <!-- Rating Display -->
            <div class="mb-4">
                <div class="d-flex align-items-center">
                    <div class="me-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->averageRating()))
                                <i class="fas fa-star text-warning"></i>
                            @elseif($i - 0.5 <= $product->averageRating())
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="me-2">{{ number_format($product->averageRating(), 1) }}</span>
                    <span class="text-muted">({{ $product->totalRatings() }} reviews)</span>
                </div>
            </div>
            
            @if($product->description)
                <div class="mb-4">
                    <h5>Description:</h5>
                    <p>{{ $product->description }}</p>
                </div>
            @endif
            
            <div class="mb-4">
                <h5>Product Information:</h5>
                <ul class="list-unstyled">
                    <li><strong>Game:</strong> {{ $product->game_name }}</li>
                    <li><strong>Type:</strong> {{ $product->game_type }}</li>
                    <li><strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</li>
                    <li><strong>Stock:</strong> {{ $product->quantity }} available</li>
                    <li><strong>Sales:</strong> {{ number_format($product->sales_count) }} terjual</li>
                </ul>
            </div>

            <!-- Seller Information -->
            <div class="mb-4">
                <h5>Seller Information:</h5>
                <div class="d-flex align-items-center">
                    <div class="seller-avatar me-3">
                        @if($product->seller && $product->seller->profile_photo)
                            <img src="{{ asset('storage/' . $product->seller->profile_photo) }}" 
                                 alt="{{ $product->seller_name }}" 
                                 class="rounded-circle" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $product->seller_name }}</h6>
                        <small class="text-muted">Verified Seller</small>
                    </div>
                </div>
            </div>
            
            @auth
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   value="1" min="1" max="{{ $product->quantity }}">
                        </div>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary btn-lg w-100 btn-slide btn-glow">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Please <a href="{{ route('login') }}">login</a> to add this product to your cart.
                </div>
            @endauth
            
            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-slide btn-glow">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
