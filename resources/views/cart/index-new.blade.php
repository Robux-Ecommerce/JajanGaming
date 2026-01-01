@extends('layouts.app')

@section('title', 'Shopping Cart - JajanGaming')

@section('content')
<div class="cart-page">
    <!-- Page Header -->
    <div class="cart-header">
        <div class="header-content">
            <a href="{{ route('home') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-info">
                <h1><i class="fas fa-shopping-cart"></i> Shopping Cart</h1>
                <p>Review your items before checkout</p>
            </div>
        </div>
        @if($carts->count() > 0)
            <div class="cart-badge">
                <span class="count">{{ $carts->count() }}</span>
                <span class="label">Items</span>
            </div>
        @endif
    </div>

    @if($carts->count() > 0)
        <div class="cart-container">
            <!-- Cart Items -->
            <div class="cart-items-section">
                <div class="section-title">
                    <i class="fas fa-box-open"></i>
                    <span>Your Items</span>
                </div>
                
                <div class="cart-items">
                    @foreach($carts as $cart)
                        <div class="cart-item">
                            <div class="item-image">
                                @php
                                    $cartImageUrl = file_exists(public_path('storage/' . $cart->product->image)) ? asset('storage/' . $cart->product->image) : asset('img/' . $cart->product->image);
                                @endphp
                                <img src="{{ $cartImageUrl }}" 
                                     alt="{{ $cart->product->name }}">
                                @if($cart->product->discount > 0)
                                    <span class="discount-badge">-{{ $cart->product->discount }}%</span>
                                @endif
                            </div>
                            
                            <div class="item-details">
                                <div class="item-info">
                                    <h4 class="item-name">{{ $cart->product->name }}</h4>
                                    <div class="item-meta">
                                        <span class="game-badge">
                                            <i class="fas fa-gamepad"></i>
                                            {{ $cart->product->game_name }}
                                        </span>
                                        <span class="type-badge">{{ $cart->product->game_type }}</span>
                                    </div>
                                    <div class="seller-info">
                                        <div class="seller-avatar">
                                            @if($cart->product->seller && $cart->product->seller->profile_photo)
                                                <img src="{{ asset('storage/' . $cart->product->seller->profile_photo) }}" 
                                                     alt="{{ $cart->product->seller_name }}">
                                            @else
                                                <i class="fas fa-user"></i>
                                            @endif
                                        </div>
                                        <span class="seller-name">{{ $cart->product->seller_name }}</span>
                                        <span class="sales-count">
                                            <i class="fas fa-check-circle"></i>
                                            {{ number_format($cart->product->sales_count) }} sold
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="item-actions">
                                    <div class="price-section">
                                        <span class="unit-price">Rp {{ number_format($cart->price, 0, ',', '.') }}</span>
                                        <span class="price-label">per item</span>
                                    </div>
                                    
                                    <form action="{{ route('cart.update', $cart) }}" method="POST" class="quantity-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="quantity-control">
                                            <button type="button" class="qty-btn minus" onclick="updateQty(this, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $cart->quantity }}" 
                                                   min="1" class="qty-input" readonly>
                                            <button type="button" class="qty-btn plus" onclick="updateQty(this, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <button type="submit" class="update-btn">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                    
                                    <div class="subtotal">
                                        <span class="subtotal-label">Subtotal</span>
                                        <span class="subtotal-price">Rp {{ number_format($cart->quantity * $cart->price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <form action="{{ route('cart.remove', $cart) }}" method="POST" class="remove-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-btn" 
                                                onclick="return confirm('Remove this item from cart?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Clear Cart Button -->
                <div class="cart-actions">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="clear-cart-btn" 
                                onclick="return confirm('Clear all items from cart?')">
                            <i class="fas fa-trash"></i>
                            <span>Clear Cart</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="order-summary-section">
                <div class="summary-card">
                    <div class="summary-header">
                        <i class="fas fa-receipt"></i>
                        <h3>Order Summary</h3>
                    </div>
                    
                    <div class="summary-body">
                        <!-- Price Breakdown -->
                        <div class="price-breakdown">
                            <div class="breakdown-item">
                                <span>Subtotal ({{ $carts->count() }} items)</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Service Fee</span>
                                <span class="free">FREE</span>
                            </div>
                        </div>
                        
                        <div class="total-section">
                            <span class="total-label">Total</span>
                            <span class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Wallet Balance -->
                        @auth
                            <div class="wallet-section">
                                <a href="{{ route('wallet.index') }}" class="wallet-display">
                                    <div class="wallet-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="wallet-info">
                                        <span class="wallet-label">Your Balance</span>
                                        <span class="wallet-amount">Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}</span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                
                                @if(auth()->user()->wallet_balance < $total)
                                    <div class="insufficient-alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <div class="alert-content">
                                            <span>Insufficient balance</span>
                                            <a href="{{ route('wallet.index') }}">Top up Rp {{ number_format($total - auth()->user()->wallet_balance, 0, ',', '.') }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endauth
                        
                        <!-- Checkout Form -->
                        <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                            @csrf
                            
                            <!-- Roblox Username -->
                            <div class="form-group roblox-field">
                                <label>
                                    <i class="fas fa-user-tag"></i>
                                    Roblox Username <span class="required">*</span>
                                </label>
                                <input type="text" name="roblox_username" id="roblox_username"
                                       class="form-input @error('roblox_username') error @enderror"
                                       placeholder="Enter your Roblox username"
                                       value="{{ old('roblox_username') }}" required>
                                <span class="input-hint">
                                    <i class="fas fa-info-circle"></i>
                                    This username will be used to send your Robux top-up
                                </span>
                                @error('roblox_username')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Payment Method -->
                            <div class="form-group payment-method">
                                <label>Payment Method:</label>
                                <div class="payment-options">
                                    <label class="payment-option {{ auth()->user()->wallet_balance < $total ? 'disabled' : '' }}">
                                        <input type="radio" name="payment_method" value="wallet"
                                               {{ auth()->user()->wallet_balance < $total ? 'disabled' : '' }}>
                                        <div class="option-content">
                                            <div class="option-icon wallet">
                                                <i class="fas fa-wallet"></i>
                                            </div>
                                            <div class="option-info">
                                                <span class="option-name">DompetKu</span>
                                                @if(auth()->user()->wallet_balance < $total)
                                                    <span class="option-status error">Insufficient</span>
                                                @else
                                                    <span class="option-status">Available</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="check-mark"><i class="fas fa-check"></i></div>
                                    </label>
                                    
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="gateway" checked>
                                        <div class="option-content">
                                            <div class="option-icon gateway">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <div class="option-info">
                                                <span class="option-name">Payment Gateway</span>
                                                <span class="option-status">Bank, E-Wallet, etc.</span>
                                            </div>
                                        </div>
                                        <div class="check-mark"><i class="fas fa-check"></i></div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="form-group notes-field">
                                <label>Notes (Optional):</label>
                                <textarea name="notes" class="form-textarea" rows="2"
                                          placeholder="Roblox Username, Game ID, etc."></textarea>
                            </div>
                            
                            <!-- Checkout Button -->
                            <button type="submit" class="checkout-btn" id="checkoutBtn">
                                <i class="fas fa-lock"></i>
                                <span>Checkout Now</span>
                                <span class="btn-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </button>
                        </form>
                        
                        <!-- Security Note -->
                        <div class="security-note">
                            <i class="fas fa-shield-alt"></i>
                            <span>Your payment is secure and encrypted</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="empty-cart">
            <div class="empty-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Your Cart is Empty</h3>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('home') }}" class="shop-btn">
                <i class="fas fa-gamepad"></i>
                Browse Products
            </a>
        </div>
    @endif
</div>

<!-- Roblox Username Modal -->
<div class="modal-overlay" id="robloxModal">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>Roblox Username Required</h3>
            <button class="modal-close" onclick="closeRobloxModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-illustration">
                <i class="fas fa-user-circle"></i>
            </div>
            <p class="modal-message">Please enter your Roblox username</p>
            <p class="modal-submessage">We need your Roblox username to send the Robux top-up to your account.</p>
            
            <div class="requirements-box">
                <div class="requirements-header">
                    <i class="fas fa-info-circle"></i>
                    <span>Username Requirements:</span>
                </div>
                <ul class="requirements-list">
                    <li><i class="fas fa-check"></i> 3-20 characters long</li>
                    <li><i class="fas fa-check"></i> Only letters, numbers, and underscores</li>
                    <li><i class="fas fa-check"></i> Must be your actual Roblox username</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-btn secondary" onclick="closeRobloxModal()">
                <i class="fas fa-times"></i> Close
            </button>
            <button class="modal-btn primary" onclick="focusRobloxField()">
                <i class="fas fa-edit"></i> Enter Username
            </button>
        </div>
    </div>
</div>

<style>
/* ===================================================================
   CART PAGE - Soft Teal Gaming Theme
=================================================================== */
.cart-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem 1rem;
}

/* Header */
.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.95) 0%, rgba(25, 35, 48, 0.9) 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.15);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.back-btn {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(100, 160, 180, 0.1);
    border-radius: 10px;
    color: #64b5c6;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(100, 160, 180, 0.2);
    color: #a8e0eb;
    transform: translateX(-3px);
}

