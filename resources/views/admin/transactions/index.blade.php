@extends('layouts.app')

@section('title', 'Manage Transactions - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Manage Transactions
                </h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Transactions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>#{{ $transaction->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $transaction->user->name }}</div>
                                        <small class="text-muted">{{ $transaction->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($transaction->type === 'topup')
                                    <span class="badge bg-info">Top Up</span>
                                @elseif($transaction->type === 'purchase')
                                    <span class="badge bg-primary">Purchase</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($transaction->type) }}</span>
                                @endif
                            </td>
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($transaction->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($transaction->status === 'success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($transaction->status === 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($transaction->payment_method === 'wallet')
                                    <span class="badge bg-primary">DompetKu</span>
                                @else
                                    <span class="badge bg-info">Payment Gateway</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                                    <p>No transactions found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
    color: #5a5c69;
}

.table td {
    vertical-align: middle;
    border-color: #e3e6f0;
}

.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #4e73df;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
}

.text-success {
    color: #1cc88a !important;
}

.text-muted {
    color: #858796 !important;
}
</style>
@endsection
