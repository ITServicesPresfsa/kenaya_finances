<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
<a class="navbar-brand py-0" href="{{ route('home') }}">
    <img src="{{ asset('images/logo.png') }}" alt="Kenaya Finances" height="48"
         class="d-inline-block align-middle" style="width:auto">
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                aria-controls="menu" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                @foreach ([
                    ['home', 'Accueil', 'home'],
                    ['about', 'À propos de nous', 'about'],
                    ['services', 'Services', 'services'],
                    ['news.index', 'Actualités', 'news.*'],
                    ['contact', 'Contact', 'contact'],
                ] as [$route, $label, $pattern])
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($pattern) ? 'active fw-semibold text-primary' : '' }}"
                           href="{{ route($route) }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>