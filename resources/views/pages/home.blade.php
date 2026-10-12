{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Kenaya Finances — Transferts d\'argent, Mobile Money et cartes VISA à Brazzaville')

@push('head')
    <script>document.documentElement.classList.add('js')</script>
@endpush

@php
    // Renvoie url('...') si l'image existe dans public/images, sinon null
    $img = fn (string $file) => file_exists(public_path('images/' . $file))
        ? "url('" . asset('images/' . $file) . "')" : null;

    $heroBg   = $img('hero.jpg');
    $heroSide = $img('hero-side.jpg');
    $approche = $img('approche.jpg');
    $ctaBg    = $img('cta.jpg');

    $partners = glob(public_path('images/partners/*.{png,jpg,jpeg,webp,svg}'), GLOB_BRACE) ?: [];
@endphp

@section('content')

{{-- ═════════ HERO ═════════ --}}
<section class="hero" @if ($heroBg) style="--img: {{ $heroBg }}" @endif>
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>
    <span class="blob blob-3"></span>

    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 reveal">
                <span class="hero-eyebrow mb-3"><i class="bi bi-emoji-smile"></i> Bienvenue chez Kenaya Finances</span>
                <h1 class="display-4 fw-bold text-white mb-3">
                    Envoyez et recevez votre argent en toute sécurité, où que vous soyez
                </h1>
                <p class="lead mb-4">
                    Profitez de chaque visite pour découvrir nos services exclusifs.
                    Votre satisfaction est notre priorité !
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('services') }}" class="btn btn-bright btn-lg">
                        Découvrez nos services <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Nous contacter</a>
                </div>
                <div class="hero-points">
                    <span><i class="bi bi-shield-check"></i>Sécurité</span>
                    <span><i class="bi bi-lightning-charge"></i>Rapidité</span>
                    <span><i class="bi bi-people"></i>Proximité</span>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block reveal" style="--d:.2s">
                <div class="img-frame">
                    <div class="img-slot ratio-hero" @if ($heroSide) style="--img: {{ $heroSide }}" @endif>
                        @unless ($heroSide)
                            <i class="bi bi-image"></i>
                            @env('local') <span class="slot-label">images/hero-side.jpg</span> @endenv
                        @endunless
                    </div>
                    <span class="float-chip chip-1"><i class="bi bi-check-circle-fill"></i>Opération confirmée</span>
                    <span class="float-chip chip-2"><i class="bi bi-geo-alt-fill"></i>En agence ou à distance</span>
                </div>
            </div>
        </div>
    </div>

    <svg class="hero-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" fill="#00d082"/>
    </svg>
</section>

{{-- ═════════ BANDEAU DÉFILANT (noms des services en base) ═════════ --}}
@if ($services->isNotEmpty())
<div class="ticker" aria-hidden="true">
    <div class="ticker-track">
        @for ($r = 0; $r < 2; $r++)
            <div class="ticker-group">
                @for ($k = 0; $k < 4; $k++)
                    @foreach ($services as $service)
                        <span class="ticker-item"><i class="bi bi-stars"></i>{{ $service->name }}</span>
                    @endforeach
                @endfor
            </div>
        @endfor
    </div>
</div>
@endif

{{-- ═════════ 3 ÉTAPES ═════════ --}}
<section class="py-5 my-lg-4">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">Vos transactions en 3 étapes</h2>
        <div class="row g-4">
            @foreach ([
                ['bi-geo-alt', 'Rendez-vous dans l\'une de nos agences', 'Présentez-vous dans l\'une de nos agences avec les informations nécessaires à votre opération. Nos conseillers sont à votre disposition pour vous accueillir et vous orienter.'],
                ['bi-cash-coin', 'Effectuez votre opération', 'Choisissez le service dont vous avez besoin et effectuez votre opération en toute simplicité. Notre équipe vous accompagne pour garantir un traitement fiable et sécurisé.'],
                ['bi-check2-circle', 'Confirmation immédiate', 'Une fois votre transaction validée, vous recevez immédiatement une confirmation de l\'opération. Profitez d\'un service fiable, transparent et efficace.'],
            ] as $i => [$icon, $title, $text])
                <div class="col-md-4 reveal" style="--d: {{ $i * 0.12 }}s">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <span class="step-num">{{ $i + 1 }}</span>
                        <div class="icon-bubble mb-3"><i class="bi {{ $icon }}"></i></div>
                        <h3 class="h5 fw-bold">{{ $title }}</h3>
                        <p class="text-muted mb-0">{{ $text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═════════ SERVICES (base de données) ═════════ --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">Nos services</h2>
        <div class="row g-4">
            @forelse ($services as $i => $service)
                <div class="col-md-6 col-lg-4 reveal" style="--d: {{ ($i % 3) * 0.12 }}s">
                    <div class="card service-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="icon-bubble mb-3"><i class="bi {{ $service->icon ?? 'bi-cash-stack' }}"></i></div>
                            <h3 class="h5 fw-bold">{{ $service->name }}</h3>
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($service->description), 120) }}</p>
                            <a href="{{ route('services') }}#{{ $service->slug }}" class="stretched-link fw-semibold">Plus de détails →</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Nos services seront bientôt disponibles.</p>
            @endforelse
        </div>
        @if ($services->isNotEmpty())
            <div class="text-center mt-5 reveal">
                <a href="{{ route('services') }}" class="btn btn-outline-primary">Voir tous les services</a>
            </div>
        @endif
    </div>