.header-info h1 {
    font-size: 1.35rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.header-info h1 i {
    color: #64b5c6;
}

.header-info p {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

.cart-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(100, 160, 180, 0.1) 100%);
    border-radius: 12px;
    border: 1px solid rgba(100, 160, 180, 0.3);
}

.cart-badge .count {
    font-size: 1.5rem;
    font-weight: 700;
    color: #64b5c6;
    line-height: 1;
}

.cart-badge .label {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.5);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Cart Container */
.cart-container {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 1.5rem;
    align-items: start;
}

/* Cart Items Section */
.cart-items-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(100, 160, 180, 0.15);
}

.section-title i {
    color: #64b5c6;
}

/* Cart Item */
.cart-items {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.cart-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.9) 0%, rgba(25, 35, 48, 0.85) 100%);
    border-radius: 14px;
    border: 1px solid rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.cart-item:hover {
    border-color: rgba(100, 160, 180, 0.25);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.item-image {
    position: relative;
    width: 100px;
    height: 100px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.discount-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
}

.item-details {
    flex: 1;
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.item-info {
    flex: 1;
}

.item-name {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}

.item-meta {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.game-badge {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.6);
    background: rgba(100, 160, 180, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

.type-badge {
    font-size: 0.7rem;
    color: #2ecc71;
    background: rgba(46, 204, 113, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

.seller-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
}

.seller-avatar {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    overflow: hidden;
    background: rgba(100, 160, 180, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.seller-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.seller-avatar i {
    font-size: 0.6rem;
    color: rgba(255, 255, 255, 0.5);
}

.seller-name {
    color: rgba(255, 255, 255, 0.7);
}

.sales-count {
    color: #2ecc71;
    font-size: 0.75rem;
}

.sales-count i {
    font-size: 0.65rem;
}

/* Item Actions */
.item-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.75rem;
}

.price-section {
    text-align: right;
}

.unit-price {
    font-size: 0.95rem;
    font-weight: 600;
    color: #64b5c6;
    display: block;
}

.price-label {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.4);
}

.quantity-form {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-control {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border: 1px solid rgba(100, 160, 180, 0.2);
}

.qty-btn {
    width: 30px;
    height: 30px;
    border: none;
    background: transparent;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: all 0.2s ease;
}

.qty-btn:hover {
    color: #64b5c6;
    background: rgba(100, 160, 180, 0.1);
}

.qty-input {
    width: 40px;
    height: 30px;
    border: none;
    background: transparent;
    color: #ffffff;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
}

.update-btn {
    width: 30px;
    height: 30px;
    border: none;
    background: rgba(100, 160, 180, 0.15);
    color: #64b5c6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.update-btn:hover {
    background: rgba(100, 160, 180, 0.25);
}

.subtotal {
    text-align: right;
}

.subtotal-label {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.4);
    display: block;
}

.subtotal-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
}

.remove-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.remove-btn:hover {
    background: rgba(231, 76, 60, 0.2);
    transform: scale(1.1);
}

/* Cart Actions */
.cart-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 1rem;
}

.clear-cart-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    background: transparent;
    border: 1px solid rgba(231, 76, 60, 0.3);
    color: #e74c3c;
    border-radius: 8px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.clear-cart-btn:hover {
    background: rgba(231, 76, 60, 0.1);
    border-color: rgba(231, 76, 60, 0.5);
}

/* Order Summary */
.summary-card {
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.95) 0%, rgba(25, 35, 48, 0.9) 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.15);
    overflow: hidden;
    position: sticky;
    top: 90px;
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.1) 0%, transparent 100%);
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
}

