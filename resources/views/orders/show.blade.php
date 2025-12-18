@extends('layouts.app')

@section('content')
<div class="order-detail-page">
    <!-- Include Sidebar -->
    @include('partials.sidebar')
    
    <!-- Main Content -->
    <div class="order-detail-content">
        <!-- Page Header -->
        <div class="page-header">
            <a href="{{ route('orders.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-info">
                <h1 class="page-title">
                    <i class="fas fa-receipt"></i>
                    Order Details
                </h1>
                <p class="page-subtitle">Order #{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Order Summary Card -->
        <div class="order-summary-card">
            <div class="summary-header">
                <div class="order-id">
                    <span class="label">Order Number</span>
                    <span class="value">#{{ $order->order_number ?? 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="order-status">
                    @php
                        $statusConfig = [
                            'pending' => ['class' => 'status-pending', 'icon' => 'fa-clock', 'text' => 'Pending'],
                            'processing' => ['class' => 'status-processing', 'icon' => 'fa-spinner fa-spin', 'text' => 'Processing'],
                            'completed' => ['class' => 'status-completed', 'icon' => 'fa-check-circle', 'text' => 'Completed'],
                            'cancelled' => ['class' => 'status-cancelled', 'icon' => 'fa-times-circle', 'text' => 'Cancelled'],
                        ];
                        $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                    @endphp
                    <span class="status-badge {{ $status['class'] }}">
                        <i class="fas {{ $status['icon'] }}"></i>
                        {{ $status['text'] }}
                    </span>
                </div>
            </div>
            <div class="summary-body">
                <div class="summary-row">
                    <div class="summary-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="item-content">
                            <span class="item-label">Order Date</span>
                            <span class="item-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-credit-card"></i>
                        <div class="item-content">
                            <span class="item-label">Payment Method</span>
                            <span class="item-value payment-badge">
                                <i class="fas fa-wallet"></i> E-Wallet
                            </span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <div class="item-content">
                            <span class="item-label">Total Amount</span>
                            <span class="item-value total-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="detail-grid">
            <!-- Order Items Column -->
            <div class="items-column">
                <div class="section-card">
                    <div class="section-header">
                        <h3>
                            <i class="fas fa-shopping-bag"></i>
                            Order Items
                        </h3>
                        <span class="item-count">{{ $order->orderItems ? $order->orderItems->count() : 0 }} item(s)</span>
                    </div>
                    <div class="section-body">
                        @forelse($order->orderItems ?? [] as $item)
                        <div class="product-item">
                            <div class="product-image">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Product' }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-gamepad"></i>
                                    </div>
                                @endif
                                <span class="quantity-badge">x{{ $item->quantity }}</span>
                            </div>
                            <div class="product-details">
                                <h4 class="product-name">{{ $item->product->name ?? 'Product Unavailable' }}</h4>
                                <p class="product-seller">
                                    <i class="fas fa-store"></i>
                                    {{ $item->product->seller->name ?? 'Unknown Seller' }}
                                </p>
                                <div class="product-pricing">
                                    <span class="unit-price">Rp {{ number_format($item->price, 0, ',', '.') }} / unit</span>
                                    <span class="subtotal">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @if($order->status == 'completed')
                            <div class="product-rating">
                                @php
                                    $existingRating = App\Models\Rating::where('user_id', Auth::id())
                                        ->where('product_id', $item->product_id)
                                        ->where('order_id', $order->id)
                                        ->first();
                                @endphp
                                @if($existingRating)
                                <div class="rated-badge">
                                    <i class="fas fa-star"></i>
                                    <span>{{ $existingRating->rating }}</span>
                                </div>
                                @else
                                <button type="button" class="rate-btn" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                    <i class="fas fa-star"></i>
                                    Rate
                                </button>
                                @endif
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="empty-items">
                            <i class="fas fa-box-open"></i>
                            <p>No items found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Order Info Column -->
            <div class="info-column">
                <!-- Customer Info -->
                <div class="section-card info-card">
                    <div class="section-header">
                        <h3>
                            <i class="fas fa-user-circle"></i>
                            Customer Info
                        </h3>
                    </div>
                    <div class="section-body">
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-gamepad"></i>
                                Roblox Username
                            </span>
                            <span class="info-value highlight">{{ $order->roblox_username ?? 'Not specified' }}</span>
                        </div>
                        @if($order->notes)
                        <div class="info-row notes-row">
                            <span class="info-label">
                                <i class="fas fa-sticky-note"></i>
                                Notes
                            </span>
                            <span class="info-value notes-value">{{ $order->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="section-card payment-card">
                    <div class="section-header">
                        <h3>
                            <i class="fas fa-file-invoice-dollar"></i>
                            Payment Summary
                        </h3>
                    </div>
                    <div class="section-body">
                        <div class="payment-row">
                            <span class="payment-label">Subtotal</span>
                            <span class="payment-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="payment-row">
                            <span class="payment-label">Discount</span>
                            <span class="payment-value discount">- Rp 0</span>
                        </div>
                        <div class="payment-divider"></div>
                        <div class="payment-row total-row">
                            <span class="payment-label">Total</span>
                            <span class="payment-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="action-buttons">
                    <a href="{{ route('orders.index') }}" class="btn-action btn-secondary-action">
                        <i class="fas fa-arrow-left"></i>
                        Back to Orders
                    </a>
                    @if($order->status == 'completed' && !$existingRating)
                    <button type="button" class="btn-action btn-primary-action" data-bs-toggle="modal" data-bs-target="#ratingModal">
                        <i class="fas fa-star"></i>
                        Rate Products
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating Modal -->
@if($order->status == 'completed')
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-dark">
            <div class="modal-header">
                <div class="modal-title-wrapper">
                    <i class="fas fa-star"></i>
                    <h5 class="modal-title" id="ratingModalLabel">Rate Your Products</h5>
                </div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="ratingForm" method="POST" action="{{ route('ratings.store') }}">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                
                <div class="modal-body">
                    <p class="modal-subtitle">How was your experience with these products?</p>
                    
                    @forelse($order->orderItems ?? [] as $item)
                    <div class="rating-item">
                        <div class="rating-product-info">
                            <div class="rating-product-image">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name ?? 'Product' }}">
                                @else
                                    <div class="no-image-small">
                                        <i class="fas fa-gamepad"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="rating-product-details">
                                <h5>{{ $item->product->name ?? 'Product' }}</h5>
                                <p>{{ $item->product->seller->name ?? 'Unknown Seller' }}</p>
                            </div>
                        </div>
                        
                        <div class="rating-stars-wrapper">
                            <div class="stars-container">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star star-rating" 
                                   data-product-id="{{ $item->product_id }}" 
                                   data-rating="{{ $i }}"></i>
                                @endfor
                            </div>
                            <span class="rating-hint">Click to rate</span>
                        </div>
                        
                        <div class="rating-review">
                            <textarea name="review_{{ $item->product_id }}" 
                                      placeholder="Write your review (optional)..." 
                                      rows="2"></textarea>
                        </div>
                    </div>
                    @empty
                    <p class="text-center" style="color: rgba(255,255,255,0.5);">No items to rate</p>
                    @endforelse
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-modal btn-skip" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Skip
                    </button>
                    <button type="submit" class="btn-modal btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Submit Rating
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
/* ==================== MAIN LAYOUT ==================== */
.order-detail-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
}

