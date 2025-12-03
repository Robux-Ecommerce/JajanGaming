@extends('layouts.app')

@section('title', 'Edit Product - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </h1>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
                </div>
                <div class="card-body">
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
                                <small class="text-muted">You cannot change the seller name</small>
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
                                <label class="form-label">Product Image *</label>
                                
                                <!-- Current Image Preview -->
                                <div class="mb-3">
                                    <label class="form-label">Current Image:</label>
                                    <div class="text-center">
                                        <img src="{{ asset('img/' . $product->image) }}" alt="Current Image" 
                                             class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>
                                
                                <!-- Image Selection Tabs -->
                                <ul class="nav nav-tabs mb-3" id="imageTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                                            Upload New
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="select-tab" data-bs-toggle="tab" data-bs-target="#select" type="button" role="tab">
                                            Choose Existing
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
                                        <small class="text-muted">Upload JPG, PNG, GIF (max 2MB)</small>
                                    </div>

                                    <!-- Select Tab -->
                                    <div class="tab-pane fade" id="select" role="tabpanel">
                                        <div class="row">
                                            <div class="col-6 col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="image_select" id="robux1" value="sellers/robux dikit 1.png" {{ $product->image == 'sellers/robux dikit 1.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux1">
                                                        <img src="{{ asset('img/sellers/robux dikit 1.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <small class="d-block">Robux Dikit</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="image_select" id="robux2" value="sellers/robux sedang 2.png" {{ $product->image == 'sellers/robux sedang 2.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux2">
                                                        <img src="{{ asset('img/sellers/robux sedang 2.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <small class="d-block">Robux Sedang</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="image_select" id="robux3" value="sellers/robux banyak 2.png" {{ $product->image == 'sellers/robux banyak 2.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux3">
                                                        <img src="{{ asset('img/sellers/robux banyak 2.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <small class="d-block">Robux Banyak</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="image_select" id="robux4" value="sellers/robux.png" {{ $product->image == 'sellers/robux.png' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="robux4">
                                                        <img src="{{ asset('img/sellers/robux.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <small class="d-block">Robux Default</small>
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
                            <label class="form-label">Product Image *</label>
                            
                            <!-- Current Image Preview -->
                            <div class="mb-3">
                                <img src="{{ asset('img/' . $product->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 150px;">
                                <p class="text-muted small mt-1">Current product image</p>
                            </div>
                            
                            <!-- Image Selection Tabs -->
                            <ul class="nav nav-tabs mb-3" id="imageTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                                        Upload New
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="select-tab" data-bs-toggle="tab" data-bs-target="#select" type="button" role="tab">
                                        Choose Existing
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
                                    <small class="text-muted">Upload JPG, PNG, GIF (max 2MB)</small>
                                </div>

                                <!-- Select Tab -->
                                <div class="tab-pane fade" id="select" role="tabpanel">
                                    <div class="row">
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="image_select" id="robux1_seller" value="sellers/robux dikit 1.png" {{ $product->image == 'sellers/robux dikit 1.png' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="robux1_seller">
                                                    <img src="{{ asset('img/sellers/robux dikit 1.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <small class="d-block">Robux Dikit</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="image_select" id="robux2_seller" value="sellers/robux sedang 2.png" {{ $product->image == 'sellers/robux sedang 2.png' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="robux2_seller">
                                                    <img src="{{ asset('img/sellers/robux sedang 2.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <small class="d-block">Robux Sedang</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="image_select" id="robux3_seller" value="sellers/robux banyak 2.png" {{ $product->image == 'sellers/robux banyak 2.png' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="robux3_seller">
                                                    <img src="{{ asset('img/sellers/robux banyak 2.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <small class="d-block">Robux Banyak</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="image_select" id="robux4_seller" value="sellers/robux.png" {{ $product->image == 'sellers/robux.png' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="robux4_seller">
                                                    <img src="{{ asset('img/sellers/robux.png') }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <small class="d-block">Robux Default</small>
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

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Product is active (visible to customers)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.products') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Product Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="text-primary font-weight-bold h4">{{ number_format($product->sales_count) }}</div>
                            <div class="text-muted small">Total Sales</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-success font-weight-bold h4">{{ $product->quantity }}</div>
                            <div class="text-muted small">In Stock</div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="text-warning font-weight-bold h5">{{ number_format($product->rating, 1) }}</div>
                        <div class="text-muted small">Average Rating</div>
                        <div class="mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }} text-warning"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('img/robux.png') }}" alt="Product Preview" 
                             class="img-fluid mb-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                        <div id="preview-name" class="font-weight-bold">{{ $product->name }}</div>
                        <div id="preview-price" class="text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div id="preview-description" class="text-muted small">{{ $product->description }}</div>
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
});
</script>

<style>
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.text-warning {
    color: #f6c23e !important;
}

.text-success {
    color: #1cc88a !important;
}

.text-primary {
    color: #4e73df !important;
}

.text-muted {
    color: #858796 !important;
}

/* Image selection styles */
.img-thumbnail {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #e3e6f0;
}

.img-thumbnail:hover {
    border-color: #4e73df;
    transform: scale(1.05);
}

.form-check-input:checked + .form-check-label .img-thumbnail {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.nav-tabs .nav-link {
    color: #5a5c69;
    border: 1px solid transparent;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
}

.nav-tabs .nav-link:hover {
    border-color: #e3e6f0 #e3e6f0 #dee2e6;
    color: #4e73df;
}

.nav-tabs .nav-link.active {
    color: #4e73df;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadTab = document.getElementById('upload-tab');
    const selectTab = document.getElementById('select-tab');
    const uploadInput = document.getElementById('image_upload');
    const selectInputs = document.querySelectorAll('input[name="image_select"]');
    const finalImageInput = document.getElementById('final_image');
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('button[type="submit"]');

    // Handle tab switching
    uploadTab.addEventListener('click', function() {
        uploadInput.required = true;
        selectInputs.forEach(input => input.required = false);
        finalImageInput.value = '';
    });

    selectTab.addEventListener('click', function() {
        uploadInput.required = false;
        selectInputs.forEach(input => input.required = true);
        uploadInput.value = '';
    });

    // Handle file upload
    uploadInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            finalImageInput.value = 'uploaded_' + Date.now() + '_' + this.files[0].name;
            selectInputs.forEach(input => input.checked = false);
        }
    });

    // Handle image selection
    selectInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                finalImageInput.value = this.value;
                uploadInput.value = '';
            }
        });
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Remove the image_select and image_upload from formData
        formData.delete('image_select');
        formData.delete('image_upload');
        
        // Add the final image value
        formData.set('image', finalImageInput.value);
        
        // If uploading a file, handle it
        if (uploadInput.files.length > 0) {
            formData.set('image_upload', uploadInput.files[0]);
        }

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

        // Submit form
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = '{{ route("admin.products") }}';
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the product. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Product';
        });
    });
});
</script>
@endsection
