<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ auth()->user() ? auth()->user()->currentAccessToken()?->plainTextToken : '' }}">
    <meta name="theme-color" content="#20B2AA">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SiAPPMan">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192x192.png">

    <title>@yield('title', 'SiAPPMan - QR Scanner')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Toastify.js assets -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        :root {
            --font-sans: 'Inter', sans-serif;
            --background: #FFFFFF;
            --foreground: #0A0A0A;
            --card: #FFFFFF;
            --card-foreground: #0A0A0A;
            --popover: #FFFFFF;
            --popover-foreground: #0A0A0A;
            --primary: #0A0A0A;
            --primary-foreground: #FAFAFA;
            --secondary: #F4F4F5;
            --secondary-foreground: #0A0A0A;
            --muted: #F4F4F5;
            --muted-foreground: #71717A;
            --accent: #F4F4F5;
            --accent-foreground: #0A0A0A;
            --destructive: #DC2626;
            --destructive-foreground: #FAFAFA;
            --border: #E4E4E7;
            --input: #E4E4E7;
            --ring: #0A0A0A;
            --radius: 0.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--background);
            color: var(--foreground);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border: 1px solid transparent;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .btn-primary:hover {
            background-color: rgba(10, 10, 10, 0.9);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
        }

        .btn-secondary:hover {
            background-color: #E4E4E7;
        }

        .card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background-color: transparent;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--input);
            border-radius: var(--radius);
            font-size: 0.875rem;
            background-color: var(--background);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--ring);
            box-shadow: 0 0 0 2px rgba(10, 10, 10, 0.1);
        }

        .navbar {
            background: var(--background);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 50;
            height: 65px;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--foreground);
            text-decoration: none;
        }

        .sidebar {
            background: var(--background);
            border-right: 1px solid var(--border);
            height: calc(100vh - 65px);
            position: fixed;
            left: 0;
            top: 65px;
            width: 260px;
            padding: 1rem 0;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 1rem;
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--muted-foreground);
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 0.75rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--foreground);
            text-decoration: none;
            border-radius: var(--radius);
            transition: background-color 0.2s ease, color 0.2s ease;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .sidebar-menu a:hover {
            background-color: var(--accent);
        }

        .sidebar-menu a.active {
            background: var(--primary);
            color: var(--primary-foreground);
        }

        .sidebar-text {
            flex: 1;
        }

        .main-content {
            margin-left: 260px;
            padding: 2.5rem;
            min-height: calc(100vh - 65px);
            opacity: 0;
            animation: fadeIn 0.4s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            border: 1px solid var(--border);
        }

        .alert-success {
            background-color: #F0FDF4;
            color: #15803D;
            border-color: #A7F3D0;
        }

        .alert-error {
            background-color: #FEF2F2;
            color: #B91C1C;
            border-color: #FECACA;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 100;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            .card-header, .card-body {
                padding: 1.25rem;
            }
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.125rem;
            font-weight: 500;
            color: var(--foreground);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--radius);
        }
        .mobile-menu-toggle:hover {
            background-color: var(--accent);
        }
    </style>

    @stack('styles')
</head>
<body>
    @if(request()->routeIs('dashboard*') || request()->routeIs('scanner'))
        <nav class="navbar">
            <div class="container">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="mobile-menu-toggle" onclick="toggleSidebar()">Menu</button>
                    <a href="{{ route('dashboard') }}" class="navbar-brand">SiAPPMan</a>
                </div>
            </div>
        </nav>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">Navigasi</h3>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="sidebar-text">Dasbor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                        <span class="sidebar-text">Admin</span>
                    </a>
                </li>
                @if(auth()->user()->is_admin || auth()->user()->can_view_instrument_sets)
                <li>
                    <a href="{{ route('dashboard.instrument-sets.index') }}" class="{{ request()->routeIs('dashboard.instrument-sets*') ? 'active' : '' }}">
                        <span class="sidebar-text">Instrument Sets</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->is_admin || auth()->user()->can_view_qr_codes)
                <li>
                    <a href="{{ route('dashboard.qr-codes') }}" class="{{ request()->routeIs('dashboard.qr-codes*') ? 'active' : '' }}">
                        <span class="sidebar-text">Kode QR</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->is_admin || auth()->user()->can_manage_master_data)
                <li style="padding: 0.75rem 1rem; color: var(--muted-foreground); font-size: 0.8125rem; font-weight: 500;">Master Data</li>
                <li>
                    <a href="{{ route('dashboard.instrument-types.index') }}" class="{{ request()->routeIs('dashboard.instrument-types*') ? 'active' : '' }}">
                        <span class="sidebar-text">Instrument Types</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.units.index') }}" class="{{ request()->routeIs('dashboard.units*') ? 'active' : '' }}">
                        <span class="sidebar-text">Units</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.locations.index') }}" class="{{ request()->routeIs('dashboard.locations*') ? 'active' : '' }}">
                        <span class="sidebar-text">Locations</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->is_admin || auth()->user()->can_view_assets)
                <li style="padding: 0.75rem 1rem; color: var(--muted-foreground); font-size: 0.8125rem; font-weight: 500;">Asset Management</li>
                <li>
                    <a href="{{ route('dashboard.assets.index') }}" class="{{ request()->routeIs('dashboard.assets*') ? 'active' : '' }}">
                        <span class="sidebar-text">Aset</span>
                    </a>
                </li>
                @endif
                @if(auth()->user()->is_admin || auth()->user()->can_view_scan_history)
                <li>
                    <a href="{{ route('dashboard.scan-history') }}" class="{{ request()->routeIs('dashboard.scan-history') ? 'active' : '' }}">
                        <span class="sidebar-text">Riwayat Pemindaian</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('dashboard.profile') }}" class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                        <span class="sidebar-text">Profil</span>
                    </a>
                </li>
                @if(auth()->user()->is_admin || auth()->user()->can_use_scanner)
                <li>
                    <a href="{{ route('scanner') }}" class="{{ request()->routeIs('scanner') ? 'active' : '' }}">
                        <span class="sidebar-text">Pemindai</span>
                    </a>
                </li>
                @endif
                <li style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--border);">
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn" style="width: 100%; justify-content: flex-start; background: none; border: none; color: var(--foreground); padding: 0.75rem 1rem; font-weight: 500;">
                            <span class="sidebar-text">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>
    @endif

    <main class="{{ request()->routeIs('dashboard*') || request()->routeIs('scanner') ? 'main-content' : '' }}">
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => {
                        console.log('Service Worker registered successfully:', registration);
                    })
                    .catch(error => {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
    </script>

    @vite(['resources/js/app.js'])
    @stack('scripts')

    <!-- Toastify.js assets -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                }).showToast();
            @endif

            @if(session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    stopOnFocus: true,
                }).showToast();
            @endif
        });
    </script>
</body>
</html>
