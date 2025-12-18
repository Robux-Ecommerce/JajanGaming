@extends('layouts.app')

@section('title', 'Profile Settings - JajanGaming')

@section('content')<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'My Profile'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;"><style>
    .profile-page {
        background: linear-gradient(180deg, #121a24 0%, #1a2a38 100%);
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.9) 0%, rgba(26, 42, 56, 0.9) 100%);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(100, 160, 180, 0.12);
        backdrop-filter: blur(10px);
    }

    .page-title {
        color: #ffffff;
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .page-title i { color: #64a0b4; font-size: 1.2rem; }

    .btn-back {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.8rem;
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Profile Layout */
    .profile-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.25rem;
    }

    /* Sidebar */
    .profile-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .profile-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        border-color: rgba(100, 160, 180, 0.2);
    }

    .profile-avatar-section {
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
        background: rgba(0, 0, 0, 0.1);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2rem;
        color: white;
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        border: 3px solid rgba(100, 160, 180, 0.3);
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        margin-bottom: 0.65rem;
    }

    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-badge.admin { background: rgba(232, 122, 118, 0.2); color: #e87a76; }
    .role-badge.seller { background: rgba(245, 192, 106, 0.2); color: #f5c06a; }
    .role-badge.user { background: rgba(100, 160, 180, 0.2); color: #7ab8c8; }

    /* Stats Card */
    .stats-list {
        padding: 1rem;
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(100, 160, 180, 0.06);
    }

    .stat-row:last-child { border-bottom: none; }

    .stat-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
    }

    .stat-value {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .stat-value.highlight { color: #6fcf6f; }

    /* Main Content */
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 14px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
    }

    .form-card-header {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
        background: rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-card-header i {
        color: #64a0b4;
        font-size: 0.9rem;
    }

    .form-card-header h3 {
        color: #ffffff;
        font-size: 0.9rem;
        font-weight: 600;
        margin: 0;
    }

    .form-card-body {
        padding: 1.25rem;
    }

    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        font-weight: 500;
        margin-bottom: 0.4rem;
    }

    .form-control {
        width: 100%;
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(100, 160, 180, 0.15);
        border-radius: 10px;
        padding: 0.65rem 0.85rem;
        color: #ffffff;
        font-size: 0.8rem;
        transition: all 0.25s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: rgba(100, 160, 180, 0.4);
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.1);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .form-control[readonly] {
        background: rgba(0, 0, 0, 0.15);
        color: rgba(255, 255, 255, 0.5);
        cursor: not-allowed;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .form-hint {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.65rem;
        margin-top: 0.35rem;
    }

    .invalid-feedback {
        color: #e87a76;
        font-size: 0.7rem;
        margin-top: 0.3rem;
    }

    /* Photo Upload */
    .photo-upload {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .photo-preview {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(100, 160, 180, 0.1);
        border: 2px solid rgba(100, 160, 180, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-preview i {
        color: rgba(255, 255, 255, 0.3);
        font-size: 1.5rem;
    }

    .photo-input {
        flex: 1;
    }

    /* Buttons */
    .btn-submit {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(100, 160, 180, 0.3);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f5c06a 0%, #d9a64a 100%);
        color: #1a2a38;
    }

    .btn-warning:hover {
        box-shadow: 0 5px 15px rgba(245, 192, 106, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .profile-page { padding: 1rem 0; }
        .page-header { padding: 1rem; flex-direction: column; gap: 0.75rem; }
        .profile-sidebar { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
        .photo-upload { flex-direction: column; text-align: center; }
    }
</style>

<div class="profile-page">
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="page-title">
                <i class="fas fa-user-cog"></i>
                Profile Settings
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        <div class="profile-grid">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-card">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="profile-name">{{ $user->name }}</div>
                        <div class="profile-email">{{ $user->email }}</div>
                        <span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="stats-list">
                        <div class="stat-row">
                            <span class="stat-label">Wallet Balance</span>
                            <span class="stat-value highlight">Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Member Since</span>
                            <span class="stat-value">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Last Updated</span>
                            <span class="stat-value">{{ $user->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="profile-card">
                    <div class="form-card-header">
                        <i class="fas fa-chart-bar"></i>
                        <h3>Account Stats</h3>
                    </div>
                    <div class="stats-list">
                        @if($user->isAdmin())
                        <div class="stat-row">
                            <span class="stat-label">Total Products</span>
                            <span class="stat-value">{{ \App\Models\Product::count() }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Total Orders</span>
                            <span class="stat-value">{{ \App\Models\Order::count() }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Total Users</span>
                            <span class="stat-value">{{ \App\Models\User::where('role', 'user')->count() }}</span>
                        </div>
                        @else
                        <div class="stat-row">
                            <span class="stat-label">My Products</span>
                            <span class="stat-value">{{ \App\Models\Product::where('seller_name', $user->name)->count() }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">My Orders</span>
                            <span class="stat-value">{{ \App\Models\Order::whereHas('orderItems.product', function($query) use ($user) { $query->where('seller_name', $user->name); })->count() }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Total Sales</span>
                            <span class="stat-value">{{ \App\Models\Product::where('seller_name', $user->name)->sum('sales_count') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="profile-main">
                <!-- Profile Information -->
                <div class="form-card">
                    <div class="form-card-header">
                        <i class="fas fa-user"></i>
                        <h3>Profile Information</h3>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Profile Photo</label>
                                <div class="photo-upload">
                                    <div class="photo-preview">
                                        @if($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile">
                                        @else
                                            <i class="fas fa-user"></i>
                                        @endif
                                    </div>
                                    <div class="photo-input">
                                        <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                                               name="profile_photo" accept="image/*">
                                        <div class="form-hint">Upload JPG, PNG, GIF (max 2MB)</div>
                                        @error('profile_photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if($user->isSeller() || $user->isAdmin())
                            <div class="form-group">
                                <label class="form-label">Description / Bio</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="3" 
                                          placeholder="Tell us about yourself or your store...">{{ old('description', $user->description) }}</textarea>
                                <div class="form-hint">Maximum 1000 characters. This will be displayed on your seller profile.</div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Wallet Balance</label>
                                    <input type="text" class="form-control" value="Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}" readonly>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="form-card">
                    <div class="form-card-header">
                        <i class="fas fa-lock"></i>
                        <h3>Change Password</h3>
                    </div>
                    <div class="form-card-body">
                        <form action="{{ route('admin.profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label class="form-label">Current Password *</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">New Password *</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirm New Password *</label>
                                    <input type="password" class="form-control" 
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn-submit btn-warning">
                                    <i class="fas fa-key"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
