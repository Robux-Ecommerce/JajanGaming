<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JajanGaming - Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
            background: #0a0e12;
        }

        body {
            color: #ffffff;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #0f1620 0%, #142230 100%);
            border-right: 1px solid rgba(100, 160, 180, 0.2);
            overflow-y: auto;
            padding: 1.5rem 0;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            background: linear-gradient(135deg, #0a1218 0%, #0f1a24 50%, #142130 100%);
            padding: 2rem;
        }

        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar,
        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track,
        .main-content::-webkit-scrollbar-track {
            background: rgba(100, 160, 180, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb,
        .main-content::-webkit-scrollbar-thumb {
            background: rgba(100, 160, 180, 0.3);
            border-radius: 4px;
        }

        /* Stats Card Styling */
        .stats-card {
            padding: 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid rgba(100, 160, 180, 0.15);
            background: rgba(255, 255, 255, 0.02);
        }

        .stats-card.total {
            background: rgba(100, 160, 180, 0.1);
            border-color: rgba(100, 160, 180, 0.3);
        }

        .stats-card.warning {
            background: rgba(232, 176, 86, 0.1);
            border-color: rgba(232, 176, 86, 0.3);
        }

        .stats-card.success {
            background: rgba(110, 190, 150, 0.1);
            border-color: rgba(110, 190, 150, 0.3);
        }

        .stats-card.danger {
            background: rgba(224, 120, 86, 0.1);
            border-color: rgba(224, 120, 86, 0.3);
        }

        .stats-icon {
            font-size: 2.5rem;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
        }

        .stats-card.total .stats-icon {
            color: #64a0b4;
        }

        .stats-card.warning .stats-icon {
            color: #e8b056;
        }

        .stats-card.success .stats-icon {
            color: #6ebe96;
        }

        .stats-card.danger .stats-icon {
            color: #e07856;
        }

        .stats-content h6 {
            color: #a0b5c5;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stats-content h3 {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        /* Card Styling */
        .card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(100, 160, 180, 0.15);
            border-radius: 12px;
            color: #ffffff;
        }

        .card-header {
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(100, 160, 180, 0.15);
            padding: 1.5rem;
        }

        .card-header h5 {
            color: #ffffff;
            font-weight: 700;
        }

        .table {
            color: #e0e0e0;
            border-color: rgba(100, 160, 180, 0.15);
        }

        .table thead th {
            color: #a0b5c5;
            font-weight: 600;
            border-color: rgba(100, 160, 180, 0.15);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            border-color: rgba(100, 160, 180, 0.1);
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(100, 160, 180, 0.08);
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-primary {
            background: rgba(100, 160, 180, 0.2);
            color: #64a0b4;
            border: 1px solid rgba(100, 160, 180, 0.3);
        }

        .badge-warning {
            background: rgba(232, 176, 86, 0.2);
            color: #e8b056;
            border: 1px solid rgba(232, 176, 86, 0.3);
        }

        .badge-success {
            background: rgba(110, 190, 150, 0.2);
            color: #6ebe96;
            border: 1px solid rgba(110, 190, 150, 0.3);
        }

        .badge-danger {
            background: rgba(224, 120, 86, 0.2);
            color: #e07856;
            border: 1px solid rgba(224, 120, 86, 0.3);
        }

        /* Button Styling */
        .btn {
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #64a0b4 0%, #508ca0 100%);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #74b0c4 0%, #60a0b5 100%);
            box-shadow: 0 4px 12px rgba(100, 160, 180, 0.3);
        }

        .btn-outline-primary {
            background: transparent;
            color: #64a0b4;
            border: 1px solid rgba(100, 160, 180, 0.3);
        }

        .btn-outline-primary:hover {
            background: rgba(100, 160, 180, 0.1);
            border-color: rgba(100, 160, 180, 0.5);
        }

        /* Modal Styling */
        .modal-content {
            background: linear-gradient(135deg, #1a2a38 0%, #243645 100%);
            border: 1px solid rgba(100, 160, 180, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid rgba(100, 160, 180, 0.2);
        }

        .modal-footer {
            border-top: 1px solid rgba(100, 160, 180, 0.2);
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(100, 160, 180, 0.2);
            color: #e0e0e0;
            border-radius: 8px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(100, 160, 180, 0.4);
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(100, 160, 180, 0.15);
        }

        .form-label {
            color: #a0b5c5;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="main-wrapper">
        @include('partials.sidebar')
        
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>

</html>
