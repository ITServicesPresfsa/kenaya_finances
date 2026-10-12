@extends('layouts.app')

@section('title', 'Nos services — Kenaya Finances')
@section('description', 'Transfert d\'argent, Mobile Money, cartes VISA prépayées et recharges chez Kenaya Finances.')

@php
    $heroBg = file_exists(public_path('images/services-hero.jpg'))
        ? "url('" . asset('images/services-hero.jpg') . "')" : null;
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
            <span>Services</span>
        </nav>
        <h1 class="display-4 fw-bold text-white mb-3">Nos services</h1>
        <p class="lead col-lg-7 mx-auto mb-0">Des solutions financières simples et fiables au quotidien.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" fill="#ffffff"/>
    </svg>
</section>

{{-- ═════════ LISTE DES SERVICES (base de données) ═════════ --}}
<section class="py-5 my-lg-4">
    <div class="container">
        <div class="row g-4">
            @forelse ($services as $i => $service)
                <div class="col-md-6 col-lg-4 service-anchor reveal" id="{{ $service->slug }}"
                     style="--d: {{ ($i % 3) * 0.12 }}s">
                    <div class="card service-card h-100 border-0 shadow-sm">
                        <div class="service-media">
                            @if ($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" loading="lazy">
                            @else
                                <div class="icon-bubble"><i class="bi {{ $service->icon ?? 'bi-cash-stack' }}"></i></div>
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <h2 class="h5 fw-bold">{{ $service->name }}</h2>
                            <p class="text-muted mb-0">{{ $service->short_description ?: $service->description }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-sm">
                                Nous contacter <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-briefcase fs-1"></i>
                    <p class="mt-3">Nos services seront bientôt disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═════════ APPEL À L'ACTION ═════════ --}}
<section class="cta-band py-5">
    <span class="blob blob-1"></span>
    <div class="container position-relative text-center py-lg-4 reveal">
        <h2 class="fw-bold display-6">Besoin d'un renseignement sur un service ?</h2>
        <p class="mb-4 lead">Rendez-vous dans l'une de nos agences ou écrivez-nous : notre équipe vous accompagne.</p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('contact') }}" class="btn btn-bright btn-lg">Contactez-nous <i class="bi bi-arrow-right ms-1"></i></a>
            <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">À propos de nous</a>
        </div>
    </div>
</section>

@endsection