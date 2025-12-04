@extends('layouts.app')

@section('title', 'Register - JajanGaming')

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
        width: 100px;
        height: 100px;
        top: 15%;
        left: 5%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        width: 150px;
        height: 150px;
        top: 70%;
        right: 5%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        width: 80px;
        height: 80px;
        top: 30%;
        left: 85%;
        animation-delay: 4s;
    }

    .shape:nth-child(4) {
        width: 60px;
        height: 60px;
        top: 80%;
        left: 20%;
        animation-delay: 1s;
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

    .form-floating input,
    .form-floating select {
        height: 60px;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        color: #212529 !important;
    }

    .form-floating input:focus,
    .form-floating select:focus {
        border-color: #0d6efd;
        color: #212529 !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        background: white;
        transform: translateY(-2px);
    }
    
    .form-floating input::placeholder,
    .form-floating select::placeholder {
        color: #6c757d !important;
    }

    .form-floating label {
        padding: 1rem 1.5rem;
        color: #6c757d;
        font-weight: 500;
    }

    .role-selection {
        margin-bottom: 1.5rem;
    }

    .role-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1rem;
    }

    .role-option {
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .role-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .role-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .role-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transition: left 0.5s;
    }

    .role-option input[type="radio"]:checked + .role-card {
        border-color: #0d6efd;
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.2);
    }

    .role-option input[type="radio"]:checked + .role-card::before {
        left: 100%;
    }

    .role-card i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #0d6efd;
    }

    .role-card h5 {
        margin: 0.5rem 0;
        font-weight: 600;
        color: #333;
    }

    .role-card p {
        margin: 0;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .btn-register {
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

    .btn-register::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-register:hover::before {
        left: 100%;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
    }

    .login-link a {
        color: #0d6efd;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: #20c997;
        text-decoration: underline;
    }

    .benefits {
        background: rgba(13, 110, 253, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .benefits h6 {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .benefit-item i {
        color: #28a745;
        margin-right: 0.5rem;
        width: 16px;
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
        
        .form-floating input,
        .form-floating select {
            height: 50px;
            padding: 0.8rem 1rem;
        }
        
        .btn-register {
            padding: 12px 20px;
            font-size: 1rem;
        }

        .role-options {
            grid-template-columns: 1fr;
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
        <div class="shape"></div>
    </div>
    
    <div class="container" style="position: relative; z-index: 10;">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2><i class="fas fa-rocket me-2"></i>Join JajanGaming!</h2>
                        <p>Start your gaming business journey today</p>
                    </div>
                    
                    <div class="p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Enter your full name" required>
                                <label for="name"><i class="fas fa-user me-2"></i>Full Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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

                            <div class="form-floating">
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Confirm your password" required>
                                <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                            </div>

                            <div class="role-selection">
                                <label class="form-label fw-bold"><i class="fas fa-users me-2"></i>Choose Your Account Type</label>
                                <div class="role-options">
                                    <div class="role-option">
                                        <input type="radio" id="user" name="role" value="user" {{ old('role') == 'user' ? 'checked' : '' }}>
                                        <label for="user" class="role-card">
                                            <i class="fas fa-user"></i>
                                            <h5>Customer</h5>
                                            <p>Buy gaming products</p>
                                        </label>
                                    </div>
                                    <div class="role-option">
                                        <input type="radio" id="seller" name="role" value="seller" {{ old('role') == 'seller' ? 'checked' : '' }}>
                                        <label for="seller" class="role-card">
                                            <i class="fas fa-store"></i>
                                            <h5>Seller</h5>
                                            <p>Sell gaming products</p>
                                        </label>
                                    </div>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="benefits">
                                <h6><i class="fas fa-star me-2"></i>Why Choose JajanGaming?</h6>
                                <div class="benefit-item">
                                    <i class="fas fa-check"></i>
                                    <span>Instant product management</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-check"></i>
                                    <span>Real-time sales tracking</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-check"></i>
                                    <span>Secure payment processing</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-check"></i>
                                    <span>24/7 customer support</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-register">
                                <i class="fas fa-rocket me-2"></i>Create Account
                            </button>
                        </form>

                        <div class="login-link">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('login') }}">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