</section>

{{-- ═════════ APPROCHE (texte + photo) ═════════ --}}
<section class="py-5 my-lg-4">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <div class="img-frame">
                    <div class="img-slot ratio-approche" @if ($approche) style="--img: {{ $approche }}" @endif>
                        @unless ($approche)
                            <i class="bi bi-image"></i>
                            @env('local') <span class="slot-label">images/approche.jpg</span> @endenv
                        @endunless
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal" style="--d:.15s">
                <span class="text-uppercase text-primary fw-semibold small">Notre approche</span>
                <h2 class="fw-bold mt-2">Une relation de confiance au cœur de chaque transaction</h2>
                <p class="text-muted">
                    Chez Kenaya Finances, nous mettons la proximité, la sécurité et la rapidité au centre
                    de chaque service afin d'accompagner nos clients avec des solutions financières
                    simples et fiables au quotidien.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary">À propos de nous <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</section>

{{-- ═════════ POURQUOI NOUS ═════════ --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">Pourquoi nous ?</h2>
        <div class="row g-4">
            @foreach ([
                ['bi-people', 'Proximité communautaire', 'Contrairement aux grandes enseignes impersonnelles, nous sommes proches de nos clients : nous connaissons leur réalité, leur langue et leurs besoins.'],
                ['bi-person-heart', 'Accompagnement humain personnalisé', 'Pas de robot, pas de centre d\'appel à l\'autre bout du monde : un vrai agent vous accompagne, en agence ou à distance.'],
                ['bi-shop', 'Entreprise locale et indépendante', 'Nous faisons vivre l\'économie locale et bâtissons une relation durable avec chaque client.'],
            ] as $i => [$icon, $title, $text])
                <div class="col-md-4 reveal" style="--d: {{ $i * 0.12 }}s">
                    <div class="why-card h-100 p-4 bg-white shadow-sm">
                        <div class="icon-bubble mb-3"><i class="bi {{ $icon }}"></i></div>
                        <h3 class="h5 fw-bold">{{ $title }}</h3>
                        <p class="text-muted mb-0">{{ $text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═════════ PARTENAIRES (visible seulement si des logos sont dans public/images/partners) ═════════ --}}
@if (count($partners))
<section class="py-5">
    <div class="container text-center">
        <h2 class="h4 fw-bold mb-4 title-accent reveal">Nos partenaires</h2>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-5 reveal">
            @foreach ($partners as $path)
                <img src="{{ asset('images/partners/' . basename($path)) }}"
                     alt="{{ ucwords(str_replace(['-', '_'], ' ', pathinfo($path, PATHINFO_FILENAME))) }}"
                     class="partner-logo" loading="lazy">
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═════════ DERNIÈRES ACTUALITÉS ═════════ --}}
<section class="py-5 {{ count($partners) ? 'bg-light' : '' }}">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 reveal">
            <h2 class="fw-bold mb-0">Dernières actualités</h2>
            <a href="{{ route('news.index') }}" class="fw-semibold">Toutes les actualités →</a>
        </div>
        <div class="row g-4">
            @forelse ($latestNews as $i => $news)
                <div class="col-md-4 reveal" style="--d: {{ $i * 0.12 }}s">
                    <article class="card h-100 border-0 shadow-sm overflow-hidden">
                        @if ($news->featured_image)
                            <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}"
                                 class="card-img-top news-thumb" loading="lazy">
                        @else
                            <div class="news-ph"><i class="bi bi-newspaper"></i></div>
                        @endif
                        @if ($news->category)
                            <span class="badge bg-bright position-absolute top-0 start-0 m-3">{{ $news->category->name }}</span>
                        @endif
                        <div class="card-body">
                            @if ($news->published_at)
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $news->published_at->translatedFormat('d F Y') }}</small>
                            @endif
                            <h3 class="h5 fw-bold mt-1">{{ $news->title }}</h3>
                            <p class="text-muted">{{ $news->excerpt }}</p>
                            <a href="{{ route('news.show', $news->slug) }}" class="stretched-link fw-semibold">Lire l'article →</a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">
                    <i class="bi bi-newspaper fs-1"></i>
                    <p class="mt-2">Aucune actualité publiée pour le moment. Revenez bientôt !</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═════════ APPEL À L'ACTION ═════════ --}}
<section class="cta-band py-5" @if ($ctaBg) style="--img: {{ $ctaBg }}" @endif>
    <span class="blob blob-1"></span>
    <div class="container position-relative text-center py-lg-4 reveal">
        <h2 class="fw-bold display-6">Besoin d'assistance pour vos opérations financières ?</h2>
        <p class="mb-4 lead">Rendez-vous dans l'une de nos agences pour bénéficier d'un accompagnement rapide, sécurisé et personnalisé.</p>
        <a href="{{ route('contact') }}" class="btn btn-bright btn-lg">Contactez-nous <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    (function () {
        var items = document.querySelectorAll('.reveal');
        if (!('IntersectionObserver' in window)) {
            items.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        items.forEach(function (el) { io.observe(el); });
    })();
</script>
@endpush