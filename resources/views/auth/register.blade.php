@extends('layouts.app')

@section('title', 'Register - JajanGaming')

@section('content')
    <style>
        body {
            overflow-x: hidden;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a3e 50%, #16213e 100%) !important;
            min-height: 100vh;
        }

        /* Soft Animated Background */
        .auth-bg-floats {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .float-element {
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.04;
            animation: float-soft 10s ease-in-out infinite;
            color: #00d4aa;
        }

        .float-element:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
        .float-element:nth-child(2) { top: 50%; right: 8%; animation-delay: 3s; }
        .float-element:nth-child(3) { bottom: 15%; left: 15%; animation-delay: 6s; }

        @keyframes float-soft {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        .auth-container {
            display: flex;
            min-height: calc(100vh - 76px);
            width: 100%;
            max-width: none;
            margin: 0;
            box-shadow: none;
            border-radius: 0;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
            border: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Left Side - Form */
        .auth-left {
            flex: 0 0 40%;
            background: linear-gradient(135deg, #0f1a24 0%, #1a2a3a 100%);
            padding: 2rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            z-index: 10;
            border-radius: 0;
            animation: slideInLeft 0.7s ease-out;
            border-right: 1px solid rgba(0, 212, 170, 0.1);
            overflow-y: auto;
            max-height: 100vh;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .auth-form-wrapper {
            max-width: 360px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 5;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 1.5rem;
            margin-top: 1rem;
            animation: slideDown 0.7s ease-out 0.2s both;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.2);
        }

        .auth-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .auth-logo-main {
            font-size: 1.3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #00d4aa 0%, #64e0fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-logo-sub {
            font-size: 0.6rem;
            color: rgba(0, 212, 170, 0.7);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-top: 2px;
        }

        .auth-title {
            color: #ffffff;
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.3rem;
            animation: slideDown 0.7s ease-out 0.3s both;
        }

        .auth-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
            animation: slideDown 0.7s ease-out 0.4s both;
            line-height: 1.5;
        }

        .auth-form {
            animation: slideDown 0.7s ease-out 0.5s both;
        }

        .auth-input-group {
            margin-bottom: 1rem;
            position: relative;
            animation: slideDown 0.7s ease-out both;
        }

        .auth-input-group:nth-child(1) { animation-delay: 0.6s; }
        .auth-input-group:nth-child(2) { animation-delay: 0.65s; }
        .auth-input-group:nth-child(3) { animation-delay: 0.7s; }
        .auth-input-group:nth-child(4) { animation-delay: 0.75s; }

        .auth-input-group label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin-bottom: 0.4rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .auth-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(0, 212, 170, 0.2);
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.85rem;
            transition: all 0.4s ease;
            font-weight: 500;
        }

        .auth-input::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .auth-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(0, 212, 170, 0.5);
            box-shadow: 0 0 20px rgba(0, 212, 170, 0.15), inset 0 0 15px rgba(0, 212, 170, 0.05);
        }

        .role-selection {
            margin-bottom: 1.2rem;
            animation: slideDown 0.7s ease-out 0.8s both;
        }

        .role-selection label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin-bottom: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .role-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.7rem;
        }

        .role-option {
            position: relative;
            cursor: pointer;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .role-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(0, 212, 170, 0.2);
            border-radius: 10px;
            padding: 1rem 0.7rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .role-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(0, 212, 170, 0.4);
            transform: translateY(-2px);
        }

        .role-option input[type="radio"]:checked + .role-card {
            border-color: #00d4aa;
            background: rgba(0, 212, 170, 0.12);
            box-shadow: 0 0 15px rgba(0, 212, 170, 0.2);
        }

        .role-card i {
            font-size: 1.4rem;
            color: #00d4aa;
            margin-bottom: 0.4rem;
            display: block;
        }

        .role-card h5 {
            margin: 0.3rem 0 0 0;
            font-size: 0.8rem;
            color: #ffffff;
            font-weight: 700;
        }

        .role-card p {
            margin: 0.2rem 0 0 0;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .auth-submit-btn {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 0.9rem;
            font-weight: 700;
            margin-top: 1rem;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.25);
            animation: slideDown 0.7s ease-out 0.9s both;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .auth-submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            transition: left 0.6s ease;
        }

        .auth-submit-btn:hover::before {
            left: 100%;
        }

        .auth-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 212, 170, 0.4);
        }

        .auth-submit-btn:active {
            transform: translateY(0);
        }

        .auth-submit-btn.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 6px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .auth-signup-text {
            text-align: center;
            margin-top: 1rem;
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.8rem;
            animation: slideDown 0.7s ease-out 1s both;
        }

        .auth-signup-text a {
            color: #00d4aa;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .auth-signup-text a:hover {
            color: #64e0fc;
        }

        /* Right Side - Hero */
        .auth-right {
            flex: 1;
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.7s ease-out;
            background: linear-gradient(135deg, rgba(0, 159, 227, 0.05) 0%, rgba(0, 212, 170, 0.02) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .auth-hero-content {
            position: relative;
            width: 90%;
            max-width: 500px;
            z-index: 5;
            text-align: center;
        }

        .auth-bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.85) saturate(1.1);
            z-index: 1;
        }

        .auth-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.5) 0%, rgba(26, 26, 62, 0.6) 100%);
            z-index: 2;
        }

        .auth-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 212, 170, 0.1);
            border: 1px solid rgba(0, 212, 170, 0.3);
            color: #00d4aa;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
            animation: fadeInUp 0.8s ease-out 0.3s both;
        }

        .auth-hero-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 900;
            margin-bottom: 1rem;
            line-height: 1.3;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .auth-hero-description {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out 0.5s both;
        }

        .auth-hero-benefits {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.85rem;
        }

        .benefit-item i {
            color: #00d4aa;
            font-size: 1rem;
        }

        .auth-error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 8px;
            padding: 0.5rem 0.65rem;
            color: #ff7f7f;
            font-size: 0.75rem;
            margin-top: 0.4rem;
            animation: shake 0.4s ease-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .auth-left { flex: 0 0 50%; }
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                min-height: auto;
            }

            .auth-left {
                flex: 0 0 auto;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid rgba(0, 212, 170, 0.1);
                padding: 1.5rem;
            }

            .auth-right {
                display: none;
            }

            .auth-form-wrapper {
                max-width: 100%;
            }

            .auth-title {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .auth-left {
                padding: 1.5rem 1rem;
            }

            .auth-logo {
                margin-bottom: 1rem;
                margin-top: 0.5rem;
            }

            .auth-title {
                font-size: 1.3rem;
                margin-bottom: 0.2rem;
            }
        }
    </style>

    <div class="auth-bg-floats">
        <div class="float-element">💎</div>
        <div class="float-element">🎮</div>
        <div class="float-element">⭐</div>
    </div>

    <div class="auth-container">
        <!-- Left Side -->
        <div class="auth-left">
            <div class="auth-form-wrapper">
                <div class="auth-logo">
                    <div class="auth-logo-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="auth-logo-text">
                        <div class="auth-logo-main">JajanGaming</div>
                        <div class="auth-logo-sub">Robux Marketplace</div>
                    </div>
                </div>

                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join the trusted Robux marketplace community</p>

                <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
                    @csrf

                    <div class="auth-input-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name"
                            class="auth-input @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}"
                            placeholder="Your full name" 
                            required autofocus>
                        @error('name')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="auth-input @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}"
                            placeholder="your@email.com" 
                            required>
                        @error('email')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                            class="auth-input @error('password') is-invalid @enderror" 
                            placeholder="Minimum 8 characters"
                            required>
                        @error('password')
                            <div class="auth-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                            class="auth-input" 
                            placeholder="Re-enter your password" 
                            required>
                    </div>

                    <div class="role-selection">
                        <label>I want to</label>
                        <div class="role-options">
                            <div class="role-option">
                                <input type="radio" id="user" name="role" value="user"
                                    {{ old('role', 'user') == 'user' ? 'checked' : '' }} required>
                                <label for="user" class="role-card">
                                    <i class="fas fa-shopping-cart"></i>
                                    <h5>Buy Robux</h5>
                                    <p>Purchase Robux</p>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" id="seller" name="role" value="seller"
                                    {{ old('role') == 'seller' ? 'checked' : '' }}>
                                <label for="seller" class="role-card">
                                    <i class="fas fa-store"></i>
                                    <h5>Sell Robux</h5>
                                    <p>Become seller</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="auth-submit-btn" id="submitBtn">
                        <span id="btnText">Create Account</span>
                    </button>
                </form>

                <p class="auth-signup-text">
                    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                </p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="auth-right">
            <img src="{{ asset('img/gambar 3.jpg') }}" alt="Gaming" class="auth-bg-image">
            <div class="auth-overlay"></div>
            
            <div class="auth-hero-content">
                <div class="auth-hero-badge">
                    <i class="fas fa-check-circle"></i>
                    100% SAFE & VERIFIED
                </div>

                <h2 class="auth-hero-title">Start Trading Today</h2>
                
                <p class="auth-hero-description">
                    Join thousands of gamers trading safely on JajanGaming. Fast verification and instant transactions.
                </p>

                <div class="auth-hero-benefits">
                    <div class="benefit-item">
                        <i class="fas fa-bolt"></i>
                        Instant Verification
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-shield-alt"></i>
                        Secure Transactions
                    </div>
                    <div class="benefit-item">
                        <i class="fas fa-headset"></i>
                        24/7 Support
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            btn.classList.add('loading');
            btnText.innerHTML = '<span class="spinner"></span>Creating account...';
        });
    </script>
@endsection
