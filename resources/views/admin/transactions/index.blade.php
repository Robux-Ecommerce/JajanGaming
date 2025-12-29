@extends('layouts.app')

@section('title', 'Manage Transactions - JajanGaming')

@section('content')
<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px); background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);">
    @include('partials.sidebar', ['sidebarTitle' => 'Transactions'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mt-3 mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1" style="font-size: 1.4rem; color: #ffffff; font-weight: 700;">
                                <i class="fas fa-exchange-alt me-2" style="color: #64a0b4;"></i>Manajemen Transaksi
                            </h1>
                            <p class="mb-0" style="font-size: 0.9rem; color: #a0b5c5;">Pantau dan kelola semua transaksi sistem</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.transactions.export') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download me-1"></i>Export CSV
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-3">
                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="stats-card total">
                        <div class="stats-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Total Transaksi</h6>
                            <h3>{{ $transactions->total() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="stats-card success">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Berhasil</h6>
                            <h3>{{ $transactions->where('status', 'success')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="stats-card warning">
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Pending</h6>
                            <h3>{{ $transactions->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-2">
                    <div class="stats-card danger">
                        <div class="stats-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Gagal</h6>
                            <h3>{{ $transactions->where('status', 'failed')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="card shadow">
                <div class="card-header py-2 bg-primary text-white">
                    <h5 class="m-0 font-weight-bold" style="font-size: 1rem;">
                        <i class="fas fa-list me-2"></i>Daftar Transaksi
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%; font-size: 0.85rem;">No</th>
                                        <th style="width: 20%; font-size: 0.85rem;">Pengguna</th>
                                        <th style="width: 10%; font-size: 0.85rem;">Tipe</th>
                                        <th style="width: 12%; font-size: 0.85rem;">Metode</th>
                                        <th style="width: 15%; font-size: 0.85rem;">Jumlah</th>
                                        <th style="width: 15%; font-size: 0.85rem;">Tanggal</th>
                                        <th style="width: 12%; font-size: 0.85rem; text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $index => $transaction)
                                        <tr class="transaction-row">
                                            <td>
                                                <span class="fw-600" style="font-size: 0.9rem; color: #1a2332;">
                                                    {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar-mini">
                                                        {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-600" style="font-size: 0.9rem; color: #1a2332;">{{ $transaction->user->name }}</div>
                                                        <small style="color: #7a8a9a; font-size: 0.8rem;">{{ $transaction->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.85rem;">
                                                    @if($transaction->type === 'topup')
                                                        <span style="color: #64a0b4; font-weight: 600;">
                                                            <i class="fas fa-arrow-up me-1"></i>Top Up Wallet
                                                        </span>
                                                        <br><small style="color: #7a8a9a;">Dari: {{ $transaction->payment_method === 'wallet' ? 'Dompet Internal' : 'Payment Gateway' }}</small>
                                                    @elseif($transaction->type === 'purchase')
                                                        <span style="color: #6ebe96; font-weight: 600;">
                                                            <i class="fas fa-shopping-cart me-1"></i>Pembelian Produk
                                                        </span>
                                                        <br><small style="color: #7a8a9a;">Order: {{ $transaction->order->id ?? 'N/A' }}</small>
                                                    @elseif($transaction->type === 'withdrawal')
                                                        <span style="color: #e07856; font-weight: 600;">
                                                            <i class="fas fa-arrow-down me-1"></i>Penarikan Dana
                                                        </span>
                                                    @else
                                                        <span style="color: #a0b5c5; font-weight: 600;">{{ ucfirst($transaction->type) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($transaction->payment_method === 'wallet')
                                                    <span class="badge bg-light text-dark" style="font-size: 0.75rem;">
                                                        <i class="fas fa-wallet me-1"></i>DompetKu
                                                    </span>
                                                @else
                                                    <span class="badge bg-info" style="font-size: 0.75rem;">
                                                        <i class="fas fa-credit-card me-1"></i>Gateway
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-700" style="color: #64a0b4; font-size: 0.9rem;">
                                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <small style="color: #7a8a9a; font-size: 0.8rem;">
                                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                                </small>
                                            </td>
                                            <td style="text-align: center;">
                                                @if($transaction->status === 'pending')
                                                    <span class="status-badge status-pending-mini">
                                                        <i class="fas fa-hourglass-half"></i>
                                                    </span>
                                                @elseif($transaction->status === 'success')
                                                    <span class="status-badge status-success-mini">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                @elseif($transaction->status === 'failed')
                                                    <span class="status-badge status-failed-mini">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                @else
                                                    <span class="status-badge status-other-mini">?</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-2" style="display: block; margin-bottom: 1rem;"></i>
                                                <h6 class="text-muted">Tidak ada transaksi</h6>
                                                <p class="text-muted" style="font-size: 0.85rem;">Belum ada data transaksi untuk ditampilkan</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($transactions->hasPages())
                            <div class="d-flex justify-content-center pt-3 pb-2 border-top">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada transaksi</h5>
                            <p class="text-muted">Belum ada data transaksi untuk ditampilkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Statistics Cards - Compact Design */
.stats-card {
    padding: 1rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(30%, -30%);
    pointer-events: none;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
    border-color: rgba(255, 255, 255, 0.25);
}

.stats-card.total {
    background: linear-gradient(135deg, #64a0b4 0%, #4a8a9e 100%);
    border: 2px solid rgba(100, 160, 180, 0.3);
}

.stats-card.success {
    background: linear-gradient(135deg, #6ebe96 0%, #48a070 100%);
    border: 2px solid rgba(110, 190, 150, 0.3);
}

.stats-card.warning {
    background: linear-gradient(135deg, #e8b056 0%, #d68940 100%);
    border: 2px solid rgba(232, 176, 86, 0.3);
}

.stats-card.danger {
    background: linear-gradient(135deg, #e07856 0%, #c84c40 100%);
    border: 2px solid rgba(224, 120, 86, 0.3);
}

.stats-icon {
    font-size: 2rem;
    opacity: 1;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.stats-content {
    position: relative;
    z-index: 1;
}

.stats-content h6 {
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
    opacity: 1;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.stats-content h3 {
    font-size: 1.6rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Table Styling */
.table-responsive {
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
    border-radius: 12px;
    border: 1px solid rgba(100, 160, 180, 0.2);
}

.table {
    font-size: 0.9rem;
    color: #e0e0e0;
    margin-bottom: 0;
}

.table thead {
    background-color: rgba(100, 160, 180, 0.15);
    border-bottom: 2px solid rgba(100, 160, 180, 0.3);
}

.table thead th {
    color: #a0c5d5;
    font-weight: 700;
    padding: 0.85rem 0.85rem;
    border: none;
    letter-spacing: 0.3px;
}

.table tbody td {
    padding: 0.75rem 0.85rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(100, 160, 180, 0.1);
    color: #e0e0e0;
}

.transaction-row {
    transition: background-color 0.2s ease;
}

.transaction-row:hover {
    background-color: rgba(100, 160, 180, 0.1) !important;
}

.transaction-row td {
    transition: background-color 0.2s ease;
}

/* Avatar Mini */
.avatar-mini {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(100, 160, 180, 0.3);
}

/* Font Utilities */
.fw-600 {
    font-weight: 600;
}

.fw-700 {
    font-weight: 700;
}

.gap-2 {
    gap: 0.5rem;
}

/* Status Badges Mini */
.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-pending-mini {
    background: linear-gradient(135deg, rgba(232, 176, 86, 0.15) 0%, rgba(216, 149, 64, 0.1) 100%);
    color: #ffa500;
    border: 1px solid rgba(232, 176, 86, 0.4);
}

.status-success-mini {
    background: linear-gradient(135deg, rgba(110, 190, 150, 0.15) 0%, rgba(82, 168, 118, 0.1) 100%);
    color: #6ebe96;
    border: 1px solid rgba(110, 190, 150, 0.4);
}

.status-failed-mini {
    background: linear-gradient(135deg, rgba(224, 120, 86, 0.15) 0%, rgba(200, 92, 64, 0.1) 100%);
    color: #ff9999;
    border: 1px solid rgba(224, 120, 86, 0.4);
}

.status-other-mini {
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.15) 0%, rgba(80, 140, 160, 0.1) 100%);
    color: #64a0b4;
    border: 1px solid rgba(100, 160, 180, 0.4);
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
    border: 1px solid rgba(100, 160, 180, 0.2);
    color: #ffffff;
    background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
    border: 1px solid rgba(100, 160, 180, 0.2);
    color: #ffffff;
    transition: all 0.3s ease;
}

.card-header {
    border-bottom: 1px solid rgba(100, 160, 180, 0.2);
    border-radius: 10px 10px 0 0 !important;
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    color: white;
    font-weight: 600;
}

/* Page Header Enhancement */
h1.h3 {
    color: #ffffff;
    font-weight: 700;
    font-size: 1.5rem;
}

.text-muted {
    color: #a0b5c5 !important;
}

/* Button Styling */
.btn-secondary {
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    border: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    color: #ffffff;
    font-weight: 600;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #508ca0 0%, #3e7a8c 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(100, 160, 180, 0.4);
    color: #ffffff;
}

/* Badge Styling */
.badge {
    padding: 0.4rem 0.7rem;
    font-weight: 600;
    border-radius: 4px;
    font-size: 0.75rem;
}

/* Pagination */
.pagination {
    gap: 0.2rem;
}

.page-link {
    color: #64a0b4;
    border-color: rgba(100, 160, 180, 0.3);
    border-radius: 4px;
    padding: 0.5rem 0.65rem;
    font-size: 0.9rem;
    background: rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.page-link:hover {
    color: #ffffff;
    background-color: rgba(100, 160, 180, 0.2);
    border-color: rgba(100, 160, 180, 0.4);
}

.page-link.active {
    background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
    border-color: #64a0b4;
    color: #ffffff;
}

.page-item.disabled .page-link {
    color: #5a7a8a;
    background: rgba(100, 160, 180, 0.05);
    border-color: rgba(100, 160, 180, 0.2);
}

/* Form Control Styling */
.form-control,
.form-select {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(100, 160, 180, 0.3);
    color: #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.form-control:focus,
.form-select:focus {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(100, 160, 180, 0.6);
    color: #ffffff;
    box-shadow: 0 0 0 0.2rem rgba(100, 160, 180, 0.25);
}

.form-control::placeholder {
    color: #7a8a9a;
}

/* Breadcrumb */
.breadcrumb {
    background: transparent;
    padding: 0.5rem 0;
}

.breadcrumb-item {
    color: #a0b5c5;
}

.breadcrumb-item.active {
    color: #e0e0e0;
}

.breadcrumb-item a {
    color: #64a0b4;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #5eb8c4;
}

/* Responsive */
@media (max-width: 1024px) {
    .table {
        font-size: 0.85rem;
    }

    .table thead th,
    .table tbody td {
        padding: 0.55rem 0.6rem;
    }

    .stats-icon {
        font-size: 1.75rem;
    }

    .stats-content h3 {
        font-size: 1.3rem;
    }
}

@media (max-width: 768px) {
    .table {
        font-size: 0.8rem;
    }

    .table thead th,
    .table tbody td {
        padding: 0.5rem 0.5rem;
    }

    .avatar-mini {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }

    .stats-card {
        padding: 0.75rem;
        gap: 0.5rem;
    }

    .stats-icon {
        font-size: 1.5rem;
    }

    .stats-content h6 {
        font-size: 0.7rem;
    }

    .stats-content h3 {
        font-size: 1.2rem;
    }
}
</style>
@endsection
