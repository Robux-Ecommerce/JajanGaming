@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container mt-5 pt-4">
    <div class="wishlist-header mb-5">
        <h1 class="display-5 mb-2">
            <i class="fas fa-heart" style="color: #ff3c5a;"></i> My Wishlist
        </h1>
        <p class="text-muted">{{ $wishlist->total() }} item{{ $wishlist->total() !== 1 ? 's' : '' }} saved</p>
    </div>

    @if ($wishlist->count() > 0)
        <div class="wishlist-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            @foreach ($wishlist as $item)
                <div class="wishlist-card" style="
                    border: 1px solid rgba(0, 212, 170, 0.2);
                    border-radius: 12px;
                    overflow: hidden;
                    background: rgba(26, 26, 46, 0.5);
                    backdrop-filter: blur(10px);
                    transition: all 0.3s ease;
                    display: flex;
                    flex-direction: column;
                " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0, 212, 170, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    
                    <!-- Product Image -->
                    <div style="
                        width: 100%;
                        height: 180px;
                        overflow: hidden;
                        background: rgba(0, 0, 0, 0.3);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        position: relative;
                    ">
                        @if ($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                            ">
                        @else
                            <div style="text-align: center; color: #999;">
                                <i class="fas fa-image" style="font-size: 2rem;"></i>
                                <p>No Image</p>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div style="padding: 1rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <h5 style="
                            margin: 0 0 0.5rem 0;
                            color: #fff;
                            font-weight: 600;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        ">
                            <a href="{{ route('product.show', $item->product->id) }}" style="color: #00d4aa; text-decoration: none; transition: color 0.3s;">
                                {{ $item->product->name }}
                            </a>
                        </h5>
                        
                        <p style="margin: 0.25rem 0; color: #999; font-size: 0.85rem;">
                            {{ $item->product->game_name }}
                        </p>

                        <!-- Price & Actions -->
                        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(0, 212, 170, 0.1);">
                            <div style="font-size: 1.2rem; color: #00d4aa; font-weight: 700; margin-bottom: 0.75rem;">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                                <form action="{{ route('cart.add') }}" method="POST" style="width: 100%;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <button type="submit" class="btn" style="
                                        width: 100%;
                                        padding: 0.5rem;
                                        background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
                                        color: #fff;
                                        border: none;
                                        border-radius: 6px;
                                        font-weight: 600;
                                        font-size: 0.85rem;
                                        cursor: pointer;
                                        transition: all 0.3s;
                                    " onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                                        <i class="fas fa-cart-plus me-1"></i>Cart
                                    </button>
                                </form>

                                <button class="btn-remove-wishlist" data-wishlist-id="{{ $item->id }}" style="
                                    padding: 0.5rem;
                                    background: rgba(255, 60, 90, 0.2);
                                    color: #ff3c5a;
                                    border: 1px solid #ff3c5a;
                                    border-radius: 6px;
                                    font-weight: 600;
                                    font-size: 0.85rem;
                                    cursor: pointer;
                                    transition: all 0.3s;
                                " onmouseover="this.style.background='rgba(255, 60, 90, 0.3)'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='rgba(255, 60, 90, 0.2)'; this.style.transform='scale(1)';">
                                    <i class="fas fa-trash me-1"></i>Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($wishlist->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $wishlist->links() }}
            </div>
        @endif
    @else
        <!-- Empty Wishlist -->
        <div style="
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(0, 212, 170, 0.05);
            border: 2px dashed rgba(0, 212, 170, 0.2);
            border-radius: 12px;
            margin-top: 3rem;
        ">
            <i class="far fa-heart" style="font-size: 3rem; color: #ff3c5a; margin-bottom: 1rem; display: block;"></i>
            <h3 style="color: #fff; margin-bottom: 0.5rem;">Your Wishlist is Empty</h3>
            <p style="color: #999; margin-bottom: 1.5rem;">Start adding items to your wishlist!</p>
            <a href="{{ route('browse') }}" class="btn" style="
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
                color: #fff;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.3s;
            " onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                <i class="fas fa-shopping-bag me-2"></i>Browse Products
            </a>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.btn-remove-wishlist');
        
        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const wishlistId = this.getAttribute('data-wishlist-id');
                
                if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                    fetch('{{ route("wishlist.destroy", ":id") }}'.replace(':id', wishlistId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload page
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing item from wishlist');
                    });
                }
            });
        });
    });
</script>
@endsection
