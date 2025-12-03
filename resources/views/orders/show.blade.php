@extends('layouts.app')

@section('title', 'Order Details - JajanGaming')

@section('content')
<style>
    @media (max-width: 768px) {
        .order-details {
            margin-bottom: 2rem;
        }
        
        .order-details .card-body {
            padding: 1rem;
        }
        
        .order-info {
            margin-bottom: 1.5rem;
        }
        
        .order-info .row {
            flex-direction: column;
        }
        
        .order-info .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .order-info .col-md-6:last-child {
            margin-bottom: 0;
        }
        
        .order-items {
            margin-bottom: 1.5rem;
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
            margin-bottom: 1.5rem;
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
        .order-details .card-body {
            padding: 0.8rem;
        }
        
        .order-details h5 {
            font-size: 1rem;
        }
        
        .order-details .text-muted {
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
            <h2><i class="fas fa-receipt me-2"></i>Order Details</h2>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Order #{{ $order->order_number }}</h5>
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
                            <span class="h5 text-primary">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <h6>Order Items:</h6>
                    @foreach($order->orderItems as $index => $item)
                        <div class="card mb-2 {{ $index % 2 == 0 ? 'card-evenodd-light' : 'card-evenodd-white' }}">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset('img/' . $item->product->image) }}" 
                                             class="img-fluid rounded order-item-image" alt="{{ $item->product->name }}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                        <p class="text-muted mb-0">{{ $item->product->game_name }} - {{ $item->product->game_type }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-shopping-cart text-success me-1"></i>
                                            {{ number_format($item->product->sales_count) }} terjual
                                        </small>
                                        <br>
                                        <!-- Seller Info -->
                                        <div class="d-flex align-items-center mt-1">
                                            <div class="seller-avatar me-2">
                                                @if($item->product->seller && $item->product->seller->profile_photo)
                                                    <img src="{{ asset('storage/' . $item->product->seller->profile_photo) }}" 
                                                         alt="{{ $item->product->seller_name }}" 
                                                         class="rounded-circle" 
                                                         style="width: 18px; height: 18px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" 
                                                         style="width: 18px; height: 18px;">
                                                        <i class="fas fa-user" style="font-size: 8px;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $item->product->seller_name }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 text-center">
                                        <span class="badge bg-secondary">{{ $item->quantity }}x</span>
                                    </div>
                                    
                                    <div class="col-md-2 text-end">
                                        <span class="h6 text-primary">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Order Number:</strong>
                        <br>
                        {{ $order->order_number }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Order Date:</strong>
                        <br>
                        {{ $order->created_at->format('d M Y H:i') }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Payment Method:</strong>
                        <br>
                        @if($order->payment_method === 'wallet')
                            <span class="badge bg-info">DompetKu</span>
                        @else
                            <span class="badge bg-primary">Payment Gateway</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Total Amount:</strong>
                        <br>
                        <span class="h5 text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($order->roblox_username)
                    <div class="mb-3">
                        <strong><i class="fas fa-gamepad me-1"></i>Roblox Username:</strong>
                        <br>
                        <span class="badge bg-primary">{{ $order->roblox_username }}</span>
                        <br>
                        <small class="text-muted">Your Robux will be sent to this username</small>
                    </div>
                    @endif
                    
                    @if($order->notes)
                        <div class="mb-3">
                            <strong>Notes:</strong>
                            <br>
                            <small>{{ $order->notes }}</small>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 btn-slide btn-glow">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="ratingModalLabel">
                    <i class="fas fa-star me-2"></i>Rate Your Purchase
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Thank you for your purchase!</strong><br>
                        <small>Please rate your experience to help us improve our service.</small>
                    </div>
                </div>

                <form id="ratingForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    
                    @foreach($order->orderItems as $item)
                    <div class="rating-item mb-4 p-3 border rounded">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">Seller: {{ $item->product->seller_name }}</small>
                                <div class="mt-2">
                                    <span class="text-muted">Quantity: </span>
                                    <span class="badge bg-primary">{{ $item->quantity }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rating-stars text-center">
                                    <div class="stars mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star-rating" 
                                           data-product-id="{{ $item->product_id }}" 
                                           data-rating="{{ $i }}"
                                           style="font-size: 1.5rem; color: #ddd; cursor: pointer; margin: 0 2px;"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">Rate this product</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <textarea class="form-control" 
                                      name="review_{{ $item->product_id }}" 
                                      placeholder="Write a review (optional)" 
                                      rows="2"></textarea>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Skip Rating
                        </button>
                        <button type="submit" class="btn btn-primary btn-slide">
                            <i class="fas fa-star me-2"></i>Submit Rating
                        </button>
                        <br><br>
                        <small class="text-muted">
                            <a href="{{ route('debug.rating', $order->id) }}" target="_blank" class="text-decoration-none me-3">
                                <i class="fas fa-bug me-1"></i>Debug Order Info
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="testRating()">
                                <i class="fas fa-flask me-1"></i>Test Rating
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="testRatingsStore()">
                                <i class="fas fa-flask me-1"></i>Test Ratings.Store
                            </button>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.rating-item {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef !important;
    transition: all 0.3s ease;
}

.rating-item:hover {
    background-color: #e9ecef;
    border-color: #007bff !important;
}

.star-rating {
    transition: all 0.2s ease;
}

.star-rating:hover {
    transform: scale(1.1);
}

.star-rating.active {
    color: #ffc107 !important;
}

.star-rating.rated {
    color: #ffc107 !important;
}

.btn-slide {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.btn-slide:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing rating system...');
    
    // Check if we should show rating modal
    @if(session('show_rating_modal'))
        console.log('Showing rating modal...');
        const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));
        ratingModal.show();
    @endif

    // Star rating functionality
    const starRatings = document.querySelectorAll('.star-rating');
    console.log('Found star ratings:', starRatings.length);
    const ratings = {}; // Store ratings for each product

    starRatings.forEach(star => {
        star.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const rating = parseInt(this.dataset.rating);
            
            console.log(`Star clicked: Product ${productId}, Rating ${rating}`);
            
            // Update ratings object
            ratings[productId] = rating;
            console.log('Updated ratings:', ratings);
            
            // Update visual stars for this product
            const productStars = document.querySelectorAll(`[data-product-id="${productId}"]`);
            productStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('rated');
                    s.classList.remove('active');
                } else {
                    s.classList.remove('rated', 'active');
                }
            });
        });

        star.addEventListener('mouseenter', function() {
            const productId = this.dataset.productId;
            const rating = parseInt(this.dataset.rating);
            
            // Highlight stars on hover
            const productStars = document.querySelectorAll(`[data-product-id="${productId}"]`);
            productStars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            const productId = this.dataset.productId;
            
            // Remove hover effects
            const productStars = document.querySelectorAll(`[data-product-id="${productId}"]`);
            productStars.forEach(s => {
                s.classList.remove('active');
            });
        });
    });

    // Handle form submission
    const ratingForm = document.getElementById('ratingForm');
    if (!ratingForm) {
        console.error('Rating form not found!');
        return;
    }
    
    console.log('Rating form found, adding submit listener...');
    
    // Remove any existing event listeners
    ratingForm.removeEventListener('submit', handleSubmit);
    
    // Add new event listener
    ratingForm.addEventListener('submit', handleSubmit);
    
    function handleSubmit(e) {
        e.preventDefault();
        
        console.log('=== FORM SUBMISSION STARTED ===');
        console.log('Form submitted!');
        console.log('Ratings object:', ratings);
        console.log('Ratings keys:', Object.keys(ratings));
        console.log('Ratings values:', Object.values(ratings));
        
        // Check if any ratings are selected
        if (Object.keys(ratings).length === 0) {
            console.log('No ratings selected, showing alert');
            alert('Please select at least one rating before submitting.');
            return;
        }
        
        console.log('Ratings validation passed, proceeding...');
        
        const formData = new FormData(this);
        
        // Add ratings to form data
        Object.keys(ratings).forEach(productId => {
            formData.append(`rating_${productId}`, ratings[productId]);
            console.log(`Added rating for product ${productId}: ${ratings[productId]}`);
        });
        
        console.log('FormData entries:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // Submit via AJAX
        console.log('=== STARTING AJAX REQUEST ===');
        console.log('Submitting to:', '{{ route("ratings.store") }}');
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        const requestOptions = {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        };
        
        console.log('Request options:', requestOptions);
        
        fetch('{{ route("ratings.store") }}', requestOptions)
        .then(response => {
            console.log('=== RESPONSE RECEIVED ===');
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            console.log('Response ok:', response.ok);
            
            if (!response.ok) {
                console.error('Response not ok:', response.status, response.statusText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('=== RESPONSE DATA ===');
            console.log('Response data:', data);
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Thank you!</strong> Your rating has been submitted successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.querySelector('.modal-body').insertBefore(alert, document.querySelector('.modal-body').firstChild);
                
                // Close modal after 2 seconds
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('ratingModal')).hide();
                }, 2000);
            } else {
                alert('Error submitting rating. Please try again.');
            }
        })
        .catch(error => {
            console.error('=== FETCH ERROR ===');
            console.error('Fetch error:', error);
            console.error('Error details:', error.message);
            console.error('Error stack:', error.stack);
            alert('Error submitting rating: ' + error.message);
        });
    });
    
    // Test rating function
    window.testRating = function() {
        console.log('Testing rating submission...');
        
        const formData = new FormData();
        formData.append('order_id', {{ $order->id }});
        formData.append('rating_1', 5);
        formData.append('review_1', 'Test review');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        console.log('Test form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        fetch('{{ route("test.rating") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Test response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Test response data:', data);
            alert('Test successful! Check console for details.');
        })
        .catch(error => {
            console.error('Test error:', error);
            alert('Test failed: ' + error.message);
        });
    };
    
    // Test ratings.store function
    window.testRatingsStore = function() {
        console.log('Testing ratings.store submission...');
        
        const formData = new FormData();
        formData.append('order_id', {{ $order->id }});
        formData.append('rating_1', 5);
        formData.append('review_1', 'Test review');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        console.log('Test ratings.store form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        fetch('{{ route("test.ratings.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Test ratings.store response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Test ratings.store response data:', data);
            alert('Test ratings.store successful! Check console for details.');
        })
        .catch(error => {
            console.error('Test ratings.store error:', error);
            alert('Test ratings.store failed: ' + error.message);
        });
    };
});
</script>
@endsection
