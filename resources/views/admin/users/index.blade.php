@extends('layouts.app')

@section('title', 'Manage Users - JajanGaming')

@section('content')
<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'Users'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <style>
    .users-page {
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

    /* Stats Summary */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .stat-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 12px;
        padding: 0.7rem;
        border: 1px solid rgba(100, 160, 180, 0.1);
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        display: block;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(100, 160, 180, 0.4);
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.95) 0%, rgba(30, 42, 54, 1) 100%);
    }

    .stat-value {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.15rem;
    }

    .stat-value.total { color: #7ab8c8; }
    .stat-value.admin { color: #e87a76; }
    .stat-value.seller { color: #f5c06a; }
    .stat-value.user { color: #6fcf6f; }

    .stat-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Users Grid */
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0.85rem;
    }

    /* User Card */
    .user-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.85) 0%, rgba(30, 42, 54, 0.9) 100%);
        border-radius: 12px;
        border: 1px solid rgba(100, 160, 180, 0.1);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .user-card:hover {
        transform: translateY(-3px);
        border-color: rgba(100, 160, 180, 0.3);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .user-header {
        padding: 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(100, 160, 180, 0.08);
        background: rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin: 0 auto 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        color: white;
    }

    .user-avatar.admin { background: linear-gradient(135deg, #e87a76 0%, #c95a56 100%); }
    .user-avatar.seller { background: linear-gradient(135deg, #f5c06a 0%, #d9a64a 100%); }
    .user-avatar.user { background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%); }

    .user-name {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-email {
        color: rgba(255, 255, 255, 0.45);
        font-size: 0.7rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-body { padding: 0.85rem; }

    .user-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.4rem;
        margin-bottom: 0.65rem;
    }

    .meta-item {
        background: rgba(0, 0, 0, 0.2);
        padding: 0.5rem;
        border-radius: 8px;
        text-align: center;
    }

    .meta-value {
        font-weight: 700;
        font-size: 0.75rem;
        color: #ffffff;
        display: block;
    }

    .meta-value.balance { color: #6fcf6f; }

    .meta-label {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.5rem;
        text-transform: uppercase;
    }

    .user-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.85rem;
        border-top: 1px solid rgba(100, 160, 180, 0.08);
        background: rgba(0, 0, 0, 0.1);
    }

    .role-badge {
        padding: 0.2rem 0.55rem;
        border-radius: 8px;
        font-size: 0.55rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .role-badge.admin { background: rgba(232, 122, 118, 0.2); color: #e87a76; }
    .role-badge.seller { background: rgba(245, 192, 106, 0.2); color: #f5c06a; }
    .role-badge.user { background: rgba(100, 160, 180, 0.2); color: #7ab8c8; }

    .role-badge i {
        margin-right: 0.25rem;
        font-size: 0.6rem;
    }

    .btn-delete-user {
        background: linear-gradient(135deg, rgba(232, 122, 118, 0.2) 0%, rgba(201, 90, 86, 0.2) 100%);
        border: 1px solid rgba(232, 122, 118, 0.3);
        color: #e87a76;
        padding: 0.5rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .btn-delete-user:hover {
        background: linear-gradient(135deg, rgba(232, 122, 118, 0.3) 0%, rgba(201, 90, 86, 0.3) 100%);
        border-color: rgba(232, 122, 118, 0.5);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-delete-user:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    .status-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        font-size: 0.55rem;
        font-weight: 600;
        background: rgba(111, 207, 111, 0.2);
        color: #6fcf6f;
    }

    .join-date {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.6rem;
        text-align: center;
        padding: 0.5rem;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 2.5rem 1.5rem;
        background: rgba(37, 48, 64, 0.5);
        border-radius: 14px;
        border: 1px dashed rgba(100, 160, 180, 0.2);
    }

    .empty-state i { font-size: 2.5rem; color: rgba(100, 160, 180, 0.2); margin-bottom: 0.85rem; }
    .empty-state h3 { color: rgba(255, 255, 255, 0.8); font-size: 1rem; margin-bottom: 0.4rem; }
    .empty-state p { color: rgba(255, 255, 255, 0.4); font-size: 0.8rem; }

    .pagination-wrapper { display: flex; justify-content: center; margin-top: 1.25rem; }
    .pagination-wrapper .pagination { gap: 0.3rem; }
    .pagination-wrapper .page-link {
        background: rgba(100, 160, 180, 0.08);
        border: 1px solid rgba(100, 160, 180, 0.15);
        color: rgba(255, 255, 255, 0.6);
        border-radius: 7px;
        padding: 0.35rem 0.7rem;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }
    .pagination-wrapper .page-link:hover { background: rgba(100, 160, 180, 0.15); color: #ffffff; }
    .pagination-wrapper .page-item.active .page-link { background: #64a0b4; border-color: #64a0b4; color: white; }

    @media (min-width: 1400px) { .users-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); } }
    @media (max-width: 768px) {
        .users-page { padding: 1rem 0; }
        .page-header { padding: 1rem; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .users-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) { .users-grid { grid-template-columns: 1fr; } }
</style>

<div class="users-page">
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                Manage Users
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        @if(session('success'))
        <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: rgba(111, 207, 111, 0.15); border-left: 4px solid #6fcf6f; border-radius: 8px; color: #6fcf6f;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: rgba(232, 122, 118, 0.15); border-left: 4px solid #e87a76; border-radius: 8px; color: #e87a76;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <div class="stats-row">
            <a href="{{ route('admin.users', ['role' => 'all']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                <div class="stat-value total">{{ \App\Models\User::count() }}</div>
                <div class="stat-label">Total Users</div>
            </a>
            <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                <div class="stat-value admin">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                <div class="stat-label">Admins</div>
            </a>
            <a href="{{ route('admin.users', ['role' => 'seller']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                <div class="stat-value seller">{{ \App\Models\User::where('role', 'seller')->count() }}</div>
                <div class="stat-label">Sellers</div>
            </a>
            <a href="{{ route('admin.users', ['role' => 'user']) }}" class="stat-card" style="text-decoration: none; color: inherit;">
                <div class="stat-value user">{{ \App\Models\User::where('role', 'user')->count() }}</div>
                <div class="stat-label">Customers</div>
            </a>
        </div>

        @php
            $currentRole = $role ?? 'all';
        @endphp

        @if($currentRole !== 'all')
        <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: rgba(100, 160, 180, 0.1); border-radius: 10px; border: 1px solid rgba(100, 160, 180, 0.2);">
            <span style="color: rgba(255, 255, 255, 0.7); font-size: 0.85rem;">
                <i class="fas fa-filter"></i> Filtering by: <strong style="color: #64a0b4; text-transform: capitalize;">{{ $currentRole }}</strong>
                <a href="{{ route('admin.users') }}" style="margin-left: 0.5rem; color: #64a0b4; text-decoration: none;">
                    <i class="fas fa-times"></i> Clear filter
                </a>
            </span>
        </div>
        @endif

        <div class="users-grid">
            @forelse($users as $user)
            <div class="user-card">
                <div class="user-header">
                    <div class="user-avatar {{ $user->role }}">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-email">{{ $user->email }}</div>
                </div>
                
                <div class="user-body">
                    <div class="user-meta">
                        <div class="meta-item">
                            <span class="meta-value">#{{ $user->id }}</span>
                            <span class="meta-label">User ID</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-value balance">Rp {{ number_format($user->wallet_balance, 0, ',', '.') }}</span>
                            <span class="meta-label">Balance</span>
                        </div>
                    </div>
                </div>

                <div class="user-footer">
                    <span class="role-badge {{ $user->role }}">
                        @if($user->role === 'admin')
                            <i class="fas fa-shield-alt"></i> Admin
                        @elseif($user->role === 'seller')
                            <i class="fas fa-store"></i> Seller
                        @else
                            <i class="fas fa-user"></i> User
                        @endif
                    </span>
                    <span class="status-badge">Active</span>
                </div>

                <div class="join-date">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Joined {{ $user->created_at->format('M d, Y') }}
                </div>

                <div style="padding: 0.65rem 0.85rem; border-top: 1px solid rgba(100, 160, 180, 0.08); background: rgba(0, 0, 0, 0.1);">
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone!');" 
                          style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-user" style="width: 100%;">
                            <i class="fas fa-trash-alt"></i> Delete User
                        </button>
                    </form>
                    @else
                    <button type="button" disabled style="width: 100%; opacity: 0.5; cursor: not-allowed;" class="btn-delete-user">
                        <i class="fas fa-ban"></i> Cannot Delete Own Account
                    </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No Users Found</h3>
                <p>Users will appear here when they register</p>
            </div>
            @endforelse
        </div>

        @if($users->hasPages())
        <div class="pagination-wrapper">{{ $users->links() }}</div>
        @endif
    </div>
    </div>
</div>
@endsection