.order-detail-content {
    margin-left: 280px;
    padding: 30px 40px;
    min-height: 100vh;
}

/* ==================== PAGE HEADER ==================== */
.page-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.back-btn {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: rgba(100, 160, 180, 0.15);
    border: 1px solid rgba(100, 160, 180, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64a0b4;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(100, 160, 180, 0.25);
    color: #8ecad8;
    transform: translateX(-3px);
}

.header-info {
    flex: 1;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-title i {
    color: #64a0b4;
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.5);
    margin: 5px 0 0 0;
    font-size: 0.95rem;
}

/* ==================== ORDER SUMMARY CARD ==================== */
.order-summary-card {
    background: linear-gradient(145deg, rgba(100, 160, 180, 0.12), rgba(100, 160, 180, 0.05));
    border-radius: 20px;
    border: 1px solid rgba(100, 160, 180, 0.2);
    overflow: hidden;
    margin-bottom: 30px;
}

.summary-header {
    padding: 25px 30px;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(100, 160, 180, 0.15);
}

.order-id .label {
    display: block;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.order-id .value {
    font-size: 1.4rem;
    font-weight: 700;
    color: #64a0b4;
}

.status-badge {
    padding: 10px 20px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-pending {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
    color: #ffc107;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

.status-processing {
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.2), rgba(23, 162, 184, 0.1));
    color: #17a2b8;
    border: 1px solid rgba(23, 162, 184, 0.3);
}

.status-completed {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.status-cancelled {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.summary-body {
    padding: 25px 30px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.summary-item {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.summary-item > i {
    font-size: 1.5rem;
    color: #64a0b4;
    opacity: 0.8;
}

.item-content {
    display: flex;
    flex-direction: column;
}

.item-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    margin-bottom: 3px;
}

.item-value {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
}

.payment-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #64a0b4 !important;
}

.total-value {
    color: #4ade80 !important;
    font-size: 1.1rem !important;
}

/* ==================== DETAIL GRID ==================== */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
}

/* ==================== SECTION CARDS ==================== */
.section-card {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    overflow: hidden;
}

.section-header {
    padding: 20px 25px;
    background: rgba(0, 0, 0, 0.2);
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-header h3 i {
    color: #64a0b4;
}

.item-count {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.5);
    background: rgba(100, 160, 180, 0.15);
    padding: 5px 12px;
    border-radius: 20px;
}

.section-body {
    padding: 20px 25px;
}

/* ==================== PRODUCT ITEMS ==================== */
.product-item {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    margin-bottom: 15px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.product-item:last-child {
    margin-bottom: 0;
}

.product-item:hover {
    background: rgba(0, 0, 0, 0.25);
    border-color: rgba(100, 160, 180, 0.2);
    transform: translateY(-2px);
}

.product-image {
    position: relative;
    width: 80px;
    height: 80px;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.product-image .no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image .no-image i {
    font-size: 2rem;
    color: rgba(100, 160, 180, 0.5);
}

.quantity-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #64a0b4, #4a8898);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 20px;
    border: 2px solid #0f1a24;
}

.product-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.product-name {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 8px 0;
}

.product-seller {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0 0 12px 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.product-seller i {
    color: #64a0b4;
}

.product-pricing {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.unit-price {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.6);
}

.subtotal {
    font-size: 1rem;
    font-weight: 700;
    color: #4ade80;
}

.product-rating {
    display: flex;
    align-items: center;
}

.rated-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 15px;
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
    border-radius: 20px;
    color: #ffc107;
    font-weight: 600;
}

.rate-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 15px;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.2), rgba(100, 160, 180, 0.1));
    border: 1px solid rgba(100, 160, 180, 0.3);
    border-radius: 20px;
    color: #64a0b4;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.rate-btn:hover {
    background: rgba(100, 160, 180, 0.3);
    color: #8ecad8;
}

/* ==================== INFO CARDS ==================== */
.info-column .section-card {
    margin-bottom: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-label i {
    color: #64a0b4;
    width: 20px;
}

.info-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #ffffff;
}

.info-value.highlight {
    color: #64a0b4;
}

.notes-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.notes-value {
    background: rgba(0, 0, 0, 0.2);
    padding: 12px 15px;
    border-radius: 8px;
    width: 100%;
    line-height: 1.5;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.8);
}

