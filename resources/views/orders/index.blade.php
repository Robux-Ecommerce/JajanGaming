@extends('layouts.app')

@section('title', 'My Orders - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .order-card {
            margin-bottom: 1.5rem;
        }
        
        .order-card .card-body {
            padding: 1rem;
        }
        
        .order-header {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .order-header .badge {
            margin-top: 0.5rem;
            margin-left: 0 !important;
        }
        
        .order-items {
            margin-top: 1rem;
        }
        
        .order-item {
            margin-bottom: 0.5rem;
        }
        
        .order-item .row {
            flex-direction: column;
        }
        
        .order-item .col-md-2 {
            margin-bottom: 0.5rem;
        }
        
        .order-item .col-md-4 {
            margin-bottom: 0.5rem;
        }
        
        .order-item .col-md-2:last-child {
            margin-bottom: 0;
        }
        
        .order-summary {
            margin-top: 1rem;
        }
        
        .order-summary .row {
            flex-direction: column;
        }
        
        .order-summary .col-md-6 {
            margin-bottom: 0.5rem;
        }
        
        .order-summary .col-md-6:last-child {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 576px) {
        .order-card .card-body {
            padding: 0.8rem;
        }
        
        .order-card h5 {
            font-size: 1rem;
        }
        
        .order-card .text-muted {
            font-size: 0.85rem;
        }
        
        .order-item .card-body {
            padding: 0.8rem;
        }
        
        .order-item h6 {
            font-size: 0.9rem;
        }
        
        .order-item .text-muted {
            font-size: 0.8rem;
        }
        
        .order-summary .card-body {
            padding: 0.8rem;
        }
        
        .order-summary h6 {
            font-size: 0.9rem;
        }
        
        .order-summary .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-list me-2"></i>My Orders</h2>
            <hr>
        </div>
    </div>

    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="card mb-3 card-spacing">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>Order #{{ $order->order_number }}
                            </h5>
                        </div>
                        <div class="col-md-3">
                            <span class="badge 
                                @if($order->status === 'completed') bg-success
                                @elseif($order->status === 'pending') bg-warning
                                @elseif($order->status === 'processing') bg-info
                                @else bg-danger
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-3 text-end">
                            <span class="h6 text-primary">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Order Items:</h6>
                            @foreach($order->orderItems as $index => $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 {{ $index % 2 == 0 ? 'evenodd-light' : 'evenodd-white' }}">
                                    <div>
                                        <strong>{{ $item->product->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $item->product->game_name }} - {{ $item->product->game_type }}</small>
                                        @if($order->status === 'completed')
                                            <br>
                                            <button class="btn btn-sm btn-outline-warning mt-1" 
                                                    onclick="openRatingModal({{ $item->product->id }}, {{ $order->id }}, '{{ $item->product->name }}')">
                                                <i class="fas fa-star me-1"></i>Rate Product
                                            </button>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <span>{{ $item->quantity }}x</span>
                                        <br>
                                        <span class="text-primary">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-2">
                                <strong>Payment Method:</strong>
                                @if($order->payment_method === 'wallet')
                                    <span class="badge bg-info">DompetKu</span>
                                @else
                                    <span class="badge bg-primary">Payment Gateway</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Order Date:</strong>
                                <br>
                                {{ $order->created_at->format('d M Y H:i') }}
                            </div>
                            
                            @if($order->notes)
                                <div class="mb-2">
                                    <strong>Notes:</strong>
                                    <br>
                                    <small>{{ $order->notes }}</small>
                                </div>
                            @endif
                            
                            <div class="mt-3">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm btn-slide btn-glow">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <div class="row">
            <div class="col-12">
                <div class="pagination-info">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </div>
                {{ $orders->links('pagination.bootstrap-5') }}
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
            <h3>No orders yet</h3>
            <p class="text-muted">Your orders will appear here once you make a purchase</p>
            <a href="{{ route('home') }}" class="btn btn-primary btn-slide btn-glow">
                <i class="fas fa-shopping-bag me-2"></i>Start Shopping
            </a>
        </div>
    @endif
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">
                    <i class="fas fa-star me-2"></i>Rate Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    @csrf
                    <input type="hidden" id="rating_product_id" name="product_id">
                    <input type="hidden" id="rating_order_id" name="order_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Product:</label>
                        <p class="fw-bold" id="rating_product_name"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Rating *</label>
                        <div class="rating-input">
                            <div class="stars">
                                <i class="fas fa-star" data-rating="1"></i>
                                <i class="fas fa-star" data-rating="2"></i>
                                <i class="fas fa-star" data-rating="3"></i>
                                <i class="fas fa-star" data-rating="4"></i>
                                <i class="fas fa-star" data-rating="5"></i>
                            </div>
                            <input type="hidden" id="rating_value" name="rating" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="review" class="form-label">Review (Optional)</label>
                        <textarea class="form-control" id="review" name="review" rows="3" 
                                  placeholder="Share your experience with this product..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="submitRating()">
                    <i class="fas fa-star me-1"></i>Submit Rating
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input .stars {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
}

.rating-input .stars i {
    margin-right: 5px;
    transition: color 0.2s;
}

.rating-input .stars i:hover,
.rating-input .stars i.active {
    color: #ffc107;
}

.rating-input .stars i.filled {
    color: #ffc107;
}
</style>

<script>
function openRatingModal(productId, orderId, productName) {
    document.getElementById('rating_product_id').value = productId;
    document.getElementById('rating_order_id').value = orderId;
    document.getElementById('rating_product_name').textContent = productName;
    document.getElementById('rating_value').value = '';
    document.getElementById('review').value = '';
    
    // Reset stars
    document.querySelectorAll('.rating-input .stars i').forEach(star => {
        star.classList.remove('active', 'filled');
    });
    
    new bootstrap.Modal(document.getElementById('ratingModal')).show();
}

// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-input .stars i');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            document.getElementById('rating_value').value = rating;
            
            // Update star display
            stars.forEach((s, i) => {
                s.classList.remove('active', 'filled');
                if (i < rating) {
                    s.classList.add('filled');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach((s, i) => {
                s.classList.remove('active');
                if (i < rating) {
                    s.classList.add('active');
                }
            });
        });
    });
    
    document.querySelector('.rating-input .stars').addEventListener('mouseleave', function() {
        const currentRating = document.getElementById('rating_value').value;
        stars.forEach((s, i) => {
            s.classList.remove('active');
            if (i < currentRating) {
                s.classList.add('filled');
            }
        });
    });
});

function submitRating() {
    const form = document.getElementById('ratingForm');
    const formData = new FormData(form);
    
    if (!formData.get('rating')) {
        alert('Please select a rating');
        return;
    }
    
    fetch('{{ route("ratings.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('ratingModal')).hide();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the rating');
    });
}
</script>
@endsection
