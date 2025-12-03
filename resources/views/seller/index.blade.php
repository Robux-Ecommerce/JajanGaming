@extends('layouts.app')

@section('title', 'Top Sellers - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-store me-2"></i>Top Sellers
                </h1>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($sellers as $index => $seller)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow seller-card" style="transition: all 0.3s ease; cursor: pointer;" 
                     onclick="window.location.href='{{ route('seller.profile', $seller->id) }}'">
                    <div class="card-header bg-gradient text-white" 
                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($seller->profile_photo)
                                    <img src="{{ asset('storage/' . $seller->profile_photo) }}" 
                                         alt="{{ $seller->name }}" 
                                         class="rounded-circle" 
                                         style="width: 50px; height: 50px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" 
                                         style="width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.3);">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $seller->name }}</h5>
                                <small class="opacity-75">
                                    <i class="fas fa-store me-1"></i>Verified Seller
                                </small>
                            </div>
                            @if($index < 3)
                                <div class="ms-2">
                                    <i class="fas fa-trophy text-warning fa-lg"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($seller->description)
                            <p class="card-text text-muted mb-3">{{ Str::limit($seller->description, 100) }}</p>
                        @endif
                        
                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <h6 class="text-primary mb-1">{{ $seller->products_count }}</h6>
                                <small class="text-muted">Products</small>
                            </div>
                            <div class="col-4">
                                <h6 class="text-success mb-1">{{ $seller->total_sales }}</h6>
                                <small class="text-muted">Sales</small>
                            </div>
                            <div class="col-4">
                                <h6 class="text-warning mb-1">{{ number_format($seller->average_rating, 1) }}</h6>
                                <small class="text-muted">Rating</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($seller->average_rating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i - 0.5 <= $seller->average_rating)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-muted small">({{ number_format($seller->average_rating, 1) }})</span>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>View Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-store fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Sellers Available</h4>
                    <p class="text-muted">There are no sellers registered yet.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
.seller-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endsection
