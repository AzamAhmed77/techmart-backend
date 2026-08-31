<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') — TECH MART Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-base: #0B0E14;
            --bg-surface: #151A23;
            --bg-card: #1C2331;
            --bg-hover: #242D3E;
            --border-color: #2E384D;
            --accent: #00D2FF;
            --accent-glow: rgba(0, 210, 255, 0.2);
            --accent-purple: #7928CA;
            --text-main: #F0F6FC;
            --text-muted: #8B949E;
            --success: #00E676;
            --warning: #FFD600;
            --danger: #FF1744;
            --info: #2979FF;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--bg-surface);
            border-left: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--accent), var(--accent-purple));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .brand-text h2 {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #fff;
        }

        .brand-text span {
            font-size: 11px;
            color: var(--accent);
            text-transform: uppercase;
            font-weight: 700;
        }

        .nav-menu {
            list-style: none;
            padding: 20px 14px;
            flex: 1;
            overflow-y: auto;
        }

        .nav-item {
            margin-bottom: 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .nav-link:hover {
            color: #fff;
            background: var(--bg-hover);
        }

        .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(0, 210, 255, 0.15), transparent);
            border-right: 3px solid var(--accent);
        }

        .nav-link.active i {
            color: var(--accent);
        }

        .sidebar-footer {
            padding: 18px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cloud-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--success);
            font-weight: 600;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--success);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            margin-right: 280px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-navbar {
            height: 70px;
            background: rgba(21, 26, 35, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .navbar-title {
            font-size: 20px;
            font-weight: 800;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-live-store {
            background: rgba(0, 210, 255, 0.1);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-live-store:hover {
            background: var(--accent);
            color: #000;
        }

        .content-body {
            padding: 30px;
            flex: 1;
        }

        /* Flash Alerts */
        .alert {
            padding: 14px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: rgba(0, 230, 118, 0.12);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(255, 23, 68, 0.12);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #0099FF);
            color: #000;
            box-shadow: 0 4px 14px var(--accent-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 210, 255, 0.35);
        }

        .btn-secondary {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-secondary:hover {
            background: var(--bg-hover);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: var(--radius-sm);
        }

        .btn-danger {
            background: rgba(255, 23, 68, 0.15);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: #fff;
        }

        /* Cards & Tables */
        .card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 17px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        th {
            background: var(--bg-card);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13.5px;
            color: var(--text-main);
            vertical-align: middle;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .badge-pending { background: rgba(255, 214, 0, 0.15); color: var(--warning); border: 1px solid var(--warning); }
        .badge-processing { background: rgba(41, 121, 255, 0.15); color: var(--info); border: 1px solid var(--info); }
        .badge-shipped { background: rgba(0, 210, 255, 0.15); color: var(--accent); border: 1px solid var(--accent); }
        .badge-delivered { background: rgba(0, 230, 118, 0.15); color: var(--success); border: 1px solid var(--success); }
        .badge-cancelled { background: rgba(255, 23, 68, 0.15); color: var(--danger); border: 1px solid var(--danger); }

        /* Forms */
        .form-control, .form-select {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 26px;
            animation: modalIn 0.3s ease;
        }

        @keyframes modalIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-right: 0; }
            .mobile-toggle { display: block !important; }
        }

        .mobile-toggle {
            display: none;
            font-size: 22px;
            color: #fff;
            cursor: pointer;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div class="brand-text">
                <h2>TECH MART</h2>
                <span>لوحة تحكم المتجر</span>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>نظرة عامة (Overview)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open"></i>
                    <span>إدارة الطلبات (Orders)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products') }}" class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                    <span>المنتجات (Products)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.coupons') }}" class="nav-link {{ request()->routeIs('admin.coupons') ? 'active' : '' }}">
                    <i class="fa-solid fa-ticket"></i>
                    <span>الكوبونات (Coupons)</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.customers') }}" class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>العملاء (Customers)</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="cloud-status">
                <div class="pulse-dot"></div>
                <span>متصل بالسحابة (24/7)</span>
            </div>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-secondary btn-sm" title="فحص حالة الـ API">
                <i class="fa-solid fa-server"></i>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="top-navbar">
            <div style="display: flex; align-items: center; gap: 16px;">
                <i class="fa-solid fa-bars mobile-toggle" onclick="toggleSidebar()"></i>
                <h1 class="navbar-title">@yield('page_title', 'لوحة التحكم')</h1>
            </div>

            <div class="navbar-actions">
                <a href="{{ url('/api/products') }}" target="_blank" class="btn-live-store">
                    <i class="fa-solid fa-cloud"></i>
                    <span>API Endpoint</span>
                </a>
            </div>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
    @yield('scripts')
</body>
</html>
