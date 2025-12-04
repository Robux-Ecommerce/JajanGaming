@extends('layouts.app')

@section('title', 'Login - JajanGaming')

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
        flex: 0 0 32%;
        background: linear-gradient(135deg, #0a0e27 0%, #1a1a3e 50%, #16213e 100%);
        padding: 1.5rem;
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
        max-width: 300px;
        width: 100%;
        margin: 0 auto;
    }

    .auth-title {
        color: #ffffff;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 1.8rem;
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
        margin-bottom: 1rem;
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

    .auth-input-group label {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        margin-bottom: 0.35rem;
        font-weight: 500;
    }

    .auth-input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        background: rgba(108, 117, 165, 0.2);
        border: 2px solid rgba(108, 117, 165, 0.3);
        border-radius: 8px;
        color: #ffffff;
        font-size: 0.85rem;
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

    .auth-input-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }

    .auth-input-icon:hover {
        color: rgba(255, 255, 255, 0.8);
    }

    .auth-forgot-link {
        display: block;
        text-align: right;
        color: #00d4aa;
        font-size: 0.75rem;
        text-decoration: none;
        margin-top: 0.3rem;
        transition: color 0.3s ease;
    }

    .auth-forgot-link:hover {
        color: #00a8cc;
    }

    .auth-submit-btn {
        width: 100%;
        padding: 0.65rem;
        background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
        animation: fadeInUp 0.8s ease-out 0.8s both;
    }

    .auth-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 212, 170, 0.5);
    }

    .auth-signup-text {
        text-align: center;
        margin-top: 1rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        animation: fadeInUp 0.8s ease-out 0.9s both;
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
            <h1 class="auth-title">Welcome Back</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-input-group">
                    <label for="email">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="auth-input @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="Enter your email"
                           required 
                           autofocus>
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-input-group">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="auth-input @error('password') is-invalid @enderror" 
                               placeholder="Enter your password"
                               required>
                        <span class="auth-input-icon" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                    <a href="#" class="auth-forgot-link">Forgot your password?</a>
                </div>

                <button type="submit" class="auth-submit-btn">
                    Log in
                </button>
            </form>

            <p class="auth-signup-text">
                Don't have an account? <a href="{{ route('register') }}">Sign up</a>
            </p>
        </div>
    </div>

    <!-- Right Side - Image -->
    <div class="auth-right">
        <img src="{{ asset('img/gambar 3.jpg') }}" alt="Gaming Background" class="auth-bg-image">
        <div class="auth-bg-overlay"></div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