.summary-header i {
    font-size: 1.25rem;
    color: #64b5c6;
}

.summary-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
}

.summary-body {
    padding: 1.25rem;
}

/* Price Breakdown */
.price-breakdown {
    margin-bottom: 1rem;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
}

.breakdown-item .free {
    color: #2ecc71;
    font-weight: 600;
}

.total-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-top: 1px solid rgba(100, 160, 180, 0.15);
    border-bottom: 1px solid rgba(100, 160, 180, 0.15);
    margin-bottom: 1rem;
}

.total-label {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
}

.total-price {
    font-size: 1.35rem;
    font-weight: 700;
    color: #64b5c6;
}

/* Wallet Section */
.wallet-section {
    margin-bottom: 1.25rem;
}

.wallet-display {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: rgba(100, 160, 180, 0.08);
    border: 1px solid rgba(100, 160, 180, 0.2);
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.wallet-display:hover {
    background: rgba(100, 160, 180, 0.12);
    border-color: rgba(100, 160, 180, 0.35);
}

.wallet-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(100, 160, 180, 0.1) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64b5c6;
}

.wallet-info {
    flex: 1;
}

.wallet-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
    display: block;
}

.wallet-amount {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
}

.wallet-display > i {
    color: rgba(255, 255, 255, 0.3);
}

