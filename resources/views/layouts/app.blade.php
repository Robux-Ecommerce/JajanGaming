<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JajanGaming - Top Up Robux Roblox')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00d4aa;
            --secondary-color: #1a1a2e;
            --accent-color: #16213e;
            --text-color: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.7);
            --bg-light: #0f0f1e;
            --bg-dark: #1a1a2e;
            --bg-card: #2a2a3e;
            --bg-input: #2a2a3e;
            --border-color: rgba(255, 255, 255, 0.1);
            --gradient-primary: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            --gradient-secondary: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }
        
        body {
            background-color: var(--bg-light);
            color: var(--text-color);
        }

        .navbar {
            background: #1a1a2e !important;
            border-bottom: none;
            transition: all 0.3s ease;
            position: sticky !important;
            top: 0 !important;
            z-index: 1050 !important;
            padding: 1rem 0;
            overflow: visible;
            width: 100%;
        }
        
        .navbar.scrolled {
            background: #1a1a2e !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: sticky !important;
            top: 0 !important;
        }
        
        .navbar.scrolled::after {
            background: linear-gradient(to right, 
                transparent 0%, 
                transparent 15%,
                rgba(0, 212, 255, 0.25) 25%,
                rgba(0, 212, 255, 0.45) 35%,
                rgba(0, 212, 255, 0.65) 42%,
                rgba(0, 212, 255, 0.8) 47%,
                rgba(0, 212, 255, 0.95) 50%,
                rgba(0, 212, 255, 0.8) 53%,
                rgba(0, 212, 255, 0.65) 58%,
                rgba(0, 212, 255, 0.45) 65%,
                rgba(0, 212, 255, 0.25) 75%,
                transparent 85%,
                transparent 100%) !important;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100vh;
            background: var(--bg-light);
            transition: all 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
            border-right: 1px solid rgba(0, 212, 170, 0.1);
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(0, 212, 170, 0.2);
            background: rgba(0, 212, 170, 0.05);
        }

        .sidebar-brand {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-brand:hover {
            color: #00a8cc;
            text-decoration: none;
        }

        .sidebar-brand i {
            margin-right: 0.5rem;
            font-size: 1.8rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav .nav-link {
            color: var(--text-color);
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar-nav .nav-link:hover {
            color: var(--primary-color);
            background: rgba(0, 212, 170, 0.1);
            transform: translateX(5px);
        }

        .sidebar-nav .nav-link.active {
            color: var(--primary-color);
            background: rgba(0, 212, 170, 0.15);
            font-weight: 600;
        }

        .sidebar-nav .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-color);
        }

        .sidebar-nav .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-nav .nav-link .badge {
            margin-left: auto;
            background: var(--primary-color);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        /* Sidebar Quick Actions Styling */
        .sidebar-quick-action {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.05) 0%, rgba(0, 168, 204, 0.05) 100%);
            border-left: 3px solid var(--primary-color);
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            border-radius: 8px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .sidebar-quick-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 170, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-quick-action:hover::before {
            left: 100%;
        }

        .sidebar-quick-action:hover {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.15) 0%, rgba(0, 168, 204, 0.15) 100%);
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.2);
        }

        .sidebar-quick-action i {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-quick-action:hover i {
            transform: scale(1.1);
            color: #00a8cc;
        }

        .sidebar-quick-action.active {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.2) 0%, rgba(0, 168, 204, 0.2) 100%);
            color: var(--primary-color);
            font-weight: 700;
        }

        .sidebar-quick-action.active i {
            color: #00a8cc;
        }

        /* Sidebar Notification Styling */
        .sidebar-notification {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.05) 0%, rgba(255, 152, 0, 0.05) 100%);
            border-left: 3px solid #ffc107;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            border-radius: 8px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .sidebar-notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 193, 7, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-notification:hover::before {
            left: 100%;
        }

        .sidebar-notification:hover {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 152, 0, 0.15) 100%);
            transform: translateX(8px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }

        .sidebar-notification i {
            color: #ffc107;
            font-size: 1.2rem;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-notification:hover i {
            transform: scale(1.1);
            color: #ff9800;
        }

        .sidebar-notification-badge {
            background: #dc3545 !important;
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Navbar Notification Bell */
        #notificationBell {
            position: relative;
            transition: all 0.3s ease;
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            color: #ffffff !important;
        }

        #notificationBell:hover {
            transform: scale(1.1);
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #ffffff !important;
        }

        #notificationBadge {
            font-size: 0.7rem;
            animation: pulse 2s infinite;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Navbar spacing improvements */
        .navbar-nav .nav-item {
            margin: 0 0.75rem; /* Spacing lebih besar lagi */
        }

        .navbar-nav .nav-link {
            padding: 0.6rem 1rem; /* Padding lebih besar lagi */
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        /* Navbar container padding */
        .navbar {
            padding: 1rem 0; /* Padding vertikal lebih besar */
        }

        .navbar-brand {
            font-size: 1.5rem; /* Brand text lebih besar */
            font-weight: 700;
        }

        /* Notification bell styling */
        #notificationBell {
            padding: 0.6rem 1rem !important; /* Sama dengan nav-link lainnya */
            border-radius: 10px !important;
            transition: all 0.3s ease !important;
        }

        #notificationBell:hover {
            background-color: rgba(0, 123, 255, 0.1) !important;
        }

        #notificationBell i {
            font-size: 1rem; /* Sama dengan icon lainnya */
        }


        .sidebar-section {
            padding: 1rem 1.5rem 0.5rem;
            color: #6c757d;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(0, 212, 170, 0.2);
            background: rgba(0, 212, 170, 0.05);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            color: var(--text-color);
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-user:hover {
            background: rgba(0, 212, 170, 0.1);
            color: var(--text-color);
            text-decoration: none;
        }

        .sidebar-user img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 0.75rem;
            border: 2px solid var(--primary-color);
        }

        .sidebar-user-info {
            flex: 1;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.2rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        
        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .main-content.sidebar-open {
            margin-left: 300px;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 280px;
                left: -280px;
            }

            .main-content.sidebar-open {
                margin-left: 0;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Sidebar Animation Enhancements */
        .sidebar-nav .nav-link {
            overflow: hidden;
        }

        .sidebar-nav .nav-link::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 170, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar-nav .nav-link:hover::after {
            left: 100%;
        }

        /* Sidebar Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #00a8cc;
        }

        /* Custom Quantity Selector */
        .quantity-selector {
            display: flex;
            align-items: center;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            width: 120px;
            height: 36px;
        }

        .quantity-btn {
            background: var(--bg-card);
            border: none;
            color: var(--text-color);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 16px;
        }

        .quantity-btn:hover {
            background: var(--bg-input);
            color: var(--primary-color);
        }

        .quantity-btn:active {
            background: var(--bg-dark);
        }

        .quantity-btn:disabled {
            background: var(--bg-card);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .quantity-input {
            border: none;
            background: transparent;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            color: var(--text-color);
            width: 48px;
            height: 36px;
            outline: none;
        }

        .quantity-input:focus {
            outline: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .quantity-selector {
                width: 100%;
                justify-content: center;
            }
            
            .quantity-btn {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
            
            .quantity-input {
                width: 60px;
                height: 36px;
                font-size: 16px;
            }
        }

        /* Logo G Styling */
        .logo-g {
            font-size: 2rem;
            font-weight: 900;
            color: #00d4ff;
            position: relative;
            display: inline-block;
        }
        
        .logo-g::after {
            content: '→';
            position: absolute;
            bottom: -2px;
            right: -8px;
            font-size: 0.8rem;
            color: #4dd0e1;
            font-weight: 400;
        }
        
        .navbar-brand {
            padding: 0;
            margin-right: 2rem;
        }
        
        .navbar-brand:hover .logo-g {
            color: #4dd0e1;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        
        /* Search Bar Styling */
        .navbar-search {
            position: relative;
            flex: 1;
            max-width: 400px;
            margin: 0 2rem;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ffffff;
            font-size: 1rem;
            z-index: 2;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 15px 10px 45px;
            background: #2a2a3e;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 0.95rem;
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .search-input:focus {
            outline: none;
            background: #323248;
        }

        .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: #ffffff !important;
            font-weight: 700;
            background: transparent;
        }

        .nav-link.active::after {
            display: none;
        }

        .nav-link i {
            transition: all 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link.active i {
            color: #ffffff !important;
            transform: scale(1.1);
        }

        .nav-link::after {
            display: none;
        }
        
        /* Login and Register Buttons */
        .btn-login {
            background: transparent;
            border: 1px solid #ffffff;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        
        .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: #ffffff;
        }
        
        .btn-register {
            background: #6c5ce7;
            border: none;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            background: #5f4fd8;
            color: #ffffff;
        }
        
        /* Dropdown Menu Styling for Dark Theme */
        .dropdown-menu {
            background: #2a2a3e;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        
        .dropdown-item {
            color: #ffffff;
        }
        
        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        
        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .wallet-balance {
            background: linear-gradient(135deg, 
                rgba(0, 212, 170, 0.95) 0%, 
                rgba(0, 180, 148, 0.85) 50%,
                rgba(0, 150, 136, 0.9) 100%);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 
                0 8px 25px rgba(0, 212, 170, 0.4),
                0 4px 15px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            display: inline-block;
            max-width: 160px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .wallet-balance::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.2), 
                transparent);
            transition: left 0.6s ease;
        }

        .wallet-balance:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 
                0 12px 35px rgba(0, 212, 170, 0.5),
                0 6px 20px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        .wallet-balance:hover::before {
            left: 100%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .row > [class*='col-'] {
            display: flex;
            flex-direction: column;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            color: var(--text-color);
        }


        .card[onclick] {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card[onclick]:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            cursor: pointer;
        }

        .card[onclick]:active {
            transform: translateY(-6px) scale(1.01);
            transition: all 0.1s ease;
        }

        /* Smooth hover effect for card elements */
        .card[onclick] .product-image {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card[onclick]:hover .product-image {
            transform: scale(1.05);
        }

        .card[onclick] .card-title {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .card-title {
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .card[onclick] .price-display {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .price-display {
            transform: scale(1.1);
            color: #00a8cc;
        }

        .card[onclick] .badge {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .badge {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 212, 170, 0.3);
        }

        .card[onclick] .rating {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .rating {
            transform: translateY(-2px);
        }

        .card[onclick] .rating .fas.fa-star {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .rating .fas.fa-star {
            transform: scale(1.2);
            filter: drop-shadow(0 2px 4px rgba(255, 193, 7, 0.5));
        }

        .card[onclick] .robux-icon {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .robux-icon {
            transform: scale(1.3) rotate(5deg);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        .card[onclick] .seller-info {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .seller-info {
            transform: translateY(-2px);
            background: rgba(0, 212, 170, 0.1);
        }

        /* Glow effect on hover */
        .card[onclick]:hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.1) 0%, rgba(0, 168, 204, 0.1) 100%);
            border-radius: 16px;
            z-index: -1;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                opacity: 0.5;
            }
            to {
                opacity: 0.8;
            }
        }

        /* Smooth button hover */
        .card[onclick] .btn {
            transition: all 0.3s ease;
        }

        .card[onclick]:hover .btn {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 212, 170, 0.3);
        }

        /* Modal Styling */
        .modal-content {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            color: var(--text-color);
        }

        .modal-header {
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            color: white;
            border-radius: 16px 16px 0 0;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-body {
            background: var(--bg-card);
            padding: 2rem;
            color: var(--text-color);
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            background: var(--bg-card);
            border-radius: 0 0 16px 16px;
        }
        
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-footer .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .modal-footer .btn-primary {
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            border: none;
        }

        .modal-footer .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 170, 0.3);
        }

        .modal-footer .btn-secondary {
            background: #6c757d;
            border: none;
        }

        /* Category Filter Styling */
        .form-select option[value="popular"] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        }

        .form-select option[value="top_seller"] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        }

        .form-control,
        .form-select {
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }
        
        .form-control:focus,
        .form-select:focus {
            background: var(--bg-input);
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 170, 0.25);
        }
        
        .form-control::placeholder {
            color: var(--text-muted);
        }
        
        .form-select option {
            background: var(--bg-card);
            color: var(--text-color);
            padding: 0.5rem;
        }

        .form-select option[value="popular"]:before {
            content: "🔥 ";
        }

        .form-select option[value="top_seller"]:before {
            content: "👑 ";
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 170, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        .card-text {
            color: var(--text-muted);
        }

        .badge {
            border-radius: 8px;
            font-weight: 500;
            padding: 6px 12px;
            font-size: 0.75rem;
        }

        .badge.bg-primary {
            background: var(--gradient-primary) !important;
        }

        .alert {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow);
            color: var(--text-color);
        }
        
        .alert-success {
            background: rgba(0, 212, 170, 0.2);
            border-color: var(--primary-color);
            color: var(--text-color);
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border-color: #dc3545;
            color: var(--text-color);
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .pagination .page-link {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-color);
        }
        
        .pagination .page-link:hover {
            background: var(--bg-input);
            border-color: var(--primary-color);
            color: var(--text-color);
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        .table {
            color: var(--text-color);
        }
        
        .table-dark {
            background: var(--bg-card);
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-color);
        }

        .form-control {
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            color: var(--text-color);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: var(--bg-input);
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 170, 0.25);
        }
        
        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-select {
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            color: var(--text-color);
            border-radius: 12px;
            padding: 12px 16px;
        }
        
        .form-select:focus {
            background: var(--bg-input);
            color: var(--text-color);
        }

        /* ===================================================================
           HERO SECTION
        =================================================================== */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
            padding: 0;
            margin-bottom: 0;
            overflow: visible;
            border-radius: 0;
            background: #0a0a0a;
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.6),
                0 50px 10
                0px rgba(0, 0, 0, 0.5);
        }
        
        .main-content .container .hero-section {
            margin-top: -200px !important;
            margin-bottom: 0 !important;
            margin-left: calc(-50vw + 50%) !important;
            margin-right: calc(-50vw + 50%) !important;
            width: 100vw !important;
            max-width: 100vw !important;
        }
        
        .main-content {
            margin-top: 0;
            padding-top: 0;
        }
        
        .main-content .container {
            padding-top: 0;
        }
        
        .main-content .container > .hero-section:first-child {
            margin-top: 0 !important;
        }

        /* ===================================================================
           BACKGROUND SLIDER (YANG DIBUAT BLUR)
        =================================================================== */
        .hero-slider {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.5),
                0 50px 100px rgba(0, 0, 0, 0.4),
                inset 0 0 80px rgba(0, 0, 0, 0.3);
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            opacity: 0;
            visibility: hidden;
            transition: opacity 1.5s ease-in-out, visibility 1.5s ease-in-out;
            z-index: 1;
        }

        .hero-slide.active {
            opacity: 1;
            visibility: visible;
            z-index: 2;
        }

        /* Gambar slides */
        .hero-slide:nth-child(1) {
            background-image: url('{{ asset("img/gambar 1.jpeg") }}');
        }
        .hero-slide:nth-child(2) {
            background-image: url('{{ asset("img/roblox.jpg") }}');
        }
        .hero-slide:nth-child(3) {
            background-image: url('{{ asset("img/gambar 3.jpg") }}');
        }

        /* ===================================================================
           DARK OVERLAY (CINEMATIC SEPERTI CONTOH)
        =================================================================== */
        .hero-section::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 2;

            background: linear-gradient(
                to bottom,
                rgba(0,0,0,0.6) 0%,
                rgba(0,0,0,0.3) 40%,
                rgba(0,0,0,0.75) 100%
            );
        }

        /* ===================================================================
           BLUR GRADIENT - TOP & BOTTOM
        =================================================================== */
        .hero-slider::before,
        .hero-slider::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            z-index: 3;
            pointer-events: none;
        }

        /* Top blur gradient - kuat di atas, memudar ke tengah */
        .hero-slider::before {
            top: 0;
            height: 50%;
            background: 
                linear-gradient(
                    to bottom,
                    rgba(26, 26, 46, 0.95),
                    rgba(26, 26, 46, 0.6),
                    transparent
                );
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(8px);
            mask-image: linear-gradient(to bottom, black 0%, black 30%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 0%, black 30%, transparent 100%);
        }

        /* Bottom blur gradient - kuat di bawah, memudar ke tengah */
        .hero-slider::after {
            bottom: 0;
            height: 50%;
            background: 
                linear-gradient(
                    to top,
                    rgba(26, 26, 46, 0.95),
                    rgba(26, 26, 46, 0.6),
                    transparent
                );
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            mask-image: linear-gradient(to top, black 0%, black 30%, transparent 100%);
            -webkit-mask-image: linear-gradient(to top, black 0%, black 30%, transparent 100%);
        }

        /* ===================================================================
           NAVIGATION ARROWS
        =================================================================== */
        .hero-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(0,0,0,0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: 0.3s;
        }

        .hero-nav:hover {
            background: rgba(0,0,0,0.8);
            border-color: rgba(255,255,255,0.8);
            transform: translateY(-50%) scale(1.1);
        }

        .hero-nav-prev { left: 20px; }
        .hero-nav-next { right: 20px; }

        /* ===================================================================
           HERO CONTENT
        =================================================================== */
        .hero-section .container {
            position: relative;
            z-index: 5;
            max-width: 100%;
            width: 100%;
            padding: 2rem;
            display: flex;
            align-items: center;
        }

        .hero-content-left {
            color: white;
        }
        
        .hero-stats {
            margin-top: 1.5rem;
        }
        
        .hero-stats .stat-item {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }
        
        .hero-stats .stat-item i {
            color: var(--primary-color);
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .hero-title .fa-hand-wave {
            animation: wave 1s ease-in-out infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
        
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(14deg); }
            20%, 40% { transform: rotate(-8deg); }
            50% { transform: rotate(14deg); }
            60% { transform: rotate(0deg); }
        }
        
        .hero-content-left,
        .hero-content-right {
            position: relative;
            z-index: 5;
        }
        
        .hero-content-left {
            padding-left: 5rem;
        }
        
        .hero-content-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            padding-right: 5rem;
        }

        /* Animations */
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.6; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; }
        }

        @keyframes slideInLeft {
            0% { transform: translateX(-100px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInRight {
            0% { transform: translateX(100px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            0% { transform: translateY(30px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Hero Content Animations */
        .hero-content-left {
            animation: slideInLeft 1s ease-out;
        }
        
        .hero-content-right {
            animation: slideInRight 1s ease-out 0.3s both;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            text-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.8),
                0 2px 4px rgba(0, 0, 0, 0.6);
            position: relative;
            z-index: 5;
            line-height: 1.1;
            letter-spacing: 0.02em;
            color: #ffffff;
            text-transform: uppercase;
        }
        
        .hero-description {
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.7);
            position: relative;
            z-index: 5;
            line-height: 1.7;
            letter-spacing: 0.01em;
            color: #ffffff;
            max-width: 600px;
        }
        
        .hero-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            text-shadow: 
                0 2px 4px rgba(0, 0, 0, 0.8);
            position: relative;
            z-index: 5;
        }

        .btn-hero-buy {
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.8);
            color: #4a5568;
            border-radius: 8px;
            padding: 16px 48px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 5;
            letter-spacing: 0.02em;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
            font-family: 'Inter', sans-serif;
        }

        .btn-hero-buy:hover {
            background: #f8f9fa;
            border-color: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #2d3748;
        }
        
        .btn-hero-wishlist {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.8);
            color: #ffffff;
            border-radius: 8px;
            padding: 16px 48px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 5;
            letter-spacing: 0.02em;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
            font-family: 'Inter', sans-serif;
        }

        .btn-hero-wishlist:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #ffffff;
        }

        .hero-section .hero-buttons {
            position: relative;
            z-index: 5;
            width: 100%;
            max-width: 300px;
        }

        /* Robux Calculator Styling */
        .robux-calculator {
            background: linear-gradient(135deg, 
                rgba(26, 26, 46, 0.98) 0%, 
                rgba(42, 42, 62, 0.98) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 
                0 15px 50px rgba(0, 0, 0, 0.5),
                0 5px 20px rgba(0, 212, 170, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 5;
            max-width: 400px;
            width: 100%;
            border: 2px solid rgba(0, 212, 170, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .robux-calculator::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, 
                transparent 0%,
                rgba(0, 212, 170, 0.5) 25%,
                rgba(0, 212, 170, 0.8) 50%,
                rgba(0, 212, 170, 0.5) 75%,
                transparent 100%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .robux-calculator:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.6),
                0 8px 30px rgba(0, 212, 170, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border-color: rgba(0, 212, 170, 0.6);
        }

        .calculator-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 10px rgba(0, 212, 170, 0.3);
        }

        .calculator-title i {
            color: var(--primary-color);
            font-size: 1.3rem;
            filter: drop-shadow(0 0 10px rgba(0, 212, 170, 0.5));
            animation: pulse 2s ease-in-out infinite;
        }

        .calculator-subtitle {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 1.5rem;
            font-weight: 500;
            line-height: 1.5;
        }

        .calculator-input-group {
            margin-bottom: 1.5rem;
        }

        .calculator-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.75rem;
            letter-spacing: 0.3px;
        }

        .calculator-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(0, 212, 170, 0.3);
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
            transition: all 0.3s ease;
            background: rgba(42, 42, 62, 0.8);
            box-shadow: 
                inset 0 2px 8px rgba(0, 0, 0, 0.3),
                0 0 0 0 rgba(0, 212, 170, 0);
        }

        .calculator-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(42, 42, 62, 0.95);
            box-shadow: 
                inset 0 2px 8px rgba(0, 0, 0, 0.3),
                0 0 0 4px rgba(0, 212, 170, 0.15),
                0 0 20px rgba(0, 212, 170, 0.2);
            transform: translateY(-2px);
        }

        .calculator-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
            font-weight: 400;
        }

        .calculator-result {
            background: linear-gradient(135deg, 
                rgba(0, 212, 170, 0.15) 0%, 
                rgba(0, 168, 204, 0.15) 100%);
            border-left: 4px solid var(--primary-color);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s ease;
            box-shadow: 
                0 4px 15px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 212, 170, 0.2);
            border-left-width: 4px;
        }

        .calculator-result:hover {
            transform: translateX(8px);
            background: linear-gradient(135deg, 
                rgba(0, 212, 170, 0.25) 0%, 
                rgba(0, 168, 204, 0.25) 100%);
            box-shadow: 
                0 6px 20px rgba(0, 0, 0, 0.3),
                0 0 30px rgba(0, 212, 170, 0.2);
        }

        .result-icon {
            font-size: 1.8rem;
            color: var(--primary-color);
            filter: drop-shadow(0 0 10px rgba(0, 212, 170, 0.5));
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { 
                transform: scale(1); 
                opacity: 0.8; 
                filter: drop-shadow(0 0 10px rgba(0, 212, 170, 0.5));
            }
            50% { 
                transform: scale(1.15); 
                opacity: 1; 
                filter: drop-shadow(0 0 20px rgba(0, 212, 170, 0.8));
            }
        }

        .result-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .result-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .result-price {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
            text-shadow: 0 0 20px rgba(0, 212, 170, 0.4);
        }

        .btn-calculator-search {
            width: 100%;
            background: linear-gradient(135deg, 
                rgba(0, 212, 170, 1) 0%, 
                rgba(0, 168, 204, 1) 100%);
            border: 2px solid rgba(0, 212, 170, 0.3);
            color: #ffffff;
            border-radius: 12px;
            padding: 15px 28px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            box-shadow: 
                0 6px 20px rgba(0, 212, 170, 0.4),
                0 2px 8px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.95rem;
        }

        .btn-calculator-search::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.25), 
                transparent);
            transition: left 0.6s ease;
        }

        .btn-calculator-search::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 10px;
            padding: 2px;
            background: linear-gradient(135deg, 
                rgba(0, 212, 170, 0.5), 
                rgba(0, 168, 204, 0.5));
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-calculator-search:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 10px 35px rgba(0, 212, 170, 0.5),
                0 4px 15px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            color: #ffffff;
            border-color: rgba(0, 212, 170, 0.6);
        }

        .btn-calculator-search:hover::before {
            left: 100%;
        }

        .btn-calculator-search:hover::after {
            opacity: 1;
        }

        .btn-calculator-search:active {
            transform: translateY(-1px);
            box-shadow: 
                0 6px 20px rgba(0, 212, 170, 0.4),
                0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Hero image styling removed - now using background image */

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 2px solid transparent;
            position: relative;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.8s ease;
            z-index: 1;
        }

        .product-card:hover::before {
            left: 100%;
        }

        .product-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 
                0 25px 50px rgba(0,0,0,0.15),
                0 10px 25px rgba(0,0,0,0.1),
                inset 0 1px 0 rgba(255,255,255,0.2);
            border-color: rgba(13, 110, 253, 0.2);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: all 0.4s ease;
            position: relative;
            z-index: 2;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
            filter: brightness(1.1) contrast(1.05) saturate(1.1);
        }

        /* Seller Link Effects - Different from Add to Cart */
        .seller-link {
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
        }

        .seller-link::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }

        .seller-link:hover::before {
            width: 100%;
        }

        .seller-link:hover {
            color: #667eea !important;
            transform: translateY(-1px);
            text-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
        }

        .seller-link:hover .fa-external-link-alt {
            transform: translateX(2px) translateY(-1px);
            color: #764ba2;
        }

        .seller-link .fa-external-link-alt {
            transition: all 0.3s ease;
        }

        /* Seller Avatar Hover Effect */
        .seller-avatar {
            transition: all 0.3s ease;
        }

        .seller-link:hover + .seller-avatar,
        .seller-link:hover ~ .seller-avatar {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Prevent card hover when hovering seller link */
        .seller-link:hover ~ *,
        .seller-link:hover + * {
            pointer-events: none;
        }

        /* Add to Cart Button - Different Effect */
        .add-to-cart-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .add-to-cart-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }

        .add-to-cart-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }

        .cart-item-image {
            width: 100%;
            height: 80px;
            object-fit: cover;
            object-position: center;
        }
        
        .order-item-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
            object-position: center;
        }

        .seller-avatar img {
            border: 2px solid rgba(0, 212, 170, 0.3);
            transition: all 0.3s ease;
        }

        .seller-avatar:hover img {
            border-color: var(--primary-color);
            transform: scale(1.1);
        }

        .rating {
            font-size: 0.9rem;
        }

        .rating .fas.fa-star,
        .rating .fas.fa-star-half-alt {
            color: #ffc107 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .robux-icon {
            border-radius: 6px;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        }

        .robux-icon:hover {
            transform: scale(1.15);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.25));
        }

        .card-text {
            font-size: 0.85rem;
            line-height: 1.4;
            color: #6c757d;
        }

        .seller-info {
            background: rgba(0, 212, 170, 0.05);
            border-radius: 8px;
            padding: 0.5rem;
            border-left: 3px solid var(--primary-color);
        }

        .seller-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .seller-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3748;
        }

        .price-display {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0.1;
        }

        .product-icon {
            font-size: 4rem;
            color: var(--primary-color);
            z-index: 1;
        }

        .price-tag {
            background: var(--gradient-primary);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .footer {
            background: var(--gradient-secondary);
            color: white;
            padding: 3rem 0 2rem;
            margin-top: 4rem;
        }

        .search-section {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 1.2rem 1.5rem;
            border-radius: 20px;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.3),
                0 4px 15px rgba(0, 212, 170, 0.15);
            margin-bottom: 2rem;
            color: var(--text-color);
            border: 1px solid rgba(0, 212, 170, 0.2);
            backdrop-filter: blur(15px);
            position: relative;
            overflow: hidden;
        }

        .search-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(0, 212, 170, 0.5) 50%, 
                transparent 100%);
        }

        .search-section .form-control,
        .search-section .form-select {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            background: var(--bg-input);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .search-section .form-control:focus,
        .search-section .form-select:focus {
            border-color: var(--primary-color);
            background: var(--bg-input);
            color: var(--text-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 170, 0.25);
            transform: translateY(-1px);
        }

        .search-section .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 
                0 4px 15px rgba(0, 212, 170, 0.3),
                0 2px 8px rgba(0, 0, 0, 0.1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .search-section .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.3), 
                transparent);
            transition: left 0.5s ease;
        }

        .search-section .btn:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 6px 25px rgba(0, 212, 170, 0.4),
                0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .search-section .btn:hover::before {
            left: 100%;
        }

        /* Extra Large Screens (1400px+) */
        @media (min-width: 1400px) {
            .hero-content-left {
                padding-left: 6rem;
            }
            
            .hero-content-right {
                padding-right: 6rem;
            }
            
            .hero-title {
                font-size: 5rem;
            }
            
            .hero-description {
                font-size: 1.2rem;
            }
            
            .hero-price {
                font-size: 3rem;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 18px 52px;
                font-size: 1.2rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 350px;
            }
            
            .robux-calculator {
                max-width: 450px;
                padding: 2.5rem;
            }
            
            .calculator-title {
                font-size: 1.7rem;
            }
            
            .calculator-subtitle {
                font-size: 1rem;
            }
        }

        /* Large Screens (1200px - 1399px) */
        @media (max-width: 1399px) and (min-width: 1200px) {
            .hero-content-left {
                padding-left: 5rem;
            }
            
            .hero-content-right {
                padding-right: 5rem;
            }
            
            .hero-title {
                font-size: 4.5rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
            }
            
            .hero-price {
                font-size: 2.5rem;
            }
        }

        /* Medium Large Screens (1024px - 1199px) */
        @media (max-width: 1199px) and (min-width: 1025px) {
            .hero-content-left {
                padding-left: 4rem;
            }
            
            .hero-content-right {
                padding-right: 4rem;
            }
            
            .hero-title {
                font-size: 3.5rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
            
            .hero-price {
                font-size: 2.2rem;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 15px 42px;
                font-size: 1.05rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 280px;
            }
        }

        /* Tablet Responsive (768px - 1024px) */
        @media (max-width: 1024px) and (min-width: 769px) {
            .hero-content-left {
                padding-left: 3rem;
            }
            
            .hero-content-right {
                padding-right: 3rem;
            }
            
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .search-section {
                padding: 1rem 1.2rem;
            }
            
            .search-section .form-control,
            .search-section .form-select {
                padding: 0.55rem 0.9rem;
                font-size: 0.85rem;
            }
            
            .search-section .btn {
                padding: 0.55rem 1.1rem;
                font-size: 0.85rem;
            }
            
            .wallet-balance {
                max-width: 150px;
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Mobile Responsive (max-width: 768px) */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .logo-g {
                font-size: 1.5rem;
            }
            
            .navbar-search {
                max-width: 100%;
                margin: 0.5rem 0;
                order: 3;
                width: 100%;
            }
            
            .navbar-nav {
                flex-direction: column;
            }

            .nav-link {
                padding: 0.4rem 0.8rem !important;
                font-size: 0.9rem;
            }

            .navbar-toggler {
                border: 1px solid rgba(255, 255, 255, 0.3);
                padding: 0.25rem 0.5rem;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .navbar-toggler:focus {
                box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
            }

            .navbar-toggler:hover {
                background: rgba(255, 255, 255, 0.1);
            }
            
            .btn-login,
            .btn-register {
                width: 100%;
                margin: 0.25rem 0;
            }

            .hero-section {
                height: 100vh;
                min-height: 100vh;
                padding: 0;
            }
            
            .hero-content-left {
                text-align: center;
                margin-bottom: 2rem;
                padding-left: 1rem;
            }
            
            .hero-content-right {
                text-align: center;
                margin-bottom: 2rem;
                align-items: center;
                padding-right: 1rem;
            }
            
            .robux-calculator {
                max-width: 100%;
                padding: 1.5rem;
                margin: 0 auto;
            }
            
            .calculator-title {
                font-size: 1.3rem;
            }
            
            .calculator-subtitle {
                font-size: 0.9rem;
            }
            
            .calculator-input {
                padding: 10px 14px;
                font-size: 0.95rem;
            }
            
            .result-price {
                font-size: 1.3rem;
            }
            
            .btn-calculator-search {
                padding: 12px 20px;
                font-size: 0.95rem;
            }
            
            .hero-title {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }
            
            .hero-description {
                font-size: 0.95rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-price {
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 100%;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 14px 32px;
                font-size: 1rem;
            }
            
            .hero-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .hero-nav-prev {
                left: 10px;
            }
            
            .hero-nav-next {
                right: 10px;
            }
            
            .robux-calculator {
                max-width: 100%;
                padding: 1.5rem;
                margin: 0 auto;
            }
            
            .calculator-title {
                font-size: 1.3rem;
            }
            
            .calculator-subtitle {
                font-size: 0.9rem;
            }
            
            .calculator-input {
                padding: 10px 14px;
                font-size: 0.95rem;
            }
            
            .result-price {
                font-size: 1.3rem;
            }
            
            .btn-calculator-search {
                padding: 12px 20px;
                font-size: 0.95rem;
            }
            
            .wallet-balance {
                max-width: 120px;
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .search-section {
                padding: 0.8rem 1rem;
                margin-bottom: 1rem;
            }

            .search-section .form-control,
            .search-section .form-select {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
            }

            .search-section .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .product-image {
                height: 150px;
            }
            
            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .card-title {
                font-size: 1rem;
            }
            
            .price-display {
                font-size: 1.1rem;
            }
            
            .card-text {
                font-size: 0.8rem;
            }
            
            .seller-info {
                padding: 0.4rem;
            }
            
            .seller-label {
                font-size: 0.7rem;
            }
            
            .robux-icon {
                width: 18px !important;
                height: 18px !important;
            }
            
            .product-icon {
                font-size: 3rem;
            }

            /* Mobile Layout Adjustments */
            .search-section .d-flex {
                flex-direction: column;
                align-items: stretch !important;
            }

            .search-section h4 {
                margin-bottom: 1rem !important;
                text-align: center;
            }

            .search-section form {
                flex-direction: column;
                gap: 0.5rem;
            }

            .search-section .me-2 {
                margin-right: 0 !important;
                margin-bottom: 0.5rem;
            }

            .search-section .me-3 {
                margin-right: 0 !important;
            }

            .search-section .me-4 {
                margin-right: 0 !important;
                margin-bottom: 1rem;
            }
        }

        /* Small Tablet (576px - 768px) */
        @media (max-width: 768px) and (min-width: 577px) {
            .hero-content-left {
                padding-left: 1.5rem;
            }
            
            .hero-content-right {
                padding-right: 1.5rem;
            }
            
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
            
            .hero-price {
                font-size: 2.2rem;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 15px 36px;
                font-size: 1.05rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 280px;
            }
            
            .robux-calculator {
                max-width: 350px;
                padding: 1.75rem;
            }
        }

        /* Small Mobile Responsive (max-width: 576px) */
        @media (max-width: 576px) {
            .hero-content-left {
                padding-left: 0.5rem;
            }
            
            .hero-content-right {
                padding-right: 0.5rem;
            }
            
            .hero-section {
                height: 100vh;
                min-height: 100vh;
                padding: 0;
            }
            
            .hero-section .container {
                margin-top: 0;
            }

            .hero-title {
                font-size: 2rem;
            }
            
            .hero-description {
                font-size: 0.85rem;
            }
            
            .hero-price {
                font-size: 1.6rem;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 12px 24px;
                font-size: 0.9rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 250px;
            }
            
            .robux-calculator {
                max-width: 100%;
                padding: 1.25rem;
            }
            
            .calculator-title {
                font-size: 1.2rem;
            }
            
            .calculator-subtitle {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }
            
            .calculator-input {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            
            .result-price {
                font-size: 1.2rem;
            }
            
            .btn-calculator-search {
                padding: 10px 18px;
                font-size: 0.9rem;
            }
            
            .wallet-balance {
                max-width: 100px;
                font-size: 0.7rem;
                padding: 0.3rem 0.6rem;
            }

            .search-section {
                padding: 0.6rem 0.8rem;
            }

            .search-section .form-control,
            .search-section .form-select {
                padding: 0.4rem 0.6rem;
                font-size: 0.75rem;
            }

            .search-section .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .product-image {
                height: 120px;
            }
            
            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            
            .card-body {
                padding: 0.8rem;
            }
            
            .card-title {
                font-size: 0.9rem;
            }
            
            .price-display {
                font-size: 1rem;
            }
            
            .card-text {
                font-size: 0.75rem;
            }
            
            .seller-info {
                padding: 0.3rem;
            }
            
            .seller-label {
                font-size: 0.65rem;
            }
            
            .robux-icon {
                width: 16px !important;
                height: 16px !important;
            }
            
            .badge {
                font-size: 0.7rem;
                padding: 4px 8px;
            }
            
            .product-icon {
                font-size: 2.5rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-title {
                font-size: 1rem;
            }

            .card-text {
                font-size: 0.85rem;
            }
        }

        /* Extra Small Mobile (max-width: 480px) */
        @media (max-width: 480px) {
            .hero-content-left {
                padding-left: 0.5rem;
            }
            
            .hero-content-right {
                padding-right: 0.5rem;
            }
            
            .hero-section {
                padding: 2rem 0;
            }
            
            .hero-section::before {
                height: 120px;
            }
            
            .hero-section .container {
                margin-top: 140px;
            }

            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-description {
                font-size: 0.8rem;
                margin-bottom: 1rem;
            }
            
            .hero-price {
                font-size: 1.5rem;
                margin-bottom: 0.8rem;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 10px 20px;
                font-size: 0.85rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 220px;
            }
            
            .robux-calculator {
                padding: 1rem;
            }
            
            .calculator-title {
                font-size: 1.1rem;
            }
            
            .calculator-subtitle {
                font-size: 0.8rem;
                margin-bottom: 1rem;
            }
            
            .calculator-input {
                padding: 8px 10px;
                font-size: 0.85rem;
            }
            
            .calculator-result {
                padding: 0.75rem 1rem;
            }
            
            .result-label {
                font-size: 0.75rem;
            }
            
            .result-price {
                font-size: 1.1rem;
            }
            
            .btn-calculator-search {
                padding: 10px 16px;
                font-size: 0.85rem;
            }
            
            .hero-nav {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .hero-nav-prev {
                left: 8px;
            }
            
            .hero-nav-next {
                right: 8px;
            }
            
            .hero-subtitle {
                font-size: 0.85rem;
            }
            
            .wallet-balance {
                max-width: 90px;
                font-size: 0.65rem;
                padding: 0.25rem 0.5rem;
            }

            .search-section {
                padding: 0.5rem 0.6rem;
            }

            .search-section .form-control,
            .search-section .form-select {
                padding: 0.35rem 0.5rem;
                font-size: 0.7rem;
            }

            .search-section .btn {
                padding: 0.35rem 0.6rem;
                font-size: 0.7rem;
            }

            .product-image {
                height: 100px;
            }
            
            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            
            .card-body {
                padding: 0.6rem;
            }
            
            .card-title {
                font-size: 0.85rem;
            }
            
            .price-display {
                font-size: 0.9rem;
            }
            
            .card-text {
                font-size: 0.7rem;
            }
            
            .seller-info {
                padding: 0.25rem;
            }
            
            .seller-label {
                font-size: 0.6rem;
            }
            
            .robux-icon {
                width: 14px !important;
                height: 14px !important;
            }
            
            .badge {
                font-size: 0.65rem;
                padding: 3px 6px;
            }
            
            .btn-primary {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
            
            .product-icon {
                font-size: 2rem;
            }

            .card-body {
                padding: 0.8rem;
            }

            .card-title {
                font-size: 0.9rem;
            }

            .card-text {
                font-size: 0.8rem;
            }
        }

        /* Very Small Mobile (max-width: 375px) */
        @media (max-width: 375px) {
            .hero-content-left {
                padding-left: 0.25rem;
            }
            
            .hero-content-right {
                padding-right: 0.25rem;
            }
            
            .hero-title {
                font-size: 1.5rem;
                margin-bottom: 0.8rem;
            }
            
            .hero-description {
                font-size: 0.75rem;
                margin-bottom: 0.8rem;
            }
            
            .hero-price {
                font-size: 1.2rem;
                margin-bottom: 0.6rem;
            }
            
            .btn-hero-buy,
            .btn-hero-wishlist {
                padding: 8px 16px;
                font-size: 0.8rem;
            }
            
            .hero-section .hero-buttons {
                max-width: 200px;
            }
            
            .robux-calculator {
                padding: 0.875rem;
            }
            
            .calculator-title {
                font-size: 1rem;
            }
            
            .calculator-subtitle {
                font-size: 0.75rem;
                margin-bottom: 0.875rem;
            }
            
            .calculator-input {
                padding: 8px;
                font-size: 0.8rem;
            }
            
            .calculator-result {
                padding: 0.625rem 0.875rem;
            }
            
            .result-label {
                font-size: 0.7rem;
            }
            
            .result-price {
                font-size: 1rem;
            }
            
            .btn-calculator-search {
                padding: 8px 14px;
                font-size: 0.8rem;
            }
            
            .hero-nav {
                width: 32px;
                height: 32px;
                font-size: 0.85rem;
            }
            
            .hero-nav-prev {
                left: 5px;
            }
            
            .hero-nav-next {
                right: 5px;
            }
        }

        /* Enhanced Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .row {
                margin-left: -5px;
                margin-right: -5px;
            }

            .col-md-4,
            .col-lg-3,
            .col-sm-6,
            .col-md-6 {
                padding-left: 5px;
                padding-right: 5px;
                margin-bottom: 1rem;
            }

            .card {
                height: auto;
                margin-bottom: 1rem;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            }

            .card-body {
                padding: 1rem;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .product-image {
                height: 160px;
                overflow: hidden;
                border-radius: 8px 8px 0 0;
            }

            .product-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }

            .card-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                line-height: 1.3;
            }

            .card-text {
                font-size: 0.85rem;
                color: #6c757d;
                margin-bottom: 0.75rem;
                line-height: 1.4;
            }

            .badge {
                font-size: 0.7rem;
                padding: 4px 8px;
                margin-bottom: 0.5rem;
            }

            .seller-info {
                margin-bottom: 0.75rem;
            }

            .seller-avatar img {
                width: 20px !important;
                height: 20px !important;
            }

            .seller-label {
                font-size: 0.7rem;
            }

            .seller-name {
                font-size: 0.75rem;
                font-weight: 500;
            }

            .rating-section {
                margin-bottom: 0.75rem;
            }

            .rating-stars {
                font-size: 0.8rem;
            }

            .rating-number {
                font-size: 0.8rem;
            }

            .robux-icon {
                width: 14px !important;
                height: 14px !important;
            }

            .price-display {
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 0.75rem;
            }

            .btn-primary {
                font-size: 0.8rem;
                padding: 0.6rem 1rem;
                width: 100%;
                margin-top: auto;
                border-radius: 8px;
                font-weight: 500;
            }

            .search-section .row {
                margin-left: 0;
                margin-right: 0;
            }

            .search-section .col-md-9,
            .search-section .col-md-3 {
                padding-left: 0;
                padding-right: 0;
                margin-bottom: 0.5rem;
            }

            .wallet-balance {
                text-align: center;
                margin-top: 0.5rem;
            }

            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            .pagination .page-link {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
            }

            .pagination-info {
                text-align: center;
                font-size: 0.8rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 5px;
                padding-right: 5px;
            }

            .row {
                margin-left: -2px;
                margin-right: -2px;
            }

            .col-md-4,
            .col-lg-3,
            .col-sm-6,
            .col-md-6 {
                padding-left: 2px;
                padding-right: 2px;
            }

            .card {
                border-radius: 10px;
                margin-bottom: 0.75rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .product-image {
                height: 140px;
            }

            .card-title {
                font-size: 0.9rem;
                line-height: 1.2;
                margin-bottom: 0.4rem;
            }

            .card-text {
                font-size: 0.8rem;
                margin-bottom: 0.6rem;
            }

            .badge {
                font-size: 0.65rem;
                padding: 3px 6px;
                margin-bottom: 0.4rem;
            }

            .seller-info {
                margin-bottom: 0.6rem;
            }

            .seller-avatar img {
                width: 18px !important;
                height: 18px !important;
            }

            .seller-label {
                font-size: 0.65rem;
            }

            .seller-name {
                font-size: 0.7rem;
            }

            .rating-section {
                margin-bottom: 0.6rem;
            }

            .rating-stars {
                font-size: 0.75rem;
            }

            .rating-number {
                font-size: 0.75rem;
            }

            .robux-icon {
                width: 12px !important;
                height: 12px !important;
            }

            .price-display {
                font-size: 1rem;
                margin-bottom: 0.6rem;
            }

            .btn-primary {
                font-size: 0.75rem;
                padding: 0.5rem 0.8rem;
                border-radius: 6px;
            }

            .search-section {
                padding: 0.4rem;
            }

            .search-section .form-control,
            .search-section .form-select {
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
            }

            .search-section .btn {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .nav-link {
                font-size: 0.85rem;
                padding: 0.3rem 0.6rem !important;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .hero-subtitle {
                font-size: 0.8rem;
            }

            .hero-btn {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .card {
                border-radius: 8px;
                margin-bottom: 0.5rem;
            }

            .card-body {
                padding: 0.6rem;
            }

            .product-image {
                height: 120px;
            }

            .card-title {
                font-size: 0.85rem;
                line-height: 1.1;
                margin-bottom: 0.3rem;
            }

            .card-text {
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
                line-height: 1.3;
            }

            .badge {
                font-size: 0.6rem;
                padding: 2px 4px;
                margin-bottom: 0.3rem;
            }

            .seller-info {
                margin-bottom: 0.5rem;
            }

            .seller-avatar img {
                width: 16px !important;
                height: 16px !important;
            }

            .seller-label {
                font-size: 0.6rem;
            }

            .seller-name {
                font-size: 0.65rem;
            }

            .rating-section {
                margin-bottom: 0.5rem;
            }

            .rating-stars {
                font-size: 0.7rem;
            }

            .rating-number {
                font-size: 0.7rem;
            }

            .robux-icon {
                width: 10px !important;
                height: 10px !important;
            }

            .price-display {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .btn-primary {
                font-size: 0.7rem;
                padding: 0.4rem 0.6rem;
                border-radius: 5px;
            }

            .wallet-balance {
                font-size: 0.6rem;
                padding: 0.2rem 0.4rem;
                max-width: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="sidebar-brand">
                <i class="fas fa-gamepad"></i>
                JajanGaming
            </a>
        </div>
        
        <nav class="sidebar-nav">
            @auth
                @if(auth()->user()->isUser())
                    <div class="sidebar-section">Main Menu</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                Cart
                                <span class="badge" id="sidebarCartBadge" style="display: none;">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="fas fa-list"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('wallet.index') }}">
                                <i class="fas fa-wallet"></i>
                                Wallet
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Account</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.index') }}">
                                <i class="fas fa-user"></i>
                                My Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-notification" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell"></i>
                                Notifications
                                <span class="badge sidebar-notification-badge" id="sidebarNotificationBadge" style="display: none;">0</span>
                            </a>
                        </li>
                    </ul>
                    
                @elseif(auth()->user()->isAdmin())
                    <div class="sidebar-section">Main Menu</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                Cart
                                <span class="badge" id="sidebarCartBadge" style="display: none;">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="fas fa-list"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('wallet.index') }}">
                                <i class="fas fa-wallet"></i>
                                Wallet
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Administration</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Quick Actions</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.products.create') }}">
                                <i class="fas fa-plus"></i>
                                Add Product
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.products') }}">
                                <i class="fas fa-cube"></i>
                                Manage Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.orders') }}">
                                <i class="fas fa-shopping-cart"></i>
                                View Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.users') }}">
                                <i class="fas fa-users"></i>
                                Manage Users
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Notifications</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link sidebar-notification" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell"></i>
                                Notifications
                                <span class="badge sidebar-notification-badge" id="sidebarNotificationBadge" style="display: none;">0</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Account</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.profile') }}">
                                <i class="fas fa-user-cog"></i>
                                Profile
                            </a>
                        </li>
                    </ul>
                    
                @elseif(auth()->user()->isSeller())
                    <div class="sidebar-section">Seller Dashboard</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Quick Actions</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.products.create') }}">
                                <i class="fas fa-plus"></i>
                                Add Product
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.products') }}">
                                <i class="fas fa-cube"></i>
                                Manage Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('admin.orders') }}">
                                <i class="fas fa-shopping-cart"></i>
                                View Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebar-quick-action" href="{{ route('wallet.index') }}">
                                <i class="fas fa-wallet"></i>
                                My Wallet
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Notifications</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link sidebar-notification" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell"></i>
                                Notifications
                                <span class="badge sidebar-notification-badge" id="sidebarNotificationBadge" style="display: none;">0</span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="sidebar-section">Account</div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.profile') }}">
                                <i class="fas fa-user-cog"></i>
                                Profile
                            </a>
                        </li>
                    </ul>
                @endif
            @endauth
        </nav>
        
        @auth
        <div class="sidebar-footer">
            <a href="{{ route('profile.index') }}" class="sidebar-user">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile">
                @else
                    <div style="width: 32px; height: 32px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 0.75rem;">
                        <i class="fas fa-user text-white"></i>
                    </div>
                @endif
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">
                        @if(auth()->user()->isAdmin())
                            Administrator
                        @elseif(auth()->user()->isSeller())
                            Seller
                        @else
                            User
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endauth
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="sidebar-toggle me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Logo G -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="logo-g">G</span>
            </a>
            
            <!-- Search Bar -->
            <form class="navbar-search" method="GET" action="{{ route('home') }}">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" name="search" placeholder="Search store" value="{{ request('search') }}">
            </form>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#products">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sellers.index') }}">Sellers</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart me-1"></i>Cart
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                        </li>
                        @if(auth()->user()->isAdminOrSeller())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item me-4">
                            <a class="nav-link position-relative" href="{{ route('notifications.index') }}" id="notificationBell">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none;">
                                    0
                                </span>
                            </a>
                        </li>
                        @if(auth()->user()->isUser() || auth()->user()->isAdmin())
                        <li class="nav-item me-4">
                            <span class="wallet-balance">
                                <i class="fas fa-coins me-1"></i>
                                Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}
                            </span>
                        </li>
                        @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                     alt="Profile" 
                                     class="rounded-circle me-2" 
                                     style="width: 24px; height: 24px; object-fit: cover;">
                            @else
                                <i class="fas fa-user me-1"></i>
                            @endif
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if(auth()->user()->isUser())
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('wallet.index') }}">My Wallet</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            @if(auth()->user()->isAdminOrSeller())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="btn btn-login" href="{{ route('login') }}">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-register" href="{{ route('register') }}">Register</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content" id="mainContent">
    <main class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="fas fa-gamepad me-2"></i>JajanGaming
                    </h5>
                    <p class="mb-3">Platform terpercaya untuk top up Robux Roblox dengan harga terbaik dan proses cepat.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-discord fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="{{ route('wallet.index') }}" class="text-white-50 text-decoration-none">Wallet</a></li>
                        <li><a href="{{ route('orders.index') }}" class="text-white-50 text-decoration-none">Orders</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Payment Methods</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark">DompetKu</span>
                        <span class="badge bg-light text-dark">Bank Transfer</span>
                        <span class="badge bg-light text-dark">E-Wallet</span>
                        <span class="badge bg-light text-dark">Credit Card</span>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-white-50">&copy; 2024 JajanGaming. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-white-50">Made with <i class="fas fa-heart text-danger"></i> for Roblox players</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sticky Navbar Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Active Navbar Link Management
        function setActiveNavLink() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                const linkPath = new URL(link.href).pathname;
                
                // Check if current path matches link path
                if (currentPath === linkPath || 
                    (currentPath === '/' && linkPath === '/') ||
                    (currentPath.startsWith(linkPath) && linkPath !== '/')) {
                    link.classList.add('active');
                }
            });
        }

        // Set active link on page load
        document.addEventListener('DOMContentLoaded', function() {
            setActiveNavLink();
        });

        // Update active link when navigating
        window.addEventListener('popstate', function() {
            setActiveNavLink();
        });

        // Navbar Link Click Handler
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.navbar-nav .nav-link').forEach(l => {
                    l.classList.remove('active');
                });
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Close mobile menu if open
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        toggle: false
                    });
                    bsCollapse.hide();
                }
            });
        });
        
        // Test function to check if JavaScript is working
        function testClick() {
            alert('Card clicked! JavaScript is working.');
        }
        
        // Add to cart function
        function addToCart(productId) {
            try {
                console.log('addToCart called with productId:', productId);
                
                // Check if user is authenticated by checking for auth elements
                const isAuthenticated = document.querySelector('.wallet-balance') !== null;
                console.log('User authenticated:', isAuthenticated);
                
                if (!isAuthenticated) {
                    console.log('User not authenticated, redirecting to login');
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                
                // Get product info for modal
                const productCard = document.querySelector(`[onclick="addToCart(${productId})"]`);
                const productName = productCard.querySelector('.card-title')?.textContent || 'Produk';
                const productPrice = productCard.querySelector('.price-display')?.textContent || 'Rp 0';
                
                // Get current quantity from the product card
                const quantityInput = document.getElementById(`quantity-${productId}`);
                const currentQuantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
                console.log('Current quantity from product card:', currentQuantity);
                
                // Show confirmation modal
                showAddToCartModal(productId, productName, productPrice, currentQuantity);
                
            } catch (error) {
                console.error('Unexpected error:', error);
                showNotification('Terjadi kesalahan tidak terduga: ' + error.message, 'error');
            }
        }

        // Show add to cart confirmation modal
        function showAddToCartModal(productId, productName, productPrice, quantity = 1) {
            console.log('showAddToCartModal called with quantity:', quantity);
            
            // Create modal HTML
            const modalHtml = `
                <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addToCartModalLabel">
                                    <i class="fas fa-shopping-cart me-2"></i>Konfirmasi Tambah ke Keranjang
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <i class="fas fa-cart-plus fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="mb-2">Apakah Anda yakin ingin menambahkan produk ini ke keranjang?</h6>
                                    <div class="card bg-light">
                                        <div class="card-body py-3">
                                            <h6 class="card-title mb-1">${productName}</h6>
                                            <p class="card-text text-muted mb-2">${productPrice}</p>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <label class="form-label me-2 mb-0">Jumlah:</label>
                                                <div class="quantity-selector">
                                                    <button type="button" class="quantity-btn" onclick="decreaseModalQuantity()">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" id="modalQuantity" class="quantity-input" value="${quantity}" min="1" readonly>
                                                    <button type="button" class="quantity-btn" onclick="increaseModalQuantity()">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="button" class="btn btn-primary" onclick="confirmAddToCart(${productId})">
                                    <i class="fas fa-check me-1"></i>Ya, Tambahkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('addToCartModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('addToCartModal'));
            modal.show();
        }

        // Confirm add to cart
        function confirmAddToCart(productId) {
            try {
                const quantity = document.getElementById('modalQuantity')?.value || 1;
                console.log('Confirming add to cart - ProductId:', productId, 'Quantity:', quantity);
                
                // Sync quantity back to product card
                syncQuantityWithProductCard(productId, quantity);
                
                // Create form data
                const formData = new FormData();
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    showNotification('CSRF token tidak ditemukan', 'error');
                    return;
                }
                
                const token = csrfToken.getAttribute('content');
                console.log('Using CSRF token:', token);
                
                formData.append('_token', token);
                formData.append('product_id', productId);
                formData.append('quantity', quantity);
                
                console.log('FormData created, sending request...');
                
                // Hide modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addToCartModal'));
                modal.hide();
                
                // Show loading notification
                showNotification('Menambahkan ke keranjang...', 'info');
                
                // Send AJAX request
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    console.log('Response received:', response);
                    if (!response.ok) {
                        // Get response text for better error details
                        return response.text().then(text => {
                            console.error('Error response:', text);
                            throw new Error(`HTTP error! status: ${response.status} - ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);
                    if (data.success) {
                        // Show success message
                        showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
                        
                        // Update cart count immediately
                        updateCartCount();
                        
                        // Redirect to cart after a short delay
                        setTimeout(() => {
                            window.location.href = '{{ route("cart.index") }}';
                        }, 1500);
                    } else {
                        showNotification(data.message || 'Terjadi kesalahan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Check if it's a CSRF token mismatch error
                    if (error.message.includes('419')) {
                        showNotification('Session expired. Please refresh the page and try again.', 'error');
                        // Optionally refresh the page
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showNotification('Terjadi kesalahan saat menambahkan ke keranjang: ' + error.message, 'error');
                    }
                });
            } catch (error) {
                console.error('Unexpected error:', error);
                showNotification('Terjadi kesalahan tidak terduga: ' + error.message, 'error');
            }
        }

        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Add to body
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        // Hero Slider Functionality
        let currentHeroSlide = 0;
        let heroSlides = null;
        let totalHeroSlides = 0;
        let heroSliderInterval = null;
        
        function changeHeroSlide(direction) {
            // Re-query in case DOM changed
            if (!heroSlides || heroSlides.length === 0) {
                heroSlides = document.querySelectorAll('.hero-slide');
                totalHeroSlides = heroSlides.length;
            }
            
            if (totalHeroSlides === 0) {
                console.warn('⚠️ No hero slides found');
                return;
            }
            
            console.log('🔄 Changing slide from', currentHeroSlide + 1, 'direction:', direction);
            
            // Remove active from current
            heroSlides[currentHeroSlide].classList.remove('active');
            
            // Calculate next slide
            currentHeroSlide += direction;
            
            if (currentHeroSlide >= totalHeroSlides) {
                currentHeroSlide = 0;
            } else if (currentHeroSlide < 0) {
                currentHeroSlide = totalHeroSlides - 1;
            }
            
            // Add active to new slide
            heroSlides[currentHeroSlide].classList.add('active');
            console.log('✅ Hero slide changed to:', currentHeroSlide + 1, 'of', totalHeroSlides);
            
            // Debug: log all slides status
            heroSlides.forEach((slide, index) => {
                const isActive = slide.classList.contains('active');
                console.log(`  Slide ${index + 1}: ${isActive ? '🟢 ACTIVE' : '⚫ inactive'}`);
            });
        }
        
        function initHeroSlider() {
            console.log('🎬 initHeroSlider called');
            
            // Wait for DOM and re-query slides
            setTimeout(() => {
                heroSlides = document.querySelectorAll('.hero-slide');
                totalHeroSlides = heroSlides.length;
                
                console.log('📊 Found', totalHeroSlides, 'hero slides');
                
                if (totalHeroSlides === 0) {
                    console.warn('❌ Cannot initialize hero slider - no slides found');
                    return;
                }
                
                console.log('✅ Hero slider initialized with', totalHeroSlides, 'slides');
                
                // Make sure first slide is active
                if (heroSlides[0]) {
                    heroSlides[0].classList.add('active');
                    console.log('🟢 First slide set to active');
                }
                
                // Log initial state
                heroSlides.forEach((slide, index) => {
                    const isActive = slide.classList.contains('active');
                    const bgImage = window.getComputedStyle(slide).backgroundImage;
                    console.log(`  Slide ${index + 1}: ${isActive ? '🟢 ACTIVE' : '⚫ inactive'} - ${bgImage.substring(0, 50)}...`);
                });
                
                // Clear any existing interval
                if (heroSliderInterval) {
                    clearInterval(heroSliderInterval);
                }
                
                // Auto slide every 5 seconds
                heroSliderInterval = setInterval(() => {
                    console.log('⏰ Auto-slide triggered');
                    changeHeroSlide(1);
                }, 5000);
                
                console.log('⏰ Auto-slide set to 5 seconds');
            }, 100); // Small delay to ensure DOM is ready
        }

        // Initialize hero slider when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Don't auto-init hero slider here - let page-specific scripts handle it
            initSidebar();
            initNotifications();
            // Update cart count on page load
            updateCartCount();
        });

        // Initialize notification system
        function initNotifications() {
            updateNotificationCount();
            updateCartCount();
            // Update every 30 seconds
            setInterval(updateNotificationCount, 30000);
            setInterval(updateCartCount, 30000);
        }

        // Update cart count
        function updateCartCount() {
            @auth
                fetch('/api/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        const sidebarBadge = document.getElementById('sidebarCartBadge');
                        const navbarBadge = document.getElementById('navbarCartBadge');
                        
                        if (data.count > 0) {
                            sidebarBadge.textContent = data.count;
                            sidebarBadge.style.display = 'block';
                            navbarBadge.textContent = data.count;
                            navbarBadge.style.display = 'block';
                        } else {
                            sidebarBadge.style.display = 'none';
                            navbarBadge.style.display = 'none';
                        }
                    })
                    .catch(error => console.log('Error fetching cart count:', error));
            @endauth
        }

        // Update notification count
        function updateNotificationCount() {
            @auth
                fetch('{{ route("notifications.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const navbarBadge = document.getElementById('notificationBadge');
                        const sidebarBadge = document.getElementById('sidebarNotificationBadge');
                        
                        if (data.count > 0) {
                            navbarBadge.textContent = data.count;
                            navbarBadge.style.display = 'block';
                            sidebarBadge.textContent = data.count;
                            sidebarBadge.style.display = 'block';
                            
                            // Add shake animation to bell
                            const bell = document.getElementById('notificationBell');
                            bell.style.animation = 'shake 0.5s ease-in-out';
                            setTimeout(() => {
                                bell.style.animation = '';
                            }, 500);
                        } else {
                            navbarBadge.style.display = 'none';
                            sidebarBadge.style.display = 'none';
                        }
                    })
                    .catch(error => console.log('Error fetching notification count:', error));
            @endauth
        }

        // Shake animation for notification bell
        const shakeKeyframes = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
        
        const style = document.createElement('style');
        style.textContent = shakeKeyframes;
        document.head.appendChild(style);

        // Sidebar Functionality
        function initSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            
            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                toggleSidebar();
            });
            
            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                closeSidebar();
            });
            
            // Close sidebar when clicking sidebar links on mobile
            const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });
            
            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    // Desktop - keep sidebar state
                    sidebarOverlay.classList.remove('show');
                } else {
                    // Mobile - close sidebar
                    closeSidebar();
                }
            });
            
            // Set active sidebar link
            setActiveSidebarLink();
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            
            // On desktop, adjust main content
            if (window.innerWidth > 768) {
                mainContent.classList.toggle('sidebar-open');
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            mainContent.classList.remove('sidebar-open');
        }
        
        function setActiveSidebarLink() {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
            
            sidebarLinks.forEach(link => {
                link.classList.remove('active');
                const linkPath = new URL(link.href).pathname;
                
                // Check if current path matches link path
                if (currentPath === linkPath || 
                    (currentPath === '/' && linkPath === '/') ||
                    (currentPath.startsWith(linkPath) && linkPath !== '/')) {
                    link.classList.add('active');
                }
            });
        }

        // Modal quantity control functions
        function increaseModalQuantity() {
            const input = document.getElementById('modalQuantity');
            if (!input) {
                console.error('Modal quantity input not found');
                return;
            }
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
            console.log('Modal quantity increased to:', input.value);
            
            // Add visual feedback
            const btn = event.target.closest('.quantity-btn');
            if (btn) {
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    btn.style.transform = '';
                }, 150);
            }
        }

        function decreaseModalQuantity() {
            const input = document.getElementById('modalQuantity');
            if (!input) {
                console.error('Modal quantity input not found');
                return;
            }
            const currentValue = parseInt(input.value) || 1;
            const minValue = parseInt(input.min) || 1;
            
            if (currentValue > minValue) {
                input.value = currentValue - 1;
                console.log('Modal quantity decreased to:', input.value);
                
                // Add visual feedback
                const btn = event.target.closest('.quantity-btn');
                if (btn) {
                    btn.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        btn.style.transform = '';
                    }, 150);
                }
            }
        }

        // Sync quantity between product card and modal
        function syncQuantityWithProductCard(productId, modalQuantity) {
            const productQuantityInput = document.getElementById(`quantity-${productId}`);
            if (productQuantityInput) {
                productQuantityInput.value = modalQuantity;
                console.log(`Synced quantity ${modalQuantity} to product card ${productId}`);
            }
        }
    </script>
    
    @yield('scripts')
</body>
</html>
