@extends('layouts.app')

@section('title', 'Wallet Top Up - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('wallet.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Wallet
            </a>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .topup-process {
            margin-bottom: 2rem;
        }
        
        .topup-process .card-body {
            padding: 1rem;
        }
        
        .topup-info {
            margin-bottom: 1.5rem;
        }
        
        .topup-info .row {
            flex-direction: column;
        }
        
        .topup-info .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .topup-info .col-md-6:last-child {
            margin-bottom: 0;
        }
        
        .topup-actions {
            margin-top: 1.5rem;
        }
        
        .topup-actions .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .topup-actions .btn:last-child {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 576px) {
        .topup-process .card-body {
            padding: 0.8rem;
        }
        
        .topup-process h5 {
            font-size: 1rem;
        }
        
        .topup-process .text-muted {
            font-size: 0.85rem;
        }
        
        .topup-info .card-body {
            padding: 0.8rem;
        }
        
        .topup-info h6 {
            font-size: 0.9rem;
        }
        
        .topup-info .text-muted {
            font-size: 0.8rem;
        }
        
        .topup-actions .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4><i class="fas fa-plus-circle me-2"></i>Wallet Top Up</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-wallet fa-3x text-primary mb-3"></i>
                        <h5>Top Up Your Wallet</h5>
                        <p class="text-muted">Complete your wallet top up to add funds</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Top Up Details:</h6>
                        <p><strong>Amount:</strong> <span class="text-primary">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span></p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        This is a demo payment gateway. Click the buttons below to simulate payment results.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <form action="{{ route('payment.success') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                            <button type="submit" class="btn btn-success btn-lg w-100 btn-slide btn-glow">
                                <i class="fas fa-check me-2"></i>Simulate Successful Payment
                            </button>
                        </form>
                        
                        <form action="{{ route('payment.failed') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                            <button type="submit" class="btn btn-danger btn-lg w-100 btn-slide btn-glow">
                                <i class="fas fa-times me-2"></i>Simulate Failed Payment
                            </button>
                        </form>
                        
                        <a href="{{ route('wallet.index') }}" class="btn btn-outline-secondary btn-slide btn-glow">
                            <i class="fas fa-arrow-left me-2"></i>Back to Wallet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