.insufficient-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-top: 0.75rem;
    padding: 0.75rem;
    background: rgba(231, 76, 60, 0.1);
    border: 1px solid rgba(231, 76, 60, 0.2);
    border-radius: 8px;
}

.insufficient-alert > i {
    color: #e74c3c;
    margin-top: 2px;
}

.alert-content {
    display: flex;
    flex-direction: column;
    font-size: 0.8rem;
}

.alert-content span {
    color: #e74c3c;
}

.alert-content a {
    color: #64b5c6;
    text-decoration: none;
}

.alert-content a:hover {
    text-decoration: underline;
}

/* Form Groups */
.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.form-group label i {
    color: #64b5c6;
}

.required {
    color: #e74c3c;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(100, 160, 180, 0.2);
    border-radius: 10px;
    color: #ffffff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: rgba(100, 160, 180, 0.5);
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.1);
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: rgba(255, 255, 255, 0.35);
}

.form-input.error {
    border-color: #e74c3c;
}

.input-hint {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.4);
    margin-top: 0.4rem;
}

.error-msg {
    font-size: 0.75rem;
    color: #e74c3c;
    margin-top: 0.35rem;
    display: block;
}

/* Payment Options */
.payment-options {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.payment-option {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(100, 160, 180, 0.15);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-option:hover {
    border-color: rgba(100, 160, 180, 0.3);
    background: rgba(100, 160, 180, 0.05);
}

.payment-option.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.payment-option input {
    display: none;
}

.payment-option input:checked + .option-content + .check-mark {
    opacity: 1;
    transform: scale(1);
}

.payment-option input:checked ~ .option-content {
    color: #64b5c6;
}

.payment-option:has(input:checked) {
    border-color: rgba(100, 160, 180, 0.5);
    background: rgba(100, 160, 180, 0.08);
}

.option-content {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.option-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.option-icon.wallet {
    background: rgba(241, 196, 15, 0.15);
    color: #f1c40f;
}

.option-icon.gateway {
    background: rgba(52, 152, 219, 0.15);
    color: #3498db;
}

.option-info {
    display: flex;
    flex-direction: column;
}

.option-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #ffffff;
}

.option-status {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
}

.option-status.error {
    color: #e74c3c;
}

.check-mark {
    width: 24px;
    height: 24px;
    background: #64b5c6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1a2535;
    font-size: 0.7rem;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.2s ease;
}

/* Checkout Button */
.checkout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem;
    background: linear-gradient(135deg, #64b5c6 0%, #4a9eb0 100%);
    border: none;
    border-radius: 12px;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.checkout-btn:hover {
    background: linear-gradient(135deg, #72c3d4 0%, #58acbe 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(100, 160, 180, 0.3);
}

.btn-price {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
}

/* Security Note */
.security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.4);
}

.security-note i {
    color: #2ecc71;
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.9) 0%, rgba(25, 35, 48, 0.85) 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.1);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.1) 0%, rgba(100, 160, 180, 0.05) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 2.5rem;
    color: rgba(100, 160, 180, 0.5);
}

.empty-cart h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}

.empty-cart p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0 0 1.5rem 0;
}

.shop-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #64b5c6 0%, #4a9eb0 100%);
    color: #ffffff;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.shop-btn:hover {
    background: linear-gradient(135deg, #72c3d4 0%, #58acbe 100%);
    transform: translateY(-2px);
    color: #ffffff;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1rem;
}

