@extends('layouts.app')

@section('title', 'Payment Processing - JajanGaming')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Cart
            </a>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .payment-process {
            margin-bottom: 2rem;
        }
        
        .payment-process .card-body {
            padding: 1rem;
        }
        
        .payment-info {
            margin-bottom: 1.5rem;
        }
        
        .payment-info .row {
            flex-direction: column;
        }
        
        .payment-info .col-md-6 {
            margin-bottom: 1rem;
        }
        
        .payment-info .col-md-6:last-child {
            margin-bottom: 0;
        }
        
        .payment-actions {
            margin-top: 1.5rem;
        }
        
        .payment-actions .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .payment-actions .btn:last-child {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 576px) {
        .payment-process .card-body {
            padding: 0.8rem;
        }
        
        .payment-process h5 {
            font-size: 1rem;
        }
        
        .payment-process .text-muted {
            font-size: 0.85rem;
        }
        
        .payment-info .card-body {
            padding: 0.8rem;
        }
        
        .payment-info h6 {
            font-size: 0.9rem;
        }
        
        .payment-info .text-muted {
            font-size: 0.8rem;
        }
        
        .payment-actions .btn {
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
                    <h4><i class="fas fa-credit-card me-2"></i>Payment Processing</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                        <h5>Processing Your Payment</h5>
                        <p class="text-muted">Please complete your payment to finish your order</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Order Details:</h6>
                        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                        <p><strong>Total Amount:</strong> <span class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                        <p><strong>Payment Method:</strong> <span class="badge bg-primary">Payment Gateway</span></p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Payment Gateway Simulation:</strong><br>
                        This is a demo payment gateway. Click the buttons below to simulate payment results.
                        In a real implementation, this would redirect to an actual payment gateway like Midtrans, Xendit, etc.
                    </div>
                    
                    <div class="d-grid gap-2">
                        <form action="{{ route('payment.success') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="transaction_id" value="{{ $order->transactions->first()->id ?? '' }}">
                            <button type="submit" class="btn btn-success btn-lg w-100 btn-slide btn-glow">
                                <i class="fas fa-check me-2"></i>Simulate Successful Payment
                            </button>
                        </form>
                        
                        <form action="{{ route('payment.failed') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="transaction_id" value="{{ $order->transactions->first()->id ?? '' }}">
                            <button type="submit" class="btn btn-danger btn-lg w-100 btn-slide btn-glow">
                                <i class="fas fa-times me-2"></i>Simulate Failed Payment
                            </button>
                        </form>
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-slide btn-glow">
                            <i class="fas fa-arrow-left me-2"></i>Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
