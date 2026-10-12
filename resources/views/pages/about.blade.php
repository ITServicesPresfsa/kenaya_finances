@extends('layouts.app')

@section('title', 'À propos de nous — Kenaya Finances')
@section('description', 'Découvrez l\'approche de Kenaya Finances : proximité, sécurité et accompagnement humain à Brazzaville.')

@php
    $img = fn (string $file) => file_exists(public_path('images/' . $file))
        ? "url('" . asset('images/' . $file) . "')" : null;

    $heroBg = $img('about-hero.jpg');
    $photo  = $img('a-propos.jpg');
    $gallery = glob(public_path('images/about/*.{jpg,jpeg,png,webp}'), GLOB_BRACE) ?: [];
@endphp

@section('content')

{{-- ═════════ EN-TÊTE ═════════ --}}
<section class="hero hero-sm" @if ($heroBg) style="--img: {{ $heroBg }}" @endif>
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>
    <div class="container position-relative text-center reveal">
        <nav aria-label="Fil d'Ariane" class="mb-3 small">
            <a href="{{ route('home') }}" class="text-white-50">Accueil</a>
            <span class="text-white-50 mx-1">/</span>
            <span>À propos de nous</span>
        </nav>
        <h1 class="display-4 fw-bold text-white mb-3">À propos de nous</h1>
        <p class="lead col-lg-7 mx-auto mb-0">Une relation de confiance au cœur de chaque transaction.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" fill="#ffffff"/>
    </svg>
</section>

{{-- ═════════ NOTRE APPROCHE (photo + texte) ═════════ --}}
<section class="py-5 my-lg-4">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal">
                <div class="img-frame">
                    <div class="img-slot ratio-approche" @if ($photo) style="--img: {{ $photo }}" @endif>
                        @unless ($photo)
                            <i class="bi bi-image"></i>
                            @env('local') <span class="slot-label">images/a-propos.jpg</span> @endenv
                        @endunless
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal" style="--d:.15s">
                <span class="text-uppercase text-primary fw-semibold small">Notre approche</span>
                <h2 class="fw-bold mt-2 mb-3">Proximité, sécurité et rapidité au centre de chaque service</h2>
                <p class="text-muted">
                    Chez Kenaya Finances, nous mettons la proximité, la sécurité et la rapidité au centre de chaque
                    service afin d'accompagner nos clients avec des solutions financières simples et fiables au quotidien.
                </p>

                {{-- À COMPLÉTER avec des informations validées par l'entreprise : histoire, mission, vision, valeurs --}}

                <div class="d-flex flex-wrap gap-2 mt-4">
                    @foreach ([['bi-people', 'Proximité'], ['bi-shield-check', 'Sécurité'], ['bi-lightning-charge', 'Rapidité']] as [$icon, $label])
                        <span class="pillar-pill"><i class="bi {{ $icon }}"></i>{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═════════ CE QUI NOUS DISTINGUE ═════════ --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">Ce qui nous distingue</h2>
        <div class="row g-4">
            @foreach ([
                ['bi-people', 'Proximité communautaire', 'Nous sommes proches de nos clients : nous connaissons leur réalité, leur langue et leurs besoins.'],
                ['bi-person-heart', 'Accompagnement humain personnalisé', 'Un vrai agent vous accompagne, en agence ou à distance.'],
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

{{-- ═════════ GALERIE (visible seulement si des photos sont dans public/images/about) ═════════ --}}
@if (count($gallery))
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">Kenaya Finances en images</h2>
        <div class="row g-3">
            @foreach ($gallery as $i => $path)
                <div class="col-6 col-md-4 reveal" style="--d: {{ ($i % 3) * 0.1 }}s">
                    <div class="gallery-item">
                        <img src="{{ asset('images/about/' . basename($path)) }}"
                             alt="Kenaya Finances — photo {{ $i + 1 }}" loading="lazy">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═════════ VENEZ NOUS VOIR ═════════ --}}
<section class="py-5 {{ count($gallery) ? 'bg-light' : '' }}">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">Venez nous voir</h2>
        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="contact-tile">
                    <div class="icon-bubble mx-auto mb-3"><i class="bi bi-geo-alt"></i></div>
                    <h3 class="h6 fw-bold">Adresse</h3>
                    <p class="text-muted mb-0">219 Avenue Nelson Mandela,<br>Brazzaville, République du Congo</p>
                </div>
            </div>
            <div class="col-md-4 reveal" style="--d:.12s">
                <div class="contact-tile">
                    <div class="icon-bubble mx-auto mb-3"><i class="bi bi-telephone"></i></div>
                    <h3 class="h6 fw-bold">Téléphone</h3>
                    <a href="tel:+242064973349" class="fw-semibold">+242 06 497 3349</a>
                </div>
            </div>
            <div class="col-md-4 reveal" style="--d:.24s">
                <div class="contact-tile">
                    <div class="icon-bubble mx-auto mb-3"><i class="bi bi-envelope"></i></div>
                    <h3 class="h6 fw-bold">E-mail</h3>
                    <a href="mailto:contact@kenayafinances.com" class="fw-semibold">contact@kenayafinances.com</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═════════ APPEL À L'ACTION ═════════ --}}
<section class="cta-band py-5">
    <span class="blob blob-1"></span>
    <div class="container position-relative text-center py-lg-4 reveal">
        <h2 class="fw-bold display-6">Une question sur nos services ?</h2>
        <p class="mb-4 lead">Notre équipe est à votre disposition pour vous accueillir et vous orienter.</p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('contact') }}" class="btn btn-bright btn-lg">Contactez-nous <i class="bi bi-arrow-right ms-1"></i></a>
            <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg">Nos services</a>
        </div>
    </div>
</section>

@endsection