.modal-overlay.show {
    display: flex;
}

.modal-box {
    width: 100%;
    max-width: 450px;
    background: linear-gradient(135deg, #1e2a38 0%, #1a2535 100%);
    border-radius: 20px;
    border: 1px solid rgba(100, 160, 180, 0.2);
    overflow: hidden;
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-header {
    position: relative;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(241, 196, 15, 0.15) 0%, rgba(241, 196, 15, 0.05) 100%);
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    text-align: center;
}

.modal-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
}

.modal-icon.warning {
    background: rgba(241, 196, 15, 0.2);
    color: #f1c40f;
    font-size: 1.25rem;
}

.modal-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 32px;
    height: 32px;
    border: none;
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.6);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.modal-body {
    padding: 1.5rem;
    text-align: center;
}

.modal-illustration {
    font-size: 4rem;
    color: #64b5c6;
    margin-bottom: 1rem;
}

.modal-message {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}

.modal-submessage {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0 0 1.25rem 0;
}

.requirements-box {
    background: rgba(100, 160, 180, 0.08);
    border: 1px solid rgba(100, 160, 180, 0.15);
    border-radius: 12px;
    padding: 1rem;
    text-align: left;
}

.requirements-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64b5c6;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.requirements-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirements-list li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.7);
    padding: 0.35rem 0;
}

.requirements-list li i {
    color: #2ecc71;
    font-size: 0.7rem;
}

.modal-footer {
    display: flex;
    gap: 0.75rem;
    padding: 1rem 1.5rem 1.5rem;
}

.modal-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-btn.secondary {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
}

.modal-btn.secondary:hover {
    background: rgba(255, 255, 255, 0.15);
}

.modal-btn.primary {
    background: linear-gradient(135deg, #64b5c6 0%, #4a9eb0 100%);
    color: #ffffff;
}

.modal-btn.primary:hover {
    background: linear-gradient(135deg, #72c3d4 0%, #58acbe 100%);
}

/* Responsive */
@media (max-width: 992px) {
    .cart-container {
        grid-template-columns: 1fr;
    }
    
    .summary-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .header-content {
        flex-direction: column;
    }
    
    .cart-item {
        flex-direction: column;
    }
    
    .item-image {
        width: 100%;
        height: 150px;
    }
    
    .item-details {
        flex-direction: column;
    }
    
    .item-actions {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .cart-page {
        padding: 1rem 0.5rem;
    }
    
    .cart-item {
        padding: 1rem;
    }
    
    .item-actions {
        gap: 0.5rem;
    }
    
    .quantity-control {
        order: 3;
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
function updateQty(btn, change) {
    const input = btn.parentElement.querySelector('.qty-input');
    let value = parseInt(input.value) + change;
    if (value < 1) value = 1;
    input.value = value;
}

function showRobloxModal() {
    document.getElementById('robloxModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeRobloxModal() {
    document.getElementById('robloxModal').classList.remove('show');
    document.body.style.overflow = '';
}

function focusRobloxField() {
    closeRobloxModal();
    setTimeout(() => {
        const field = document.getElementById('roblox_username');
        field.focus();
        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 300);
}

document.getElementById('checkoutBtn').addEventListener('click', function(e) {
    const robloxUsername = document.getElementById('roblox_username').value.trim();
    
    if (!robloxUsername) {
        e.preventDefault();
        showRobloxModal();
        return false;
    }
    
    if (robloxUsername.length < 3 || robloxUsername.length > 20) {
        e.preventDefault();
        showToast('Roblox username must be 3-20 characters', 'error');
        document.getElementById('roblox_username').focus();
        return false;
    }
    
    if (!/^[a-zA-Z0-9_]+$/.test(robloxUsername)) {
        e.preventDefault();
        showToast('Username can only contain letters, numbers, and underscores', 'error');
        document.getElementById('roblox_username').focus();
        return false;
    }
});

// Close modal on overlay click
document.getElementById('robloxModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRobloxModal();
    }
});

// Close modal on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRobloxModal();
    }
});

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'error' ? 'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)' : 'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)'};
        color: white;
        border-radius: 10px;
        font-weight: 500;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    toast.innerHTML = `<i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} me-2"></i>${message}`;
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    `;
    document.head.appendChild(style);
    document.body.appendChild(toast);
    
    setTimeout(() => toast.remove(), 3000);
}
</script>
@endsection
