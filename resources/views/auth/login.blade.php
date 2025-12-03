@extends('layouts.app')

@section('title', 'Login - JajanGaming')

@section('content')
<style>
    .auth-container {
        min-height: 100vh;
        position: relative; /* allow normal document flow & scrolling */
        overflow: visible;
    }

    /* Full-page background layer behind header/content */
    .auth-container::before {
        content: '';
        position: fixed;
        inset: 0; /* top:0; right:0; bottom:0; left:0 */
        background: linear-gradient(135deg, #0d6efd 0%, #20c997 100%);
        z-index: -1; /* behind everything incl. header */
    }

    .auth-container::after {
        content: '';
        position: fixed;
        inset: 0;
        background: url('{{ asset("img/roblox.jpg") }}') center/cover;
        opacity: 0.1;
        z-index: -1;
    }

    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 10%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        width: 60px;
        height: 60px;
        top: 40%;
        left: 80%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 10;
        animation: slideUp 0.8s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-header {
        background: linear-gradient(135deg, #0d6efd 0%, #20c997 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .auth-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 10s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .auth-header h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        position: relative;
        z-index: 2;
    }

    .auth-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .form-floating {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-floating input {
        height: 60px;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .form-floating input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        background: white;
        transform: translateY(-2px);
    }

    .form-floating label {
        padding: 1rem 1.5rem;
        color: #6c757d;
        font-weight: 500;
    }

    .btn-login {
        background: linear-gradient(135deg, #0d6efd 0%, #20c997 100%);
        border: none;
        border-radius: 15px;
        padding: 15px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .remember-me {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        border-radius: 5px;
        border: 2px solid #0d6efd;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .forgot-password {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .forgot-password:hover {
        color: #20c997;
    }

    .register-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
    }

    .register-link a {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .register-link a:hover {
        color: #20c997;
        text-decoration: underline;
    }

    .social-login {
        margin-top: 1.5rem;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        background: white;
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 0.5rem;
    }

    .social-btn:hover {
        border-color: #0d6efd;
        color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .auth-card {
            margin: 1rem;
        }
        
        .auth-header {
            padding: 1.5rem;
        }
        
        .auth-header h2 {
            font-size: 1.5rem;
        }
        
        .form-floating input {
            height: 50px;
            padding: 0.8rem 1rem;
        }
        
        .btn-login {
            padding: 12px 20px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .auth-container {
            padding: 0.5rem;
        }
        
        .auth-card {
            margin: 0.5rem;
        }
        
        .auth-header {
            padding: 1rem;
        }
        
        .auth-header h2 {
            font-size: 1.3rem;
        }
    }
</style>

<div class="auth-container">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="container" style="position: relative; z-index: 10;">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2><i class="fas fa-gamepad me-2"></i>Welcome Back!</h2>
                        <p>Sign in to continue your gaming journey</p>
                    </div>
                    
                    <div class="p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="form-floating">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="Enter your email" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Enter your password" required>
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="remember-me">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="forgot-password">Forgot Password?</a>
                            </div>

                            <button type="submit" class="btn btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </form>

                        <div class="social-login">
                            <div class="text-center mb-3">
                                <span class="text-muted">Or continue with</span>
                            </div>
                            <a href="#" class="social-btn">
                                <i class="fab fa-google me-2"></i>Google
                            </a>
                            <a href="#" class="social-btn">
                                <i class="fab fa-facebook me-2"></i>Facebook
                            </a>
                        </div>

                        <div class="register-link">
                            <p class="mb-0">Don't have an account? 
                                <a href="{{ route('register') }}">Create Account</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
