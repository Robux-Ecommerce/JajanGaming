@extends('layouts.app')

@section('title', 'Profil Saya - JajanGaming')

@section('content')
<style>
    .profile-wrapper {
        max-width: 1200px;
        margin: 70px auto 0;
        padding: 2rem;
        min-height: 100vh;
        background: #0a1218;
    }

    .profile-header {
        background: linear-gradient(135deg, rgba(30, 45, 60, 0.95) 0%, rgba(20, 35, 50, 0.95) 100%);
        padding: 2.5rem;
        border-radius: 15px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .profile-header h1 {
        color: #64a0b4;
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }

    .profile-card {
        background: rgba(30, 45, 60, 0.6);
        border: 1px solid rgba(100, 160, 180, 0.15);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: #e0e0e0;
    }

    .profile-card h3 {
        color: #64a0b4;
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label {
        color: #b0b0b0;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control {
        background: rgba(15, 20, 30, 0.6);
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: #e0e0e0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background: rgba(15, 20, 30, 0.8);
        border-color: #64a0b4;
        color: #e0e0e0;
        box-shadow: 0 0 15px rgba(100, 160, 180, 0.2);
    }

    .form-control::placeholder {
        color: #666;
    }

    .btn-primary {
        background: linear-gradient(135deg, #64a0b4 0%, #5a8fa8 100%);
        border: none;
        color: #fff;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #7ab5c4 0%, #64a0b4 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(100, 160, 180, 0.3);
        color: #fff;
    }

    .btn-warning {
        background: linear-gradient(135deg, #c9a856 0%, #b8954a 100%);
        border: none;
        color: #fff;
        padding: 0.75rem 2rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #d9b866 0%, #c9a856 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(201, 168, 86, 0.3);
        color: #fff;
    }

    .alert {
        border: none;
        border-radius: 8px;
        color: #fff;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(76, 175, 80, 0.15);
        border-left: 4px solid #4caf50;
    }

    .alert-danger {
        background: rgba(244, 67, 54, 0.15);
        border-left: 4px solid #f44336;
    }

    .photo-preview {
        text-align: center;
        padding: 1.5rem;
        background: rgba(100, 160, 180, 0.05);
        border-radius: 8px;
        margin-top: 1rem;
    }

    .photo-preview img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid rgba(100, 160, 180, 0.3);
        object-fit: cover;
    }

    .stat-box {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.15);
        padding: 1.5rem;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 1rem;
    }

    .stat-box h4 {
        color: #64a0b4;
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0.5rem 0;
    }

    .stat-box p {
        color: #b0b0b0;
        margin: 0;
        font-size: 0.9rem;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .invalid-feedback {
        color: #ff6b6b;
        font-size: 0.85rem;
        display: block;
    }

    .w-100 {
        width: 100%;
    }

    @media (max-width: 768px) {
        .profile-wrapper {
            padding: 1rem;
            margin-left: 0;
        }

        .profile-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .profile-header h1 {
            font-size: 1.5rem;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-wrapper">
    <div class="profile-header">
        <h1>
            <i class="fas fa-user"></i>Profil Saya
        </h1>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
    </div>

    <div class="profile-grid">
        <!-- Kolom Utama -->
        <div>
            <!-- Informasi Profil -->
            <div class="profile-card">
                <h3><i class="fas fa-user-circle"></i>Informasi Profil</h3>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 2rem;">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                               id="profile_photo" name="profile_photo" accept="image/*">
                        <small class="text-muted d-block mt-2">JPG, PNG, GIF (maks 2MB)</small>
                        
                        <div class="photo-preview">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                     alt="Profile Photo">
                            @else
                                <div style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; background: rgba(100, 160, 180, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user fa-3x" style="color: #64a0b4;"></i>
                                </div>
                            @endif
                        </div>
                        @error('profile_photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-row">
                        <div>
                            <label for="name" class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="form-label">Alamat Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="description" class="form-label">Tentang Saya</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Ceritakan tentang diri Anda...">{{ old('description', $user->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">Maksimal 1000 karakter.</small>
                    </div>

                    <div class="info-row">
                        <div>
                            <label class="form-label">Peran</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                        </div>
                        
                        <div>
                            <label class="form-label">Saldo Dompet</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}" readonly>
                        </div>
                    </div>

                    <div class="info-row">
                        <div>
                            <label class="form-label">Anggota Sejak</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('M d, Y') }}" readonly>
                        </div>
                        
                        <div>
                            <label class="form-label">Terakhir Diperbarui</label>
                            <input type="text" class="form-control" value="{{ $user->updated_at->format('M d, Y H:i') }}" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Perbarui Profil
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar Kanan -->
        <div>
            <!-- Ubah Password Card -->
            <div class="profile-card">
                <h3><i class="fas fa-key"></i>Ubah Kata Sandi</h3>
                
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="current_password" class="form-label">Kata Sandi Saat Ini *</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="password" class="form-label">Kata Sandi Baru *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru *</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-2"></i>Ubah Kata Sandi
                    </button>
                </form>
            </div>

            <!-- Statistik Akun Card -->
            <div class="profile-card">
                <h3><i class="fas fa-chart-bar"></i>Statistik Akun</h3>
                
                <div class="stat-box">
                    <h4>{{ $user->orders()->count() }}</h4>
                    <p>Total Pesanan</p>
                </div>
                
                <div class="stat-box">
                    <h4>{{ $user->orders()->where('status', 'completed')->count() }}</h4>
                    <p>Selesai</p>
                </div>
                
                <div class="stat-box">
                    <h4>{{ $user->orders()->where('status', 'pending')->count() }}</h4>
                    <p>Tertunda</p>
                </div>
                
                <div class="stat-box" style="margin-bottom: 0;">
                    <h4>{{ $user->orders()->where('status', 'cancelled')->count() }}</h4>
                    <p>Dibatalkan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
