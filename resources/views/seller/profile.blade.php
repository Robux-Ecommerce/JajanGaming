@extends('layouts.app')

@section('title', 'Profil Seller - JajanGaming')

@section('content')
<main style="padding: 2rem 0; background: #0a1218; min-height: calc(100vh - 70px);">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
        <h1 style="color: #64a0b4; font-size: 2rem; margin-bottom: 2rem;">
            <i class="fas fa-cog"></i> Pengaturan Profil
        </h1>

        <div style="background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 12px; padding: 2rem;">
            @if(session('success'))
                <div style="background: rgba(76, 175, 80, 0.15); border-left: 4px solid #4caf50; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Nama Toko *</label>
                    <input type="text" name="name" value="{{ old('name', $seller->name) }}" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $seller->email) }}" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Deskripsi Toko</label>
                    <textarea name="description" rows="4"
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px; font-family: inherit;">{{ old('description', $seller->description) }}</textarea>
                </div>

                <button type="submit" style="background: linear-gradient(135deg, #64a0b4 0%, #5a8fa8 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Change Password -->
        <div style="background: rgba(30, 45, 60, 0.6); border: 1px solid rgba(100, 160, 180, 0.15); border-radius: 12px; padding: 2rem; margin-top: 2rem;">
            <h3 style="color: #c9a856; margin-top: 0; margin-bottom: 1.5rem;">Ubah Kata Sandi</h3>

            <form action="{{ route('seller.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Kata Sandi Saat Ini *</label>
                    <input type="password" name="current_password" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Kata Sandi Baru *</label>
                    <input type="password" name="password" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; color: #b0b0b0; font-weight: 500; margin-bottom: 0.5rem;">Konfirmasi Kata Sandi *</label>
                    <input type="password" name="password_confirmation" required
                        style="width: 100%; background: rgba(15, 20, 30, 0.6); border: 1px solid rgba(100, 160, 180, 0.2); color: #e0e0e0; padding: 0.75rem 1rem; border-radius: 8px;">
                </div>

                <button type="submit" style="background: linear-gradient(135deg, #c9a856 0%, #b8954a 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-key me-2"></i>Ubah Kata Sandi
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
