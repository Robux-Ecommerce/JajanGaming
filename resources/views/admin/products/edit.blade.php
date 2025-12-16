@extends('layouts.app')

@section('title', 'Edit Product - JajanGaming')

@section('content')
<style>
    .edit-product-page {
        background: linear-gradient(180deg, #121a24 0%, #1a2a38 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .page-title {
        color: #ffffff;
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: #64a0b4;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
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
    }

    .form-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .card-header-custom {
        background: rgba(100, 160, 180, 0.1);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(100, 160, 180, 0.15);
    }

    .card-header-custom h6 {
        color: #64a0b4;
        font-weight: 600;
        margin: 0;
        font-size: 1rem;
    }

    .card-body-custom {
        padding: 2rem;
    }

    .form-label {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: #ffffff;
        border-radius: 12px;
        padding: 0.85rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: rgba(0, 0, 0, 0.4);
        border-color: #64a0b4;
        box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.2);
        color: #ffffff;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .form-control[readonly] {
        background: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.6);
    }

    .form-select option {
        background: #1a2a38;
        color: #ffffff;
    }

    .form-check-input {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: rgba(100, 160, 180, 0.3);
    }

    .form-check-input:checked {
        background-color: #64a0b4;
        border-color: #64a0b4;
    }

    .form-check-label {
        color: rgba(255, 255, 255, 0.85);
    }

    .invalid-feedback {
        color: #d9534f;
    }

    .text-muted-custom {
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 0.8rem;
    }

    .btn-cancel {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    .btn-submit {
        background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(100, 160, 180, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(100, 160, 180, 0.4);
        color: white;
    }

    /* Tabs styling */
    .nav-tabs-custom {
        border-bottom: 1px solid rgba(100, 160, 180, 0.2);
        margin-bottom: 1rem;
    }

    .nav-tabs-custom .nav-link {
        color: rgba(255, 255, 255, 0.6);
        border: none;
        padding: 0.75rem 1.25rem;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s ease;
        background: transparent;
    }

    .nav-tabs-custom .nav-link:hover {
        color: rgba(255, 255, 255, 0.9);
        background: rgba(100, 160, 180, 0.1);
    }

    .nav-tabs-custom .nav-link.active {
        color: #64a0b4;
        background: rgba(100, 160, 180, 0.15);
        border-bottom: 2px solid #64a0b4;
    }

    /* Image selection */
    .current-image-wrapper {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
        border: 1px solid rgba(100, 160, 180, 0.2);
    }

    .current-image {
        max-width: 150px;
        border-radius: 12px;
        border: 2px solid rgba(100, 160, 180, 0.3);
    }

    .current-image-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    .image-option {
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .image-option .img-thumbnail {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid rgba(100, 160, 180, 0.2);
        transition: all 0.3s ease;
    }

    .image-option:hover .img-thumbnail {
        border-color: #64a0b4;
        transform: scale(1.05);
    }

    .image-option input:checked + label .img-thumbnail {
        border-color: #64a0b4;
        box-shadow: 0 0 0 3px rgba(100, 160, 180, 0.3);
    }

    .image-option small {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
    }

    /* Stats card */
    .stats-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-value.primary {
        color: #64a0b4;
    }

    .stat-value.success {
        color: #5cb85c;
    }

    .stat-value.warning {
        color: #f0ad4e;
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.8rem;
    }

    .rating-display {
        display: flex;
        justify-content: center;
        gap: 0.25rem;
        margin-top: 0.5rem;
    }

    .rating-display i {
        color: #f0ad4e;
    }

    /* Preview card */
    .preview-card {
        background: linear-gradient(135deg, rgba(37, 48, 64, 0.95) 0%, rgba(26, 42, 56, 0.95) 100%);
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .preview-content {
        text-align: center;
        padding: 1.5rem;
    }

    .preview-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid rgba(100, 160, 180, 0.3);
        margin-bottom: 1rem;
    }

    .preview-name {
        color: #ffffff;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .preview-price {
        color: #5cb85c;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .preview-description {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
    }

    .divider {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 1rem 0;
    }
</style>

<div class="edit-product-page">
    <div class="container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="page-title">
                    <i class="fas fa-edit"></i>
                    Edit Product
                </h1>
                <a href="{{ route('admin.products') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>Back to Products
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="card-header-custom">
                        <h6><i class="fas fa-info-circle me-2"></i>Product Information</h6>
                    </div>
                    <div class="card-body-custom">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Product Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="game_name" class="form-label">Game Name *</label>
                                    <input type="text" class="form-control @error('game_name') is-invalid @enderror" 
                                           id="game_name" name="game_name" value="{{ old('game_name', $product->game_name) }}" required>
                                    @error('game_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="game_type" class="form-label">Game Type *</label>
                                    <select class="form-select @error('game_type') is-invalid @enderror" 
                                            id="game_type" name="game_type" required>
                                        <option value="">Select Game Type</option>
                                        <option value="Robux" {{ old('game_type', $product->game_type) == 'Robux' ? 'selected' : '' }}>Robux</option>
                                        <option value="Premium" {{ old('game_type', $product->game_type) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                        <option value="Game Pass" {{ old('game_type', $product->game_type) == 'Game Pass' ? 'selected' : '' }}>Game Pass</option>
                                    </select>
                                    @error('game_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                @if(auth()->user()->isAdmin())
                                <div class="col-md-6 mb-3">
                                    <label for="seller_name" class="form-label">Seller Name *</label>
                                    <input type="text" class="form-control @error('seller_name') is-invalid @enderror" 
                                           id="seller_name" name="seller_name" value="{{ old('seller_name', $product->seller_name) }}" required>
                                    @error('seller_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @else
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Seller Name</label>
                                    <input type="text" class="form-control" value="{{ $product->seller_name }}" readonly>
                                    <small class="text-muted-custom">You cannot change the seller name</small>
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price (Rp) *</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="100" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Stock Quantity *</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if(auth()->user()->isAdmin())
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rating" class="form-label">Rating (0-5) *</label>
                                    <input type="number" class="form-control @error('rating') is-invalid @enderror" 
                                           id="rating" name="rating" value="{{ old('rating', $product->rating) }}" min="0" max="5" step="0.1" required>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Image</label>
                                    
                                    <!-- Current Image Preview -->
                                    <div class="current-image-wrapper">
                                        <img src="{{ asset('img/' . $product->image) }}" alt="Current Image" class="current-image">
                                        <p class="current-image-label">Current product image</p>
                                    </div>
                                    
                                    <!-- Image Selection Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-custom mb-3" id="imageTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                                                <i class="fas fa-upload me-1"></i>Upload
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="select-tab" data-bs-toggle="tab" data-bs-target="#select" type="button" role="tab">
                                                <i class="fas fa-images me-1"></i>Gallery
                                            </button>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content" id="imageTabContent">
                                        <!-- Upload Tab -->
                                        <div class="tab-pane fade show active" id="upload" role="tabpanel">
                                            <input type="file" class="form-control @error('image_upload') is-invalid @enderror" 
                                                   id="image_upload" name="image_upload" accept="image/*">
                                            @error('image_upload')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted-custom">Upload JPG, PNG, GIF (max 2MB)</small>
                                        </div>

                                        <!-- Select Tab -->
                                        <div class="tab-pane fade" id="select" role="tabpanel">
                                            <div class="row g-2">
                                                <div class="col-6 col-md-3">
                                                    <div class="image-option">
                                                        <input class="form-check-input d-none" type="radio" name="image_select" id="robux1" value="sellers/robux dikit 1.png" {{ $product->image == 'sellers/robux dikit 1.png' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="robux1">
                                                            <img src="{{ asset('img/sellers/robux dikit 1.png') }}" class="img-thumbnail">
                                                            <small class="d-block mt-1">Robux Dikit</small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="image-option">
                                                        <input class="form-check-input d-none" type="radio" name="image_select" id="robux2" value="sellers/robux sedang 2.png" {{ $product->image == 'sellers/robux sedang 2.png' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="robux2">
                                                            <img src="{{ asset('img/sellers/robux sedang 2.png') }}" class="img-thumbnail">
                                                            <small class="d-block mt-1">Robux Sedang</small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="image-option">
                                                        <input class="form-check-input d-none" type="radio" name="image_select" id="robux3" value="sellers/robux banyak 2.png" {{ $product->image == 'sellers/robux banyak 2.png' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="robux3">
                                                            <img src="{{ asset('img/sellers/robux banyak 2.png') }}" class="img-thumbnail">
                                                            <small class="d-block mt-1">Robux Banyak</small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="image-option">
                                                        <input class="form-check-input d-none" type="radio" name="image_select" id="robux4" value="sellers/robux.png" {{ $product->image == 'sellers/robux.png' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="robux4">
                                                            <img src="{{ asset('img/sellers/robux.png') }}" class="img-thumbnail">
                                                            <small class="d-block mt-1">Robux Default</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden input for final image value -->
                                    <input type="hidden" name="image" id="final_image" value="{{ $product->image }}">
                                </div>
                            </div>
                            @else
                            <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                
                                <!-- Current Image Preview -->
                                <div class="current-image-wrapper">
                                    <img src="{{ asset('img/' . $product->image) }}" alt="Current Image" class="current-image">
                                    <p class="current-image-label">Current product image</p>
                                </div>
                                
                                <!-- Image Selection Tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom mb-3" id="imageTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                                            <i class="fas fa-upload me-1"></i>Upload
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="select-tab" data-bs-toggle="tab" data-bs-target="#select" type="button" role="tab">
                                            <i class="fas fa-images me-1"></i>Gallery
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="imageTabContent">
                                    <!-- Upload Tab -->
                                    <div class="tab-pane fade show active" id="upload" role="tabpanel">
                                        <input type="file" class="form-control @error('image_upload') is-invalid @enderror" 
                                               id="image_upload" name="image_upload" accept="image/*">
                                        @error('image_upload')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted-custom">Upload JPG, PNG, GIF (max 2MB)</small>
                                    </div>

                                    <!-- Select Tab -->
                                    <div class="tab-pane fade" id="select" role="tabpanel">
                                        <div class="row g-2">
                                            <div class="col-6 col-md-3">
                                                <div class="image-option">
                                                    <input class="form-check-input d-none" type="radio" name="image_select" id="robux1_seller" value="sellers/robux dikit 1.png" {{ $product->image == 'sellers/robux dikit 1.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux1_seller">
                                                        <img src="{{ asset('img/sellers/robux dikit 1.png') }}" class="img-thumbnail">
                                                        <small class="d-block mt-1">Robux Dikit</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="image-option">
                                                    <input class="form-check-input d-none" type="radio" name="image_select" id="robux2_seller" value="sellers/robux sedang 2.png" {{ $product->image == 'sellers/robux sedang 2.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux2_seller">
                                                        <img src="{{ asset('img/sellers/robux sedang 2.png') }}" class="img-thumbnail">
                                                        <small class="d-block mt-1">Robux Sedang</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="image-option">
                                                    <input class="form-check-input d-none" type="radio" name="image_select" id="robux3_seller" value="sellers/robux banyak 2.png" {{ $product->image == 'sellers/robux banyak 2.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux3_seller">
                                                        <img src="{{ asset('img/sellers/robux banyak 2.png') }}" class="img-thumbnail">
                                                        <small class="d-block mt-1">Robux Banyak</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="image-option">
                                                    <input class="form-check-input d-none" type="radio" name="image_select" id="robux4_seller" value="sellers/robux.png" {{ $product->image == 'sellers/robux.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux4_seller">
                                                        <img src="{{ asset('img/sellers/robux.png') }}" class="img-thumbnail">
                                                        <small class="d-block mt-1">Robux Default</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden input for final image value -->
                                <input type="hidden" name="image" id="final_image" value="{{ $product->image }}">
                            </div>
                            @endif

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Product is active (visible to customers)
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.products') }}" class="btn-cancel">Cancel</a>
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save me-2"></i>Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Stats Card -->
                <div class="stats-card">
                    <div class="card-header-custom">
                        <h6><i class="fas fa-chart-bar me-2"></i>Product Stats</h6>
                    </div>
                    <div class="card-body-custom">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value primary">{{ number_format($product->sales_count) }}</div>
                                    <div class="stat-label">Total Sales</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value success">{{ $product->quantity }}</div>
                                    <div class="stat-label">In Stock</div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="stat-item">
                            <div class="stat-value warning">{{ number_format($product->rating, 1) }}</div>
                            <div class="stat-label">Average Rating</div>
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="preview-card">
                    <div class="card-header-custom">
                        <h6><i class="fas fa-eye me-2"></i>Live Preview</h6>
                    </div>
                    <div class="preview-content">
                        <img src="{{ asset('img/' . $product->image) }}" alt="Product Preview" class="preview-image" id="preview-image">
                        <div class="preview-name" id="preview-name">{{ $product->name }}</div>
                        <div class="preview-price" id="preview-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="preview-description" id="preview-description">{{ Str::limit($product->description, 100) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const priceInput = document.getElementById('price');
    const descriptionInput = document.getElementById('description');
    
    const previewName = document.getElementById('preview-name');
    const previewPrice = document.getElementById('preview-price');
    const previewDescription = document.getElementById('preview-description');
    
    function updatePreview() {
        previewName.textContent = nameInput.value || 'Product Name';
        previewPrice.textContent = 'Rp ' + (priceInput.value ? parseInt(priceInput.value).toLocaleString() : '0');
        previewDescription.textContent = descriptionInput.value || 'Product description will appear here';
    }
    
    nameInput.addEventListener('input', updatePreview);
    priceInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);

    // Image selection handling
    const uploadTab = document.getElementById('upload-tab');
    const selectTab = document.getElementById('select-tab');
    const uploadInput = document.getElementById('image_upload');
    const selectInputs = document.querySelectorAll('input[name="image_select"]');
    const finalImageInput = document.getElementById('final_image');

    // Handle tab switching
    if (uploadTab) {
        uploadTab.addEventListener('click', function() {
            selectInputs.forEach(input => input.checked = false);
        });
    }

    if (selectTab) {
        selectTab.addEventListener('click', function() {
            if (uploadInput) uploadInput.value = '';
        });
    }

    // Handle file upload
    if (uploadInput) {
        uploadInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                finalImageInput.value = 'uploaded_' + Date.now() + '_' + this.files[0].name;
                selectInputs.forEach(input => input.checked = false);
            }
        });
    }

    // Handle image selection
    selectInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                finalImageInput.value = this.value;
                if (uploadInput) uploadInput.value = '';
            }
        });
    });
});
</script>
@endsection
