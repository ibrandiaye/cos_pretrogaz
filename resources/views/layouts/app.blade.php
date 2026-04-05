<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'COS-PETROGAZ') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #0f172a;
                --primary-light: #1e293b;
                --accent: #3b82f6;
                --accent-hover: #2563eb;
                --accent-light: #dbeafe;
                --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                --success: #10b981;
                --warning: #f59e0b;
                --danger: #ef4444;
                --info: #06b6d4;
                --surface: #ffffff;
                --surface-secondary: #f8fafc;
                --surface-tertiary: #f1f5f9;
                --border: #e2e8f0;
                --border-light: #f1f5f9;
                --text-primary: #0f172a;
                --text-secondary: #64748b;
                --text-muted: #94a3b8;
                --radius-sm: 0.5rem;
                --radius-md: 0.75rem;
                --radius-lg: 1rem;
                --radius-xl: 1.25rem;
                --radius-2xl: 1.5rem;
                --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
                --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
                --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.05);
                --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
            }

            * { box-sizing: border-box; }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background-color: var(--surface-secondary);
                color: var(--text-primary);
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* ── Sidebar ── */
            .sidebar {
                width: 260px;
                height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                background: var(--primary);
                color: white;
                z-index: 1040;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease;
            }
            .sidebar-brand {
                padding: 1.5rem 1.25rem;
                border-bottom: 1px solid rgba(255,255,255,0.08);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                text-decoration: none;
            }
            .sidebar-brand-icon {
                width: 36px;
                height: 36px;
                background: var(--accent-gradient);
                border-radius: var(--radius-md);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .sidebar-brand-text {
                font-weight: 800;
                font-size: 1.1rem;
                letter-spacing: -0.02em;
                color: white;
            }
            .sidebar-brand-text span { color: var(--accent); }
            .sidebar-nav { padding: 1rem 0.75rem; flex: 1; overflow-y: auto; }
            .sidebar-section {
                font-size: 0.65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: rgba(255,255,255,0.35);
                padding: 0 0.75rem;
                margin: 1.25rem 0 0.5rem;
            }
            .sidebar-link {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.65rem 0.75rem;
                border-radius: var(--radius-md);
                color: rgba(255,255,255,0.6);
                text-decoration: none;
                font-size: 0.875rem;
                font-weight: 500;
                transition: all 0.15s ease;
                margin-bottom: 2px;
            }
            .sidebar-link:hover {
                background: rgba(255,255,255,0.08);
                color: white;
            }
            .sidebar-link.active {
                background: rgba(59,130,246,0.15);
                color: var(--accent);
            }
            .sidebar-link i { font-size: 1.15rem; width: 20px; text-align: center; }
            .sidebar-footer {
                padding: 1rem 1.25rem;
                border-top: 1px solid rgba(255,255,255,0.08);
            }
            .sidebar-user {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.5rem;
                border-radius: var(--radius-md);
                text-decoration: none;
                color: rgba(255,255,255,0.7);
                transition: all 0.15s ease;
            }
            .sidebar-user:hover { background: rgba(255,255,255,0.08); color: white; }
            .sidebar-avatar {
                width: 36px;
                height: 36px;
                background: var(--accent-gradient);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 0.85rem;
                color: white;
                flex-shrink: 0;
            }
            .sidebar-user-name { font-size: 0.85rem; font-weight: 600; }
            .sidebar-user-email { font-size: 0.7rem; color: rgba(255,255,255,0.4); }

            /* ── Main Content ── */
            .main-wrapper {
                margin-left: 260px;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* ── Top Bar ── */
            .topbar {
                background: var(--surface);
                border-bottom: 1px solid var(--border);
                padding: 1rem 2rem;
                position: sticky;
                top: 0;
                z-index: 1030;
            }

            /* ── Content ── */
            .content-area {
                padding: 1.5rem 2rem 3rem;
                flex: 1;
            }

            /* ── Cards ── */
            .card-modern {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-sm);
                transition: all 0.2s ease;
            }
            .card-modern:hover {
                box-shadow: var(--shadow-lg);
                border-color: var(--border);
            }

            /* ── Buttons ── */
            .btn-accent {
                background: var(--accent-gradient);
                border: none;
                color: white;
                font-weight: 600;
                padding: 0.6rem 1.5rem;
                border-radius: var(--radius-md);
                font-size: 0.875rem;
                transition: all 0.2s ease;
                box-shadow: 0 1px 3px rgba(59,130,246,0.3);
            }
            .btn-accent:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(59,130,246,0.35);
                color: white;
            }
            .btn-accent:active { transform: translateY(0); }

            .btn-ghost {
                background: transparent;
                border: 1px solid var(--border);
                color: var(--text-secondary);
                font-weight: 600;
                padding: 0.6rem 1.25rem;
                border-radius: var(--radius-md);
                font-size: 0.875rem;
                transition: all 0.15s ease;
            }
            .btn-ghost:hover {
                background: var(--surface-tertiary);
                border-color: #cbd5e1;
                color: var(--text-primary);
            }

            .btn-dark-modern {
                background: var(--primary);
                border: none;
                color: white;
                font-weight: 600;
                padding: 0.6rem 1.25rem;
                border-radius: var(--radius-md);
                font-size: 0.875rem;
                transition: all 0.2s ease;
            }
            .btn-dark-modern:hover {
                background: var(--primary-light);
                color: white;
                transform: translateY(-1px);
            }

            /* ── KPI Cards ── */
            .kpi-card {
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius-xl);
                padding: 1.5rem;
                position: relative;
                overflow: hidden;
            }
            .kpi-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
            }
            .kpi-card.kpi-blue::before { background: var(--accent-gradient); }
            .kpi-card.kpi-green::before { background: linear-gradient(135deg, #10b981, #059669); }
            .kpi-card.kpi-amber::before { background: linear-gradient(135deg, #f59e0b, #d97706); }
            .kpi-card.kpi-cyan::before { background: linear-gradient(135deg, #06b6d4, #0891b2); }
            .kpi-card.kpi-purple::before { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
            .kpi-card.kpi-red::before { background: linear-gradient(135deg, #ef4444, #dc2626); }
            .kpi-label {
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--text-muted);
                margin-bottom: 0.5rem;
            }
            .kpi-value {
                font-size: 1.75rem;
                font-weight: 800;
                letter-spacing: -0.03em;
                line-height: 1.2;
            }
            .kpi-unit {
                font-size: 0.85rem;
                font-weight: 500;
                color: var(--text-muted);
                margin-left: 2px;
            }
            .kpi-icon {
                width: 40px;
                height: 40px;
                border-radius: var(--radius-md);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            /* ── Tables ── */
            .table-modern {
                border-collapse: separate;
                border-spacing: 0;
            }
            .table-modern thead th {
                background: var(--surface-tertiary);
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: var(--text-secondary);
                padding: 0.85rem 1rem;
                border: none;
                white-space: nowrap;
            }
            .table-modern thead th:first-child { border-radius: var(--radius-md) 0 0 var(--radius-md); }
            .table-modern thead th:last-child { border-radius: 0 var(--radius-md) var(--radius-md) 0; }
            .table-modern tbody td {
                padding: 0.75rem 1rem;
                border-bottom: 1px solid var(--border-light);
                font-size: 0.875rem;
                vertical-align: middle;
            }
            .table-modern tbody tr:last-child td { border-bottom: none; }
            .table-modern tbody tr:hover td { background: var(--surface-secondary); }

            /* ── Form Controls ── */
            .form-modern {
                background: var(--surface-secondary);
                border: 1px solid var(--border);
                border-radius: var(--radius-md);
                padding: 0.65rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--text-primary);
                transition: all 0.15s ease;
            }
            .form-modern:focus {
                border-color: var(--accent);
                box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
                background: var(--surface);
                outline: none;
            }
            .form-label-modern {
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--text-secondary);
                margin-bottom: 0.4rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }

            /* ── Tab Navigation ── */
            .tab-nav {
                display: flex;
                gap: 0.25rem;
                background: var(--surface);
                padding: 0.35rem;
                border-radius: var(--radius-lg);
                border: 1px solid var(--border);
            }
            .tab-btn {
                padding: 0.6rem 1.25rem;
                border-radius: var(--radius-md);
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--text-secondary);
                background: transparent;
                border: none;
                cursor: pointer;
                transition: all 0.15s ease;
                white-space: nowrap;
            }
            .tab-btn:hover { background: var(--surface-secondary); color: var(--text-primary); }
            .tab-btn.active {
                background: var(--primary);
                color: white;
                box-shadow: var(--shadow-sm);
            }

            /* ── Badges ── */
            .badge-modern {
                font-size: 0.7rem;
                font-weight: 700;
                padding: 0.3rem 0.65rem;
                border-radius: 999px;
                letter-spacing: 0.02em;
            }
            .badge-blue { background: var(--accent-light); color: var(--accent); }
            .badge-amber { background: #fef3c7; color: #d97706; }
            .badge-green { background: #d1fae5; color: #059669; }
            .badge-purple { background: #ede9fe; color: #7c3aed; }

            /* ── Alert ── */
            .alert-modern {
                border: none;
                border-radius: var(--radius-lg);
                padding: 0.85rem 1.25rem;
                font-weight: 600;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            .alert-success-modern {
                background: #ecfdf5;
                color: #065f46;
            }
            .alert-error-modern {
                background: #fef2f2;
                color: #991b1b;
            }

            /* ── Responsive ── */
            .sidebar-toggle {
                display: none;
                background: var(--primary);
                border: none;
                color: white;
                padding: 0.5rem;
                border-radius: var(--radius-sm);
                font-size: 1.25rem;
                cursor: pointer;
            }
            @media (max-width: 991.98px) {
                .sidebar { transform: translateX(-100%); }
                .sidebar.show { transform: translateX(0); }
                .main-wrapper { margin-left: 0; }
                .sidebar-toggle { display: inline-flex; }
                .sidebar-overlay {
                    position: fixed;
                    inset: 0;
                    background: rgba(0,0,0,0.5);
                    z-index: 1035;
                    display: none;
                }
                .sidebar-overlay.show { display: block; }
                .content-area { padding: 1rem; }
                .topbar { padding: 0.75rem 1rem; }
            }

            /* ── Animations ── */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-in {
                animation: fadeInUp 0.3s ease forwards;
            }

            /* ── Scrollbar ── */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
    </head>
    <body>
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        @auth
        <aside class="sidebar" id="sidebar">
            <a href="{{ route('projects.index') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-lightning-charge-fill text-white"></i>
                </div>
                <div class="sidebar-brand-text">COS-<span>PETROGAZ</span></div>
            </a>

            <nav class="sidebar-nav">
                <div class="sidebar-section">Navigation</div>
                <a href="{{ route('projects.index') }}" class="sidebar-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Mes Projets</span>
                </a>
                <a href="{{ route('projects.create') }}" class="sidebar-link {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Nouveau Projet</span>
                </a>

                <div class="sidebar-section">Outils</div>
                @if(isset($project))
                <a href="{{ route('projects.show', $project) }}" class="sidebar-link {{ request()->routeIs('projects.show') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>Parametres</span>
                </a>
                <a href="{{ route('dashboards.show', $project) }}" class="sidebar-link {{ request()->routeIs('dashboards.show') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <span>Analytics</span>
                </a>
                <a href="{{ route('dashboards.state', $project) }}" class="sidebar-link {{ request()->routeIs('dashboards.state') ? 'active' : '' }}">
                    <i class="bi bi-bank2"></i>
                    <span>Vue Etatique</span>
                </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <div class="dropdown">
                    <a href="#" class="sidebar-user" data-bs-toggle="dropdown">
                        <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <div>
                            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                            <div class="sidebar-user-email">{{ Auth::user()->email }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mb-2">
                        <li><a class="dropdown-item fw-semibold" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item fw-semibold text-danger"><i class="bi bi-box-arrow-left me-2"></i>Deconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        @endauth

        <!-- Main Content -->
        <div class="main-wrapper">
            <!-- Top Bar -->
            <div class="topbar">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <button class="sidebar-toggle" onclick="toggleSidebar()">
                            <i class="bi bi-list"></i>
                        </button>
                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>
                    @isset($actions)
                        <div class="d-flex align-items-center gap-2">
                            {{ $actions }}
                        </div>
                    @endisset
                </div>
            </div>

            <!-- Page Content -->
            <main class="content-area">
                @if(session('success'))
                    <div class="alert-modern alert-success-modern mb-4 animate-in">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-modern alert-error-modern mb-4 animate-in">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ session('error') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('show');
                document.getElementById('sidebarOverlay').classList.toggle('show');
            }
        </script>
        @stack('scripts')
    </body>
</html>
