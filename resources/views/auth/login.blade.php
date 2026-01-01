@extends('layouts.app')

@section('title', 'Login - JajanGaming')

@section('content')
<style>
    body {
        overflow-x: hidden;
        background: linear-gradient(135deg, #0a0e27 0%, #1a1a3e 50%, #16213e 100%) !important;
        min-height: 100vh;
    }

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
        overflow: hidden;
    }

    .auth-left {
        flex: 0 0 40%;
        background: linear-gradient(135deg, #0f1a24 0%, #1a2a3a 100%);
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 10;
        border-right: 1px solid rgba(0, 212, 170, 0.1);
        overflow-y: auto;
        max-height: 100vh;
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
        margin-bottom: 2.5rem;
    }

    .auth-logo-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 212, 170, 0.2);
    }

    .auth-logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1;
    }

    .auth-logo-main {
        font-size: 1.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #00d4aa 0%, #64e0fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .auth-logo-sub {
        font-size: 0.65rem;
        color: rgba(0, 212, 170, 0.7);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        margin-top: 2px;
    }

    .auth-title {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
        margin-bottom: 2.5rem;
        line-height: 1.5;
    }

    .auth-input-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .auth-input-group label {
        display: block;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        margin-bottom: 0.6rem;
        font-weight: 600;
    }

    .password-input-wrapper {
        position: relative;
        margin-bottom: 2rem;
    }

    .auth-input {
        width: 100%;
        padding: 0.85rem 1rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(0, 212, 170, 0.2);
        border-radius: 10px;
        color: #ffffff;
        font-size: 0.9rem;
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

    .auth-icon {
        position: absolute;
        right: 1rem;
        color: rgba(0, 212, 170, 0.5);
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .auth-icon:hover {
        color: rgba(0, 212, 170, 0.8);
    }

    .auth-forgot {
        display: block;
        text-align: right;
        color: rgba(0, 212, 170, 0.7);
        font-size: 0.75rem;
        text-decoration: none;
        margin-top: 1.2rem;
        transition: color 0.3s ease;
        font-weight: 600;
    }

    .auth-forgot:hover {
        color: #00d4aa;
    }

    .auth-submit-btn {
        width: 100%;
        padding: 0.95rem;
        background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 0.95rem;
        font-weight: 700;
        margin-top: 2rem;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 4px 15px rgba(0, 212, 170, 0.25);
    }

    .auth-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 212, 170, 0.4);
    }

    .auth-submit-btn:active {
        transform: translateY(0);
    }

    .auth-signup-text {
        text-align: center;
        margin-top: 1.5rem;
        color: rgba(255, 255, 255, 0.65);
        font-size: 0.85rem;
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

    .auth-right {
        flex: 1;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(0, 159, 227, 0.05) 0%, rgba(0, 212, 170, 0.02) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
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

    .auth-hero-content {
        position: relative;
        width: 90%;
        max-width: 500px;
        z-index: 5;
        text-align: center;
    }

    .auth-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0, 212, 170, 0.1);
        border: 1px solid rgba(0, 212, 170, 0.3);
        color: #00d4aa;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .auth-hero-title {
        color: white;
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .auth-hero-description {
        color: rgba(255, 255, 255, 0.75);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .auth-stats {
        display: flex;
        gap: 2rem;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        margin-top: 2rem;
    }

    .stat-item {
        text-align: center;
        flex: 0 0 auto;
        min-width: 100px;
    }

    .stat-number {
        font-size: 1.6rem;
        font-weight: 900;
        color: #00d4aa;
        display: block;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.65);
        margin-top: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }

    @media (max-width: 768px) {
        .auth-stats {
            gap: 1rem;
        }

        .stat-item {
            flex: 0 0 calc(50% - 0.5rem);
        }

        .stat-number {
            font-size: 1.4rem;
        }
    }

    .auth-error {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        border-radius: 8px;
        padding: 0.65rem 0.75rem;
        color: #ff7f7f;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

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
            padding: 2rem;
        }

        .auth-right {
            display: none;
        }

        .auth-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .auth-left {
            padding: 1.5rem 1rem;
        }

        .auth-title {
            font-size: 1.4rem;
            margin-bottom: 0.3rem;
        }
    }
</style>

<div class="auth-bg-floats">
    <div class="float-element">💎</div>
    <div class="float-element">🎮</div>
    <div class="float-element">⭐</div>
</div>

<div class="auth-container">
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

            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your account and continue your Robux journey</p>

            <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                @csrf

                <div class="auth-input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="auth-input @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}"
                        placeholder="your@email.com" 
                        required autofocus>
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-input-group">
                    <label for="password">Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="password" name="password"
                            class="auth-input @error('password') is-invalid @enderror" 
                            placeholder="••••••••"
                            required>
                        <span class="auth-icon" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                    <a href="#" class="auth-forgot">Forgot your password?</a>
                </div>

                <button type="submit" class="auth-submit-btn">
                    Sign In
                </button>
            </form>

            <p class="auth-signup-text">
                Don't have an account? <a href="{{ route('register') }}">Create one now</a>
            </p>
        </div>
    </div>

    <div class="auth-right">
        <img src="{{ asset('img/gambar 3.jpg') }}" alt="Gaming" class="auth-bg-image">
        <div class="auth-overlay"></div>
        
        <div class="auth-hero-content">
            <div class="auth-hero-badge">
                <i class="fas fa-shield-alt"></i>
                SECURE & TRUSTED
            </div>

            <h2 class="auth-hero-title">Join Thousands of Gamers</h2>
            
            <p class="auth-hero-description">
                Trade Robux safely with the most trusted marketplace. Fast, secure, and verified sellers.
            </p>

            <div class="auth-stats">
                <div class="stat-item">
                    <span class="stat-number" id="userCount">0</span>
                    <span class="stat-label">Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" id="transactionCount">0</span>
                    <span class="stat-label">Transactions</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" id="ratingCount">0</span>
                    <span class="stat-label">Avg Rating</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }

    function animateNumber(elementId, finalValue, isFraction = false) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        const target = parseFloat(finalValue);
        const increment = Math.ceil(target / 50);
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = isFraction ? target.toFixed(1) : target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = isFraction ? current.toFixed(1) : current.toLocaleString();
            }
        }, 30);
    }

    async function fetchStats() {
        try {
            const response = await fetch('{{ route("api.stats") }}');
            const data = await response.json();
            
            animateNumber('userCount', data.users);
            animateNumber('transactionCount', data.transactions);
            animateNumber('ratingCount', data.avgRating, true);
        } catch (error) {
            console.log('Stats loaded');
        }
    }

    window.addEventListener('load', fetchStats);
</script>

@endsection
