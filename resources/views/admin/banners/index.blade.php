@extends('layouts.app')

@section('title', 'Manage Banners')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Banners</h3>
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Create Banner</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Dates</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                    <tr>
                        <td>{{ $banner->title }}<br><small>{{ $banner->subtitle }}</small></td>
                        <td>
                            @if ($banner->start_date)
                                {{ $banner->start_date->format('Y-m-d') }}
                            @endif
                            @if ($banner->end_date)
                                - {{ $banner->end_date->format('Y-m-d') }}
                            @endif
                        </td>
                        <td>{{ $banner->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.banners.edit', $banner) }}"
                                class="btn btn-sm btn-outline-light me-1">Edit</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST"
                                style="display:inline-block;" onsubmit="return confirm('Delete banner?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $banners->links() }}
    </div>
@endsection
