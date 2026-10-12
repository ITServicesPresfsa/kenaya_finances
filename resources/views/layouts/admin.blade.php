<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Administration') — Kenaya Finances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/kenaya.css') }}" rel="stylesheet">
    <style>
        .admin-sidebar { width: 250px; min-height: 100vh; }
        .admin-sidebar .nav-link { color: rgba(255,255,255,.75); border-radius: .5rem; }
        .admin-sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.08); }
        .admin-sidebar .nav-link.active { color: #fff; background: var(--k-green); }
        @media (max-width: 991.98px) { .admin-sidebar { width: 100%; min-height: auto; } }
    </style>
    @stack('head')
</head>
<body class="bg-light">
<div class="d-lg-flex">
    <aside class="admin-sidebar bg-navy p-3 flex-shrink-0">
        <a class="d-inline-block bg-white rounded p-2 mb-3" href="#">
    <img src="{{ asset('images/logo.png') }}" alt="Kenaya Finances" height="48"
         class="d-inline-block align-middle" style="width:auto">
</a>
        <ul class="nav nav-pills flex-column gap-1">
            @foreach ([
                ['admin.dashboard', 'bi-speedometer2', 'Tableau de bord', 'admin.dashboard'],
                ['admin.news.index', 'bi-newspaper', 'Actualités', 'admin.news.*'],
                ['admin.categories.index', 'bi-tags', 'Catégories', 'admin.categories.*'],
                ['admin.services.index', 'bi-briefcase', 'Services', 'admin.services.*'],
                ['admin.contacts.index', 'bi-envelope', 'Messages', 'admin.contacts.*'],
                ['admin.settings.index', 'bi-gear', 'Paramètres', 'admin.settings.*'],
            ] as [$route, $icon, $label, $pattern])
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}" href="{{ route($route) }}">
                        <i class="bi {{ $icon }} me-2"></i>{{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
        <hr class="border-secondary">
        <a href="{{ route('home') }}" target="_blank" class="nav-link text-white-50 small px-3">
            <i class="bi bi-box-arrow-up-right me-2"></i>Voir le site
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" class="px-1 mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
            </button>
        </form>
    </aside>

    <div class="flex-grow-1">
        <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
            <h1 class="h5 fw-bold mb-0">@yield('heading', 'Administration')</h1>
            <span class="text-muted small"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span>
        </header>
        <main class="p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>