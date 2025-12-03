@extends('layouts.app')

@section('title', 'Shopping Cart - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
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
        
        .cart-item {
            margin-bottom: 1rem;
        }
        
        .cart-item .row {
            flex-direction: column;
        }
        
        .cart-item .col-md-2 {
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .cart-item .col-md-4 {
            margin-bottom: 0.5rem;
            text-align: center;
        }
        
        .cart-item .col-md-2:last-child {
            margin-bottom: 0;
            text-align: center;
        }
        
        .cart-summary {
            margin-top: 2rem;
        }
        
        .cart-item-image {
            width: 80px !important;
            height: 80px !important;
            margin: 0 auto;
        }
        
        .card-title {
            font-size: 0.9rem;
        }
        
        .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .form-control {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }
    }
    
    @media (max-width: 576px) {
        .container {
            padding-left: 5px;
            padding-right: 5px;
        }
        
        .cart-item {
            margin-bottom: 0.75rem;
        }
        
        .cart-item .card {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        .cart-item .card-body {
            padding: 0.75rem;
        }
        
        .cart-item-image {
            width: 60px !important;
            height: 60px !important;
            border-radius: 8px;
        }
        
        .card-title {
            font-size: 0.85rem;
            line-height: 1.2;
            margin-bottom: 0.4rem;
        }
        
        .card-text {
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }
        
        .btn {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
        }
        
        .form-control {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
            border-radius: 6px;
        }
        
        .h6 {
            font-size: 0.9rem;
        }
        
        .text-muted {
            font-size: 0.7rem;
        }
        
        .badge {
            font-size: 0.65rem;
            padding: 3px 6px;
        }
    }
    
    @media (max-width: 480px) {
        .cart-item .card-body {
            padding: 0.6rem;
        }
        
        .cart-item-image {
            width: 50px !important;
            height: 50px !important;
        }
        
        .card-title {
            font-size: 0.8rem;
        }
        
        .card-text {
            font-size: 0.7rem;
        }
        
        .btn {
            font-size: 0.7rem;
            padding: 0.3rem 0.5rem;
        }
        
        .form-control {
            font-size: 0.7rem;
            padding: 0.25rem 0.4rem;
        }
        
        .h6 {
            font-size: 0.85rem;
        }
        
        .text-muted {
            font-size: 0.65rem;
        }
    }
    
    /* Roblox Username Field Styling */
    .roblox-username-field {
        position: relative;
    }
    
    .roblox-username-field .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .roblox-username-field .form-control:focus {
        border-color: #00d4aa;
        box-shadow: 0 0 0 0.2rem rgba(0, 212, 170, 0.25);
    }
    
    .roblox-username-field .form-label {
        color: #333;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .roblox-username-field .form-text {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 6px;
    }
    
    .roblox-username-field .text-danger {
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .roblox-username-field .form-control {
            font-size: 14px;
            padding: 10px 12px;
        }
    }
        
        .btn-group {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-group .btn {
            margin-bottom: 0.5rem;
        }
        
        .btn-group .btn:last-child {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 576px) {
        .cart-item .card-body {
            padding: 1rem;
        }
        
        .cart-item h5 {
            font-size: 1rem;
        }
        
        .cart-item .text-muted {
            font-size: 0.85rem;
        }
        
        .cart-summary .card-body {
            padding: 1rem;
        }
        
        .cart-summary h5 {
            font-size: 1.1rem;
        }
        
        .cart-summary .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                </h2>
                <span class="badge bg-primary ms-3">{{ $carts->count() }} items</span>
            </div>
        </div>
    </div>

    @if($carts->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                @foreach($carts as $cart)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset('img/' . $cart->product->image) }}" 
                                         class="img-fluid rounded cart-item-image" alt="{{ $cart->product->name }}">
                                </div>
                                
                                <div class="col-md-4">
                                    <h5 class="card-title mb-1">{{ $cart->product->name }}</h5>
                                    <p class="text-muted mb-0">{{ $cart->product->game_name }}</p>
                                    <small class="text-success">{{ $cart->product->game_type }}</small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-shopping-cart text-success me-1"></i>
                                        {{ number_format($cart->product->sales_count) }} terjual
                                    </small>
                                    <br>
                                    <!-- Seller Info -->
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="seller-avatar me-2">
                                            @if($cart->product->seller && $cart->product->seller->profile_photo)
                                                <img src="{{ asset('storage/' . $cart->product->seller->profile_photo) }}" 
                                                     alt="{{ $cart->product->seller_name }}" 
                                                     class="rounded-circle" 
                                                     style="width: 20px; height: 20px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" 
                                                     style="width: 20px; height: 20px;">
                                                    <i class="fas fa-user" style="font-size: 10px;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $cart->product->seller_name }}</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <span class="h6 text-primary">Rp {{ number_format($cart->price, 0, ',', '.') }}</span>
                                        <br>
                                        <small class="text-muted">per item</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <form action="{{ route('cart.update', $cart) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $cart->quantity }}" 
                                               min="1" class="form-control me-2" style="width: 80px;">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="text-end">
                                        <div class="h6 text-primary mb-1">
                                            Rp {{ number_format($cart->quantity * $cart->price, 0, ',', '.') }}
                                        </div>
                                        <form action="{{ route('cart.remove', $cart) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="text-end mb-4">
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" 
                                onclick="return confirm('Are you sure you want to clear your cart?')">
                            <i class="fas fa-trash me-2"></i>Clear Cart
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calculator me-2"></i>Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span class="h6">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax:</span>
                            <span>Rp 0</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total:</span>
                            <span class="h5 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        @auth
                            <div class="mb-4">
                                <div class="wallet-balance text-center mb-3" style="max-width: 250px; margin: 0 auto;">
                                    <i class="fas fa-wallet me-2"></i>
                                    Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}
                                </div>
                                
                                @if(auth()->user()->wallet_balance < $total)
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Insufficient wallet balance. You need Rp {{ number_format($total - auth()->user()->wallet_balance, 0, ',', '.') }} more.
                                        <a href="{{ route('wallet.index') }}" class="alert-link">Top up now</a>
                                    </div>
                                @endif
                            </div>
                        @endauth
                        
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3 roblox-username-field">
                                <label for="roblox_username" class="form-label fw-bold">
                                    <i class="fas fa-user me-2"></i>Roblox Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('roblox_username') is-invalid @enderror" 
                                       id="roblox_username" name="roblox_username" 
                                       value="{{ old('roblox_username') }}" 
                                       placeholder="Enter your Roblox username" 
                                       required>
                                @error('roblox_username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    This username will be used to send your Robux top-up
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Payment Method:</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="wallet" value="wallet" 
                                           {{ auth()->user()->wallet_balance >= $total ? '' : 'disabled' }}>
                                    <label class="form-check-label" for="wallet">
                                        <i class="fas fa-wallet me-2"></i>DompetKu
                                        @if(auth()->user()->wallet_balance < $total)
                                            <small class="text-danger">(Insufficient balance)</small>
                                        @endif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="gateway" value="gateway" checked>
                                    <label class="form-check-label" for="gateway">
                                        <i class="fas fa-credit-card me-2"></i>Payment Gateway
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold">Notes (Optional):</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Roblox Username, Game ID, etc."></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="checkoutBtn">
                                    <i class="fas fa-credit-card me-2"></i>Checkout Now
                                </button>
                            </div>
                        </form>
                        
                        <!-- Roblox Username Validation Modal -->
                        <div class="modal fade" id="robloxValidationModal" tabindex="-1" aria-labelledby="robloxValidationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="robloxValidationModalLabel">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Roblox Username Required
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center mb-3">
                                            <i class="fas fa-user-circle fa-3x text-warning mb-3"></i>
                                            <h6 class="text-dark">Please enter your Roblox username</h6>
                                            <p class="text-muted mb-0">We need your Roblox username to send the Robux top-up to your account.</p>
                                        </div>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Username Requirements:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li>3-20 characters long</li>
                                                <li>Only letters, numbers, and underscores</li>
                                                <li>Must be your actual Roblox username</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i>Close
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="focusRobloxField()">
                                            <i class="fas fa-edit me-1"></i>Enter Username
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function focusRobloxField() {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('robloxValidationModal'));
                                modal.hide();
                                
                                // Focus on Roblox username field
                                setTimeout(() => {
                                    document.getElementById('roblox_username').focus();
                                    document.getElementById('roblox_username').scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }, 300);
                            }

                            document.getElementById('checkoutBtn').addEventListener('click', function(e) {
                                const robloxUsername = document.getElementById('roblox_username').value.trim();
                                
                                if (!robloxUsername) {
                                    e.preventDefault();
                                    
                                    // Show modal instead of alert
                                    const modal = new bootstrap.Modal(document.getElementById('robloxValidationModal'));
                                    modal.show();
                                    
                                    return false;
                                }
                                
                                // Basic validation for Roblox username format
                                if (robloxUsername.length < 3 || robloxUsername.length > 20) {
                                    e.preventDefault();
                                    showValidationError('Roblox username must be between 3-20 characters.');
                                    document.getElementById('roblox_username').focus();
                                    return false;
                                }
                                
                                // Check for valid characters (letters, numbers, underscores)
                                if (!/^[a-zA-Z0-9_]+$/.test(robloxUsername)) {
                                    e.preventDefault();
                                    showValidationError('Roblox username can only contain letters, numbers, and underscores.');
                                    document.getElementById('roblox_username').focus();
                                    return false;
                                }
                            });

                            function showValidationError(message) {
                                // Create and show a toast notification
                                const toast = document.createElement('div');
                                toast.className = 'toast align-items-center text-white bg-danger border-0 position-fixed';
                                toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
                                toast.innerHTML = `
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            ${message}
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                                    </div>
                                `;
                                
                                document.body.appendChild(toast);
                                const bsToast = new bootstrap.Toast(toast);
                                bsToast.show();
                                
                                // Auto remove after 5 seconds
                                setTimeout(() => {
                                    if (toast.parentNode) {
                                        toast.remove();
                                    }
                                }, 5000);
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                    </div>
                    <h3>Your cart is empty</h3>
                    <p class="text-muted mb-4">Add some Robux packages to get started!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Update cart count after page load
document.addEventListener('DOMContentLoaded', function() {
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
});

// Update cart count after form submissions
document.addEventListener('submit', function(e) {
    if (e.target.matches('form[action*="cart"]')) {
        // Wait a bit for the form to be processed
        setTimeout(() => {
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        }, 1000);
    }
});
</script>
@endsection
