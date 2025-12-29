@extends('layouts.app')

@section('title', 'Edit Produk - Seller')

@section('content')
<main style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
        <h1 style="color: #64a0b4; font-size: 2rem; margin-bottom: 2rem;">
            <i class="fas fa-edit"></i> Edit Produk
        </h1>

        <div style="background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 12px; padding: 2rem;">
            @if($errors->any())
                <div style="background: rgba(244, 67, 54, 0.15); border-left: 4px solid #f44336; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Deskripsi *</label>
                    <textarea name="description" rows="5" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem; font-family: inherit;">{{ old('description', $product->description) }}</textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Nama Game *</label>
                    <input type="text" name="game_name" value="{{ old('game_name', $product->game_name) }}" required
                        placeholder="Contoh: Mobile Legends, Free Fire, PUBG Mobile"
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Tipe Item *</label>
                        <select name="game_type" required
                            style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                            <option value="">Pilih Tipe</option>
                            <option value="diamond" {{ old('game_type', $product->game_type) == 'diamond' ? 'selected' : '' }}>Diamond</option>
                            <option value="coins" {{ old('game_type', $product->game_type) == 'coins' ? 'selected' : '' }}>Coins</option>
                            <option value="gems" {{ old('game_type', $product->game_type) == 'gems' ? 'selected' : '' }}>Gems</option>
                            <option value="robux" {{ old('game_type', $product->game_type) == 'robux' ? 'selected' : '' }}>Robux</option>
                            <option value="voucher" {{ old('game_type', $product->game_type) == 'voucher' ? 'selected' : '' }}>Voucher</option>
                            <option value="other" {{ old('game_type', $product->game_type) == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required
                            style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->quantity) }}" min="0" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Gambar Produk</label>
                    @if($product->image)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; border-radius: 8px; border: 1px solid rgba(100, 160, 180, 0.2);">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-size: 1rem;">
                    <small style="color: #999; display: block; margin-top: 0.5rem;">JPG, PNG, GIF (maks 2MB) - Kosongkan jika tidak ingin mengubah</small>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="background: linear-gradient(135deg, #64a0b4 0%, #5a8fa8 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('seller.products.index') }}" style="background: rgba(100, 160, 180, 0.1); color: #64a0b4; padding: 0.75rem 2rem; border: 1px solid rgba(100, 160, 180, 0.2); border-radius: 8px; text-decoration: none; font-weight: 600;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
