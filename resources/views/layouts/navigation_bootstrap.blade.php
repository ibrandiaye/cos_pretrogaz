<nav class="navbar navbar-expand-lg border-bottom sticky-top">
    <div class="container py-2">
        <a class="navbar-brand fw-black d-flex align-items-center" href="{{ route('dashboard') }}">
             <div class="bg-primary rounded-3 p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <svg class="text-white" width="16" height="16" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
             </div>
             <span class="text-dark">COS-</span><span class="text-primary">PETROGAZ</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-3">
                <li class="nav-item">
                    <a class="nav-link fw-bold ms-2 {{ request()->routeIs('dashboard') ? 'active text-primary' : 'text-secondary' }}" href="{{ route('dashboard') }}">Vue d'ensemble</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold ms-2 {{ request()->routeIs('projects.*') ? 'active text-primary' : 'text-secondary' }}" href="{{ route('projects.index') }}">Simulateur</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle fw-bold rounded-pill px-4 border" type="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item fw-bold text-secondary" href="{{ route('profile.edit') }}">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item fw-bold text-danger">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
