@extends('layouts.app')

@section('title', 'Register - JajanGaming')

@section('content')
<style>
    body {
        overflow-x: hidden;
    }

    .auth-split-container {
        display: flex;
        min-height: 85vh;
        width: 100%;
        position: relative;
        max-width: 1100px;
        margin: 0 auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border-radius: 20px;
        overflow: hidden;
        animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Left Side - Form */
    .auth-left {
        flex: 0 0 36%;
        background: linear-gradient(135deg, #0a0e27 0%, #1a1a3e 50%, #16213e 100%);
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 10;
        border-radius: 20px 0 0 20px;
        animation: fadeInLeft 0.8s ease-out 0.2s both;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .auth-close-btn {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .auth-close-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
        color: white;
        transform: scale(1.1);
    }

    .auth-form-container {
        max-width: 340px;
        width: 100%;
        margin: 0 auto;
        max-height: calc(85vh - 3rem);
        overflow-y: auto;
        padding-right: 0.5rem;
        padding-top: 2.5rem;
    }

    .auth-form-container::-webkit-scrollbar {
        width: 6px;
    }

    .auth-form-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .auth-form-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    .auth-title {
        color: #ffffff;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1.2rem;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-input-group {
        margin-bottom: 0.9rem;
        position: relative;
        animation: fadeInUp 0.8s ease-out both;
    }

    .auth-input-group:nth-child(1) {
        animation-delay: 0.5s;
    }

    .auth-input-group:nth-child(2) {
        animation-delay: 0.6s;
    }

    .auth-input-group:nth-child(3) {
        animation-delay: 0.7s;
    }

    .auth-input-group:nth-child(4) {
        animation-delay: 0.8s;
    }

    .auth-input-group label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        margin-bottom: 0.35rem;
        font-weight: 500;
    }

    .auth-input {
        width: 100%;
        padding: 0.7rem 0.9rem;
        background: rgba(108, 117, 165, 0.2);
        border: 2px solid rgba(108, 117, 165, 0.3);
        border-radius: 8px;
        color: #ffffff;
        font-size: 0.88rem;
        transition: all 0.3s ease;
    }

    .auth-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .auth-input:focus {
        outline: none;
        background: rgba(108, 117, 165, 0.3);
        border-color: #00d4aa;
        box-shadow: 0 0 0 3px rgba(0, 212, 170, 0.1);
    }

    .role-selection {
        margin-bottom: 1rem;
        animation: fadeInUp 0.8s ease-out 0.9s both;
    }

    .role-selection label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .role-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
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
        background: rgba(108, 117, 165, 0.2);
        border: 2px solid rgba(108, 117, 165, 0.3);
        border-radius: 8px;
        padding: 0.9rem 0.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .role-option input[type="radio"]:checked + .role-card {
        border-color: #00d4aa;
        background: rgba(0, 212, 170, 0.2);
    }

    .role-card i {
        font-size: 1.4rem;
        color: #00d4aa;
        margin-bottom: 0.4rem;
        display: block;
    }

    .role-card h5 {
        margin: 0.3rem 0 0 0;
        font-size: 0.88rem;
        color: #ffffff;
        font-weight: 600;
    }

    .role-card p {
        margin: 0.2rem 0 0 0;
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .auth-submit-btn {
        width: 100%;
        padding: 0.7rem;
        background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 0.92rem;
        font-weight: 600;
        margin-top: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
        animation: fadeInUp 0.8s ease-out 1s both;
    }

    .auth-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 212, 170, 0.5);
    }

    .auth-signup-text {
        text-align: center;
        margin-top: 1.2rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        animation: fadeInUp 0.8s ease-out 1.1s both;
    }

    .auth-signup-text a {
        color: #ffffff;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .auth-signup-text a:hover {
        color: #00d4aa;
    }

    /* Right Side - Image */
    .auth-right {
        flex: 1;
        position: relative;
        overflow: hidden;
        border-radius: 0 20px 20px 0;
        animation: fadeInRight 0.8s ease-out 0.3s both;
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .auth-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        animation: zoomIn 0.8s ease-out 0.5s both;
    }

    @keyframes zoomIn {
        from {
            transform: scale(1.1);
        }
        to {
            transform: scale(1);
        }
    }

    .auth-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(10, 14, 39, 0.3) 0%, rgba(26, 26, 62, 0.5) 100%);
    }

    /* Error Messages */
    .auth-error {
        background: rgba(220, 53, 69, 0.2);
        border: 1px solid rgba(220, 53, 69, 0.4);
        border-radius: 8px;
        padding: 0.75rem;
        color: #ff6b6b;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .auth-split-container {
            flex-direction: column;
            border-radius: 0;
            box-shadow: none;
        }

        .auth-left {
            flex: 0 0 auto;
            min-height: 100vh;
            border-radius: 0;
        }

        .auth-right {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .auth-left {
            padding: 1.5rem 1rem;
        }

        .auth-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .auth-close-btn {
            top: 1rem;
            left: 1rem;
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="auth-split-container">
    <!-- Left Side - Form -->
    <div class="auth-left">
        <a href="{{ route('home') }}" class="auth-close-btn">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="auth-form-container">
            <h1 class="auth-title">Create Account</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="auth-input-group">
                    <label for="name">Full Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="auth-input @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="Enter your full name"
                           required 
                           autofocus>
                    @error('name')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-input-group">
                    <label for="email">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="auth-input @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="Enter your email"
                           required>
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-input-group">
                    <label for="password">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="auth-input @error('password') is-invalid @enderror" 
                           placeholder="Enter your password"
                           required>
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="auth-input" 
                           placeholder="Confirm your password"
                           required>
                </div>

                <div class="role-selection">
                    <label>Account Type</label>
                    <div class="role-options">
                        <div class="role-option">
                            <input type="radio" id="user" name="role" value="user" {{ old('role') == 'user' ? 'checked' : '' }}>
                            <label for="user" class="role-card">
                                <i class="fas fa-user"></i>
                                <h5>Customer</h5>
                                <p>Buy products</p>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="seller" name="role" value="seller" {{ old('role') == 'seller' ? 'checked' : '' }}>
                            <label for="seller" class="role-card">
                                <i class="fas fa-store"></i>
                                <h5>Seller</h5>
                                <p>Sell products</p>
                            </label>
                        </div>
                    </div>
                    @error('role')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="auth-submit-btn">
                    Create Account
                </button>
            </form>

            <p class="auth-signup-text">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>

    <!-- Right Side - Image -->
    <div class="auth-right">
        <img src="{{ asset('img/gambar 3.jpg') }}" alt="Gaming Background" class="auth-bg-image">
        <div class="auth-bg-overlay"></div>
    </div>
</div>
@endsection