/* ==================== PAYMENT CARD ==================== */
.payment-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.payment-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
}

.payment-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #ffffff;
}

.payment-value.discount {
    color: #4ade80;
}

.payment-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(100, 160, 180, 0.3), transparent);
    margin: 15px 0;
}

.total-row {
    padding-top: 15px;
}

.total-row .payment-label {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
}

.total-row .payment-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #4ade80;
}

/* ==================== ACTION BUTTONS ==================== */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary-action {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8);
}

.btn-secondary-action:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transform: translateX(-5px);
}

.btn-primary-action {
    background: linear-gradient(135deg, #64a0b4, #4a8898);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
}

.btn-primary-action:hover {
    background: linear-gradient(135deg, #7ab5c7, #5a98a8);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(100, 160, 180, 0.4);
}

/* ==================== MODAL STYLES ==================== */
.modal-dark .modal-content {
    background: linear-gradient(145deg, #1a2836, #0f1a24);
    border: 1px solid rgba(100, 160, 180, 0.2);
    border-radius: 20px;
}

.modal-dark .modal-header {
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.15), rgba(100, 160, 180, 0.05));
    border-bottom: 1px solid rgba(100, 160, 180, 0.15);
    padding: 20px 25px;
    border-radius: 20px 20px 0 0;
}

.modal-title-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-title-wrapper i {
    font-size: 1.4rem;
    color: #ffc107;
}

.modal-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.modal-close-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-close-btn:hover {
    background: rgba(220, 53, 69, 0.2);
    color: #dc3545;
}

.modal-dark .modal-body {
    padding: 25px;
}

.modal-subtitle {
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: 25px;
    text-align: center;
}

.rating-item {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.06);
}

