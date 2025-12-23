@extends('layouts.app')

@section('title', 'Riwayat Pajak Admin - JajanGaming')

@section('content')
<div style="display: flex; min-height: calc(100vh - 80px); background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);">
    @include('partials.sidebar', ['sidebarTitle' => 'Tax History'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mt-4 mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-2" style="color: #ffffff; font-weight: 700;">
                                <i class="fas fa-history me-2" style="color: #64a0b4;"></i>Riwayat Pajak
                            </h1>
                            <p class="mb-0" style="color: #a0b5c5; font-size: 1rem;">Kelola dan lihat detail riwayat pajak transaksi</p>
                        </div>
                        <a href="{{ route('admin.wallet') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dompet
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter & Export -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-filter me-2"></i>Filter & Export
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="month" class="form-label">Bulan</label>
                            <input type="month" class="form-control" id="month" name="month" value="{{ request('month') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.wallet.history') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="mt-3 pt-3 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Total Pajak dalam Range:</strong></p>
                                <h4 class="text-success">Rp {{ number_format($totalInRange, 0, ',', '.') }}</h4>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <a href="{{ route('admin.wallet.export', request()->query()) }}" class="btn btn-success">
                                    <i class="fas fa-download me-1"></i>Export CSV
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Table -->
            <div class="card shadow">
                <div class="card-header py-3 bg-primary text-white">
                    <h5 class="m-0 font-weight-bold">
                        <i class="fas fa-table me-2"></i>Daftar Pajak
                    </h5>
                </div>
                <div class="card-body">
                    @if($taxes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%">Tanggal & Waktu</th>
                                        <th style="width: 10%">Order ID</th>
                                        <th style="width: 10%">Transaksi ID</th>
                                        <th style="width: 15%">Jumlah Pajak</th>
                                        <th style="width: 10%">Tarif</th>
                                        <th style="width: 25%">Deskripsi</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($taxes as $tax)
                                        <tr>
                                            <td>
                                                <small class="d-block">{{ $tax->created_at->format('d M Y') }}</small>
                                                <small class="text-muted">{{ $tax->created_at->format('H:i:s') }}</small>
                                            </td>
                                            <td>
                                                @if($tax->order_id)
                                                    <span class="badge bg-primary">{{ $tax->order_id }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($tax->transaction_id)
                                                    <small>{{ $tax->transaction_id }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-success">Rp {{ number_format($tax->amount, 0, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $tax->tax_rate }}%</span>
                                            </td>
                                            <td>
                                                <small>{{ $tax->description ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <i class="fas fa-inbox text-muted fa-2x mb-2 d-block"></i>
                                                <small class="text-muted">Belum ada data pajak dengan filter ini</small>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($taxes->hasPages())
                            <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                                {{ $taxes->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Background */
    body, .page-wrapper {
        background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%) !important;
        color: #ffffff;
    }

    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
        transition: all 0.3s ease;
        border: 1px solid rgba(100, 160, 180, 0.2);
        color: #ffffff;
    }

    .card-header {
        border-bottom: 2px solid rgba(100, 160, 180, 0.3);
        border-radius: 14px 14px 0 0 !important;
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        color: white;
        font-weight: 700;
        padding: 1.25rem !important;
    }

    .card-body {
        background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
        color: #ffffff;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        border: none;
        transition: all 0.3s ease;
        font-weight: 600;
        color: white;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #4a8a94 0%, #3a7a90 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(100, 160, 180, 0.4);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        border: none;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #4a8a94 0%, #3a7a90 100%);
        box-shadow: 0 6px 15px rgba(100, 160, 180, 0.4);
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(100, 160, 180, 0.3) !important;
        color: #ffffff !important;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    .form-label {
        color: #a0b5c5;
        font-weight: 600;
    }

    .table {
        color: #e0e0e0;
        border-color: rgba(100, 160, 180, 0.2);
    }

    .table-hover tbody tr {
        background-color: transparent;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(100, 160, 180, 0.1) !important;
        border-color: rgba(100, 160, 180, 0.3);
    }

    .table-striped tbody tr {
        background-color: rgba(100, 160, 180, 0.05);
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: transparent;
    }

    .table thead {
        background: rgba(100, 160, 180, 0.15);
        border-color: rgba(100, 160, 180, 0.3);
    }

    .table-light {
        background: rgba(100, 160, 180, 0.15) !important;
    }

    .badge {
        font-weight: 600;
        padding: 0.5rem 0.9rem;
        border-radius: 6px;
    }

    .pagination {
        gap: 0.5rem;
    }

    .page-link {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.3);
        color: #64a0b4;
        font-weight: 600;
    }

    .page-link:hover {
        background: rgba(100, 160, 180, 0.2);
        border-color: rgba(100, 160, 180, 0.5);
        color: #ffffff;
    }

    .page-link.active {
        background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
        border-color: #64a0b4;
    }

    h1.h3 {
        color: #ffffff;
        font-weight: 700;
    }

    .text-success {
        color: #6ebe96 !important;
    }

    .text-muted {
        color: #a0b5c5 !important;
    }

    .border-top {
        border-top-color: rgba(100, 160, 180, 0.2) !important;
    }
</style>
@endsection
