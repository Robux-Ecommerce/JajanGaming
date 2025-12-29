@extends('layouts.app')

@section('title', 'Produk Saya - Seller')

@section('content')
<main style="padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="color: #64a0b4; font-size: 2rem; margin: 0;">
                <i class="fas fa-cube"></i> Produk Saya
            </h1>
            <a href="{{ route('seller.products.create') }}" style="background: linear-gradient(135deg, #64a0b4 0%, #5a8fa8 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-plus me-2"></i>Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div style="background: rgba(76, 175, 80, 0.15); border-left: 4px solid #4caf50; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: rgba(100, 160, 180, 0.1); border-bottom: 1px solid rgba(100, 160, 180, 0.15);">
                            <th style="padding: 1rem; text-align: left; color: #64a0b4; font-weight: 600;">Produk</th>
                            <th style="padding: 1rem; text-align: left; color: #64a0b4; font-weight: 600;">Game</th>
                            <th style="padding: 1rem; text-align: center; color: #64a0b4; font-weight: 600;">Harga</th>
                            <th style="padding: 1rem; text-align: center; color: #64a0b4; font-weight: 600;">Stok</th>
                            <th style="padding: 1rem; text-align: center; color: #64a0b4; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr style="border-bottom: 1px solid rgba(100, 160, 180, 0.1); color: #e0e0e0;">
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                        @else
                                            <div style="width: 50px; height: 50px; border-radius: 8px; background: rgba(100, 160, 180, 0.1); display: flex; align-items: center; justify-content: center; color: #64a0b4;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div style="font-weight: 600;">{{ $product->name }}</div>
                                            <small style="color: #999;">ID: {{ $product->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="color: #64a0b4;">{{ $product->game_name }}</span>
                                    <br>
                                    <small style="color: #999; text-transform: capitalize;">{{ $product->game_type }}</small>
                                </td>
                                <td style="padding: 1rem; text-align: center;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td style="padding: 1rem; text-align: center;">
                                    <span style="background: {{ $product->quantity > 0 ? 'rgba(76, 175, 80, 0.2)' : 'rgba(244, 67, 54, 0.2)' }}; color: {{ $product->quantity > 0 ? '#4caf50' : '#f44336' }}; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                                        {{ $product->quantity }} unit
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <a href="{{ route('seller.products.edit', $product) }}" style="color: #64a0b4; text-decoration: none; margin-right: 1rem; font-weight: 600;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin hapus produk ini?')" style="background: none; border: none; color: #ff6b6b; cursor: pointer; font-weight: 600;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem;">
                {{ $products->links() }}
            </div>
        @else
            <div style="background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 12px; padding: 3rem; text-align: center; color: #b0b0b0;">
                <i class="fas fa-cube fa-3x" style="color: rgba(100, 160, 180, 0.3); margin-bottom: 1rem;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 1rem;">Anda belum memiliki produk</p>
                <p style="color: #999; margin-bottom: 2rem;">Mulai jual dengan menambahkan produk pertama Anda</p>
                <a href="{{ route('seller.products.create') }}" style="background: linear-gradient(135deg, #64a0b4 0%, #5a8fa8 100%); color: white; padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                </a>
            </div>
        @endif
    </div>
</main>
@endsection
