@extends('layouts.app')

@section('title', 'Pesanan Saya - JajanGaming')

@section('content')
<style>
    .orders-page {
        background: linear-gradient(180deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(30, 45, 60, 0.95) 0%, rgba(20, 35, 50, 0.95) 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        backdrop-filter: blur(20px);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 8px 25px rgba(100, 160, 180, 0.3);
    }

    .page-title {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
        margin: 0;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Order Cards */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .order-card {
        background: linear-gradient(145deg, rgba(30, 45, 60, 0.9) 0%, rgba(25, 38, 52, 0.95) 100%);
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.12);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .order-card:hover {
        transform: translateY(-5px);
        border-color: rgba(100, 160, 180, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.75rem;
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-id-section {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .order-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(100, 160, 180, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64a0b4;
    }

    .order-number {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .order-status {
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-status.completed {
        background: linear-gradient(135deg, rgba(111, 207, 111, 0.2) 0%, rgba(111, 207, 111, 0.1) 100%);
        color: #6fcf6f;
        border: 1px solid rgba(111, 207, 111, 0.3);
    }

    .order-status.pending {
        background: linear-gradient(135deg, rgba(245, 192, 106, 0.2) 0%, rgba(245, 192, 106, 0.1) 100%);
        color: #f5c06a;
        border: 1px solid rgba(245, 192, 106, 0.3);
    }

    .order-status.processing {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(100, 160, 180, 0.1) 100%);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.3);
    }

    .order-status.cancelled {
        background: linear-gradient(135deg, rgba(232, 122, 118, 0.2) 0%, rgba(232, 122, 118, 0.1) 100%);
        color: #e87a76;
        border: 1px solid rgba(232, 122, 118, 0.3);
    }

    .order-total {
        color: #6fcf6f;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .order-card-body {
        padding: 1.75rem;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 2rem;
    }

    /* Order Items Section */
    .order-items-section h6 {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 14px;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(100, 160, 180, 0.08);
        transition: all 0.3s ease;
    }

    .order-item:hover {
        background: rgba(0, 0, 0, 0.3);
        border-color: rgba(100, 160, 180, 0.2);
    }

    .item-info h6 {
        color: #ffffff;
        font-weight: 600;
        font-size: 1rem;
        margin: 0 0 0.25rem 0;
    }

    .item-info small {
        color: rgba(255, 255, 255, 0.45);
        font-size: 0.8rem;
    }

    .item-price-section {
        text-align: right;
    }

    .item-qty {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }

    .item-price {
        color: #64a0b4;
        font-weight: 700;
        font-size: 1rem;
    }

    .btn-rate {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 193, 7, 0.1) 100%);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.3);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-rate:hover {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.35) 0%, rgba(255, 193, 7, 0.2) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }

    /* Order Details Section */
    .order-details-section {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .detail-value {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .payment-badge.wallet {
        background: rgba(100, 160, 180, 0.15);
        color: #64a0b4;
    }

    .payment-badge.gateway {
        background: rgba(111, 207, 111, 0.15);
        color: #6fcf6f;
    }

    .notes-box {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 0.85rem 1rem;
        border: 1px solid rgba(100, 160, 180, 0.08);
    }

    .notes-box small {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .btn-view-details {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(100, 160, 180, 0.1) 100%);
        color: #64a0b4;
        border: 1px solid rgba(100, 160, 180, 0.25);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
        width: 100%;
    }

    .btn-view-details:hover {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.35) 0%, rgba(100, 160, 180, 0.2) 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.2);
    }

    /* Pagination */
    .pagination-info {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background: linear-gradient(145deg, rgba(30, 45, 60, 0.6) 0%, rgba(25, 38, 52, 0.6) 100%);
        border-radius: 24px;
        border: 2px dashed rgba(100, 160, 180, 0.2);
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        border-radius: 24px;
        background: rgba(100, 160, 180, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-icon i {
        font-size: 3rem;
        color: rgba(100, 160, 180, 0.4);
    }

    .empty-state h3 {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    .btn-shop {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
    }

    .btn-shop:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(100, 160, 180, 0.4);
        color: white;
    }

    /* Rating Modal */
    .modal-content {
        background: linear-gradient(145deg, #1e2d3c 0%, #15222e 100%);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 20px;
    }

    .modal-header {
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
        padding: 1.25rem 1.5rem;
    }

    .modal-title {
        color: #ffffff;
        font-weight: 700;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-body .form-label {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    .modal-body .form-control {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: #ffffff;
        border-radius: 10px;
    }

    .modal-body .form-control:focus {
        border-color: #64a0b4;
        box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.15);
    }

    .modal-footer {
        border-top: 1px solid rgba(100, 160, 180, 0.1);
        padding: 1rem 1.5rem;
    }

    .rating-input .stars {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.2);
        cursor: pointer;
        display: flex;
        gap: 0.5rem;
    }

    .rating-input .stars i {
        transition: all 0.2s ease;
    }

    .rating-input .stars i:hover,
    .rating-input .stars i.active,
    .rating-input .stars i.filled {
        color: #ffc107;
        transform: scale(1.1);
    }

    @media (max-width: 992px) {
        .order-card-body {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .orders-page {
            padding: 1rem;
        }

        .page-header {
            flex-direction: column;
            text-align: center;
            padding: 1.5rem;
        }

        .page-header-left {
            flex-direction: column;
        }

        .order-card-header {
            flex-direction: column;
            text-align: center;
        }

        .order-id-section {
            flex-direction: column;
        }

        .order-card-body {
            padding: 1.25rem;
        }
    }

    /* Scrollbar Styling - Match Sidebar */
    .page-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .page-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .page-sidebar::-webkit-scrollbar-thumb {
        background: rgba(100, 160, 180, 0.2);
        border-radius: 3px;
    }

    .page-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(100, 160, 180, 0.35);
    }

    .page-sidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(100, 160, 180, 0.2) transparent;
    }
</style>

<div class="orders-page">
    <div class="container">
        <div class="page-header">
            <div class="page-header-left">
                <div class="page-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <h1 class="page-title">Pesanan Saya</h1>
                    <p class="page-subtitle">Lacak dan kelola pembelian Anda</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        @if($orders->count() > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-card-header">
                            <div class="order-id-section">
                                <div class="order-icon">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <span class="order-number">Order #{{ $order->order_number }}</span>
                            </div>
                            <span class="order-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            <span class="order-total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="order-card-body">
                            <div class="order-items-section">
                                <h6>Order Items:</h6>
                                @foreach($order->orderItems as $item)
                                    <div class="order-item">
                                        <div class="item-info">
                                            <h6>{{ $item->product->name }}</h6>
                                            <small>{{ $item->product->game_name }} - {{ $item->product->game_type }}</small>
                                            @if($order->status === 'completed')
                                                <br>
                                                <button class="btn-rate" onclick="openRatingModal({{ $item->product->id }}, {{ $order->id }}, '{{ $item->product->name }}')">
                                                    <i class="fas fa-star"></i> Beri Rating
                                                </button>
                                            @endif
                                        </div>
                                        <div class="item-price-section">
                                            <div class="item-qty">{{ $item->quantity }}x</div>
                                            <div class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="order-details-section">
                                <div class="detail-row">
                                    <span class="detail-label">Metode Pembayaran</span>
                                    @if($order->payment_method === 'wallet')
                                        <span class="payment-badge wallet">
                                            <i class="fas fa-wallet"></i> DompetKu
                                        </span>
                                    @else
                                        <span class="payment-badge gateway">
                                            <i class="fas fa-credit-card"></i> Gateway
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="detail-row">
                                    <span class="detail-label">Tanggal Pesanan</span>
                                    <span class="detail-value">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </div>
                                
                                @if($order->notes)
                                    <div>
                                        <span class="detail-label">Catatan:</span>
                                        <div class="notes-box">
                                            <small>{{ $order->notes }}</small>
                                        </div>
                                    </div>
                                @endif
                                
                                <a href="{{ route('orders.show', $order) }}" class="btn-view-details">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination-wrapper">
                <div>
                    <div class="pagination-info">
                        Menampilkan {{ $orders->firstItem() }} hingga {{ $orders->lastItem() }} dari {{ $orders->total() }} hasil
                    </div>
                    {{ $orders->links('pagination.bootstrap-5') }}
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3>Belum Ada Pesanan</h3>
                <p>Pesanan Anda akan muncul di sini setelah Anda melakukan pembelian</p>
                <a href="{{ route('home') }}" class="btn-shop">
                    <i class="fas fa-shopping-bag"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">
                    <i class="fas fa-star me-2"></i>Beri Rating Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm">
                    @csrf
                    <input type="hidden" id="rating_product_id" name="product_id">
                    <input type="hidden" id="rating_order_id" name="order_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Produk:</label>
                        <p class="fw-bold text-white" id="rating_product_name"></p>
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
                        <label for="review" class="form-label">Ulasan (Opsional)</label>
                        <textarea class="form-control" id="review" name="review" rows="3" 
                                  placeholder="Bagikan pengalaman Anda dengan produk ini..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="submitRating()">
                    <i class="fas fa-star me-1"></i>Kirim Rating
                </button>
            </div>
        </div>
    </div>
</div>

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
        alert('Kesalahan terjadi saat mengirim rating');
    });
}
</script>
@endsection
