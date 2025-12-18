@extends('layouts.app')

@section('title', 'Wallet Top Up - JajanGaming')

@section('content')<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'Top Up'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;"><style>
    .topup-page {
        background: linear-gradient(180deg, #121a24 0%, #1a2a38 100%);
        min-height: 100vh;
        padding: 2rem 0;
        display: flex;
        align-items: center;
    }

    .topup-container {
        max-width: 480px;
        margin: 0 auto;
        width: 100%;
    }

    /* Main Card */
    .topup-card {
        background: linear-gradient(145deg, rgba(37, 48, 64, 0.9) 0%, rgba(30, 42, 54, 0.95) 100%);
        border-radius: 20px;
        border: 1px solid rgba(100, 160, 180, 0.15);
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        position: relative;
    }

    .topup-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #64a0b4, #6fcf6f, #64a0b4);
        background-size: 200% 100%;
        animation: gradientMove 3s ease infinite;
    }

    @keyframes gradientMove {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Header */
    .topup-header {
        padding: 2rem 2rem 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(100, 160, 180, 0.1);
        background: rgba(0, 0, 0, 0.15);
    }

    .topup-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(111, 207, 111, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        position: relative;
    }

    .topup-icon::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        background: linear-gradient(135deg, #64a0b4, #6fcf6f);
        z-index: -1;
        opacity: 0.5;
    }

    .topup-icon i {
        font-size: 2rem;
        background: linear-gradient(135deg, #64a0b4, #6fcf6f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .topup-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .topup-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
    }

    /* Body */
    .topup-body {
        padding: 1.75rem 2rem;
    }

    /* Amount Display */
    .amount-display {
        background: linear-gradient(135deg, rgba(100, 160, 180, 0.1) 0%, rgba(111, 207, 111, 0.1) 100%);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .amount-display::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(100, 160, 180, 0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .amount-label {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
        position: relative;
    }

    .amount-value {
        color: #6fcf6f;
        font-size: 2.25rem;
        font-weight: 800;
        position: relative;
    }

    .amount-currency {
        font-size: 1rem;
        color: rgba(111, 207, 111, 0.7);
        font-weight: 600;
        margin-right: 0.25rem;
    }

    /* Info Alert */
    .info-alert {
        background: rgba(100, 160, 180, 0.1);
        border: 1px solid rgba(100, 160, 180, 0.2);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .info-alert i {
        color: #64a0b4;
        font-size: 1rem;
        margin-top: 0.1rem;
    }

    .info-alert p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        margin: 0;
        line-height: 1.5;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .btn-payment {
        width: 100%;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn-payment::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-payment:hover::before {
        left: 100%;
    }

    .btn-success-payment {
        background: linear-gradient(135deg, #5cb85c 0%, #4a9a4a 100%);
        color: white;
        box-shadow: 0 4px 20px rgba(92, 184, 92, 0.3);
    }

    .btn-success-payment:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(92, 184, 92, 0.4);
    }

    .btn-fail-payment {
        background: linear-gradient(135deg, #dc5454 0%, #c04444 100%);
        color: white;
        box-shadow: 0 4px 20px rgba(220, 84, 84, 0.3);
    }

    .btn-fail-payment:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(220, 84, 84, 0.4);
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Divider */
    .divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0.5rem 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(100, 160, 180, 0.15);
    }

    .divider span {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Security Badge */
    .security-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem;
        border-top: 1px solid rgba(100, 160, 180, 0.1);
        background: rgba(0, 0, 0, 0.1);
    }

    .security-badge i {
        color: #6fcf6f;
        font-size: 0.85rem;
    }

    .security-badge span {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.7rem;
    }

    /* Quick Amount Options */
    .quick-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.65rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 0.75rem;
        text-align: center;
    }

    .info-item-icon {
        color: #64a0b4;
        font-size: 1rem;
        margin-bottom: 0.35rem;
    }

    .info-item-label {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item-value {
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Floating Elements */
    .floating-coins {
        position: absolute;
        top: 20%;
        right: 10%;
        opacity: 0.1;
        font-size: 3rem;
        color: #64a0b4;
        animation: float 3s ease-in-out infinite;
    }

    .floating-coins:nth-child(2) {
        top: 60%;
        left: 10%;
        animation-delay: 1.5s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .topup-page { padding: 1rem 0; }
        .topup-container { padding: 0 1rem; }
        .topup-header { padding: 1.5rem 1.25rem 1.25rem; }
        .topup-body { padding: 1.25rem; }
        .topup-icon { width: 65px; height: 65px; }
        .topup-icon i { font-size: 1.5rem; }
        .topup-title { font-size: 1.25rem; }
        .amount-value { font-size: 1.75rem; }
        .btn-payment { padding: 0.85rem 1.25rem; font-size: 0.85rem; }
        .quick-info { grid-template-columns: repeat(3, 1fr); gap: 0.5rem; }
        .info-item { padding: 0.6rem 0.4rem; }
    }
</style>

<div class="topup-page">
    <div class="topup-container">
        <div class="topup-card">
            <i class="fas fa-coins floating-coins"></i>
            <i class="fas fa-coins floating-coins"></i>
            
            <!-- Header -->
            <div class="topup-header">
                <div class="topup-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h1 class="topup-title">Wallet Top Up</h1>
                <p class="topup-subtitle">Complete your payment to add funds</p>
            </div>

            <!-- Body -->
            <div class="topup-body">
                <!-- Amount Display -->
                <div class="amount-display">
                    <div class="amount-label">Top Up Amount</div>
                    <div class="amount-value">
                        <span class="amount-currency">Rp</span>{{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="quick-info">
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-bolt"></i></div>
                        <div class="info-item-label">Process</div>
                        <div class="info-item-value">Instant</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="info-item-label">Security</div>
                        <div class="info-item-value">Secure</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon"><i class="fas fa-percentage"></i></div>
                        <div class="info-item-label">Fee</div>
                        <div class="info-item-value">0%</div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="info-alert">
                    <i class="fas fa-info-circle"></i>
                    <p>This is a demo payment gateway. Click the buttons below to simulate payment results for testing purposes.</p>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <form action="{{ route('payment.success') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <button type="submit" class="btn-payment btn-success-payment">
                            <i class="fas fa-check-circle"></i>
                            Simulate Successful Payment
                        </button>
                    </form>
                    
                    <form action="{{ route('payment.failed') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <button type="submit" class="btn-payment btn-fail-payment">
                            <i class="fas fa-times-circle"></i>
                            Simulate Failed Payment
                        </button>
                    </form>

                    <div class="divider">
                        <span>or</span>
                    </div>

                    <a href="{{ route('wallet.index') }}" class="btn-payment btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Back to Wallet
                    </a>
                </div>
            </div>

            <!-- Security Badge -->
            <div class="security-badge">
                <i class="fas fa-lock"></i>
                <span>Secured by JajanGaming Payment System</span>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
