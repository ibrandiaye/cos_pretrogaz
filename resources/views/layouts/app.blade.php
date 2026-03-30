<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --bs-primary: #2563eb;
                --bs-primary-rgb: 37, 99, 235;
            }
            body { 
                font-family: 'Outfit', sans-serif; 
                background-color: #f8fafc;
                color: #1e293b;
            }
            .navbar {
                background: rgba(255, 255, 255, 0.9) !important;
                backdrop-filter: blur(10px);
                border-bottom: 1px solid #e2e8f0;
            }
            .card-premium {
                border: none;
                border-radius: 1.25rem;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
                transition: all 0.3s ease;
                background: white;
            }
            .card-premium:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            }
            .btn-premium {
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }
            .btn-primary-premium {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                border: none;
                color: white;
            }
            .btn-primary-premium:hover {
                box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
                transform: scale(1.02);
            }
            .nav-link.active {
                color: var(--bs-primary) !important;
                border-bottom: 3px solid var(--bs-primary);
            }
            .kpi-card {
                padding: 1.5rem;
                border-radius: 1.5rem;
                background: white;
                border: 1px solid #f1f5f9;
            }
            .table-premium thead {
                background-color: #f8fafc;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation_bootstrap')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-bottom py-4 mb-4">
                    <div class="container">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container pb-5">
                {{ $slot }}
            </main>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
