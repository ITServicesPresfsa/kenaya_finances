<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.add('js')</script>
    <title>@yield('title', 'Kenaya Finances')</title>
    <meta name="description" content="@yield('description', 'Kenaya Finances : transferts d\'argent, Mobile Money, cartes VISA prépayées et recharges à Brazzaville.')">
    <meta property="og:title" content="@yield('title', 'Kenaya Finances')">
    <meta property="og:description" content="@yield('description', 'Kenaya Finances à Brazzaville')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/kenaya.css') }}" rel="stylesheet">
    <!-- <style>
        :root { --bs-primary: #0b5ed7; --bs-primary-rgb: 11,94,215; }
        .btn-primary { --bs-btn-bg: var(--bs-primary); --bs-btn-border-color: var(--bs-primary); }
        .text-primary { color: var(--bs-primary) !important; }
        .bg-primary { background-color: var(--bs-primary) !important; }
        .card { transition: transform .2s ease, box-shadow .2s ease; }
        .card:hover { transform: translateY(-3px); }
        .article-content img { max-width: 100%; height: auto; }
    </style> -->
    @stack('head')
</head>
<body class="d-flex flex-column min-vh-100">
    <a href="#content" class="visually-hidden-focusable">Aller au contenu</a>
    @include('partials.navbar')
    <main id="content" class="flex-grow-1">
        @yield('content')
    </main>
    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/site.js') }}" defer></script>
    @stack('scripts')
</body>
</html>