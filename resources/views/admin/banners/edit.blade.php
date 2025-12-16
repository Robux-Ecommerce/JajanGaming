@extends('layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <div class="container mt-4">
        <h3>Edit Banner</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $banner->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                @if ($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}"
                        style="max-width:200px; display:block; margin-bottom:0.5rem;">
                @endif
                <label class="form-label">Replace Image (optional)</label>
                <input type="file" name="image_upload" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Button Text</label>
                <input type="text" name="button_text" class="form-control"
                    value="{{ old('button_text', $banner->button_text) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Button URL</label>
                <input type="text" name="button_url" class="form-control"
                    value="{{ old('button_url', $banner->button_url) }}" placeholder="https://example.com or /browse">
                <small class="form-text text-muted">Masukkan URL lengkap (https://...) atau path internal dimulai dengan /.
                    Misal: /browse. External akan dibuka di tab baru.</small>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ old('start_date', optional($banner->start_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ old('end_date', optional($banner->end_date)->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
                    {{ $banner->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
