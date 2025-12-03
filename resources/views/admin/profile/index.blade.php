@extends('layouts.app')

@section('title', 'Profile Management - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user-cog me-2"></i>Profile Management
                </h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                                       id="profile_photo" name="profile_photo" accept="image/*">
                                @error('profile_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Upload JPG, PNG, GIF (max 2MB)</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Current Photo</label>
                                <div class="text-center">
                                    @if($user->profile_photo)
                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                             alt="Profile Photo" 
                                             class="img-thumbnail" 
                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto;">
                                            <i class="fas fa-user fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($user->isSeller() || $user->isAdmin())
                        <div class="mb-3">
                            <label for="description" class="form-label">Description / Bio</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Tell us about yourself or your store...">{{ old('description', $user->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maximum 1000 characters. This will be displayed on your seller profile.</small>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Wallet Balance</label>
                                <input type="text" class="form-control" value="Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Member Since</label>
                                <input type="text" class="form-control" value="{{ $user->created_at->format('M d, Y') }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Updated</label>
                                <input type="text" class="form-control" value="{{ $user->updated_at->format('M d, Y H:i') }}" readonly>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Change Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password *</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Account Statistics</h6>
                </div>
                <div class="card-body">
                    @if($user->isAdmin())
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Products:</span>
                                <span class="fw-bold">{{ \App\Models\Product::count() }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Orders:</span>
                                <span class="fw-bold">{{ \App\Models\Order::count() }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Users:</span>
                                <span class="fw-bold">{{ \App\Models\User::where('role', 'user')->count() }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">My Products:</span>
                                <span class="fw-bold">{{ \App\Models\Product::where('seller_name', $user->name)->count() }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">My Orders:</span>
                                <span class="fw-bold">{{ \App\Models\Order::whereHas('orderItems.product', function($query) use ($user) { $query->where('seller_name', $user->name); })->count() }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Sales:</span>
                                <span class="fw-bold">{{ \App\Models\Product::where('seller_name', $user->name)->sum('sales_count') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #2e59d9;
    border-color: #2e59d9;
}

.btn-warning {
    background-color: #f6c23e;
    border-color: #f6c23e;
    color: #212529;
}

.btn-warning:hover {
    background-color: #f4b619;
    border-color: #f4b619;
    color: #212529;
}

.text-muted {
    color: #858796 !important;
}

.fw-bold {
    font-weight: 600 !important;
}
</style>
@endsection