.rating-item:last-child {
    margin-bottom: 0;
}

.rating-product-info {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.rating-product-image {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
}

.rating-product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.no-image-small {
    width: 100%;
    height: 100%;
    background: rgba(100, 160, 180, 0.15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image-small i {
    font-size: 1.5rem;
    color: rgba(100, 160, 180, 0.5);
}

.rating-product-details h5 {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 5px 0;
}

.rating-product-details p {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

.rating-stars-wrapper {
    text-align: center;
    margin-bottom: 15px;
}

.stars-container {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 8px;
}

.star-rating {
    font-size: 1.8rem;
    color: rgba(255, 255, 255, 0.2);
    cursor: pointer;
    transition: all 0.2s ease;
}

.star-rating:hover {
    transform: scale(1.15);
}

.star-rating.active,
.star-rating.rated {
    color: #ffc107;
}

.rating-hint {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.4);
}

.rating-review textarea {
    width: 100%;
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 12px 15px;
    color: #ffffff;
    font-size: 0.9rem;
    resize: none;
    transition: all 0.3s ease;
}

.rating-review textarea::placeholder {
    color: rgba(255, 255, 255, 0.3);
}

.rating-review textarea:focus {
    outline: none;
    border-color: rgba(100, 160, 180, 0.5);
    background: rgba(0, 0, 0, 0.4);
}

.modal-dark .modal-footer {
    background: rgba(0, 0, 0, 0.2);
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    padding: 20px 25px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    border-radius: 0 0 20px 20px;
}

.btn-modal {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-skip {
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.7);
}

.btn-skip:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

.btn-submit {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #1a1a1a;
}

.btn-submit:hover {
    background: linear-gradient(135deg, #ffcd39, #ffc107);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1200px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .info-column {
        order: -1;
    }
}

@media (max-width: 991px) {
    .order-detail-content {
        margin-left: 0;
        padding: 20px;
    }
    
    .summary-row {
        flex-direction: column;
        gap: 12px;
    }
    
    .summary-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .product-item {
        flex-direction: column;
        text-align: center;
    }
    
    .product-image {
        margin: 0 auto;
    }
    
    .product-pricing {
        flex-direction: column;
        gap: 5px;
    }
    
    .product-rating {
        margin-top: 15px;
        justify-content: center;
    }
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
    const ratings = {};

    starRatings.forEach(star => {
        star.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const rating = parseInt(this.dataset.rating);
            
            console.log(`Star clicked: Product ${productId}, Rating ${rating}`);
            ratings[productId] = rating;
            
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
            
            const productStars = document.querySelectorAll(`[data-product-id="${productId}"]`);
            productStars.forEach(s => {
                s.classList.remove('active');
            });
        });
    });

    // Handle form submission
    const ratingForm = document.getElementById('ratingForm');
    if (ratingForm) {
        ratingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            console.log('Form submitted, ratings:', ratings);
            
            if (Object.keys(ratings).length === 0) {
                alert('Please select at least one rating before submitting.');
                return;
            }
            
            const formData = new FormData(this);
            
            Object.keys(ratings).forEach(productId => {
                formData.append(`rating_${productId}`, ratings[productId]);
            });
            
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
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success';
                    successAlert.style.cssText = 'background: rgba(40,167,69,0.2); color: #4ade80; border: 1px solid rgba(40,167,69,0.3); border-radius: 10px; padding: 15px; margin-bottom: 20px; text-align: center;';
                    successAlert.innerHTML = '<i class="fas fa-check-circle me-2"></i>Thank you! Your rating has been submitted.';
                    
                    document.querySelector('.modal-body').insertBefore(successAlert, document.querySelector('.modal-body').firstChild);
                    
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('ratingModal')).hide();
                        location.reload();
                    }, 2000);
                } else {
                    alert('Error submitting rating. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting rating: ' + error.message);
            });
        });
    }
});
</script>
@endsection
