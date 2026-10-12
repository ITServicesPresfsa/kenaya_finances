@extends('layouts.app')

@section('title', 'Contact — Kenaya Finances')
@section('description', 'Contactez Kenaya Finances à Brazzaville : téléphone, e-mail, adresse et formulaire.')

@php
    $heroBg = file_exists(public_path('images/contact-hero.jpg'))
        ? "url('" . asset('images/contact-hero.jpg') . "')" : null;

    $address = '219 Avenue Nelson Mandela, Brazzaville, République du Congo';
    $mapUrl  = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
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
            <span>Contact</span>
        </nav>
        <h1 class="display-4 fw-bold text-white mb-3">Contactez-nous</h1>
        <p class="lead col-lg-7 mx-auto mb-0">Rendez-vous dans l'une de nos agences ou écrivez-nous.</p>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" fill="#ffffff"/>
    </svg>
</section>

{{-- ═════════ COORDONNÉES + FORMULAIRE ═════════ --}}
<section class="pb-5">
    <div class="container overlap-top">
        <div class="row g-4 g-lg-5">

            {{-- Coordonnées --}}
            <div class="col-lg-5 reveal">
                <h2 class="h4 fw-bold mb-4 text-white d-none d-lg-block">&nbsp;</h2>
                <div class="d-grid gap-3">
                    <a href="mailto:contact@kenayafinances.com" class="info-tile">
                        <span class="icon-bubble"><i class="bi bi-envelope"></i></span>
                        <span><small>E-mail</small><strong>contact@kenayafinances.com</strong></span>
                    </a>
                    <a href="tel:+242064973349" class="info-tile">
                        <span class="icon-bubble"><i class="bi bi-telephone"></i></span>
                        <span><small>Téléphone</small><strong>+242 06 497 3349</strong></span>
                    </a>
                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="info-tile">
                        <span class="icon-bubble"><i class="bi bi-geo-alt"></i></span>
                        <span><small>Adresse</small><strong>{{ $address }}</strong>
                            <span class="d-block small text-primary fw-semibold mt-1">Voir sur la carte <i class="bi bi-box-arrow-up-right"></i></span>
                        </span>
                    </a>
                </div>

                <h2 class="h6 fw-bold mt-4 mb-3">Suivez-nous</h2>
                <div class="d-flex flex-wrap gap-2">
                    <a class="share-btn" href="https://www.facebook.com/kenayacg/about?locale=fr_FR" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a class="share-btn" href="https://www.instagram.com/kenayafinances" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a class="share-btn" href="https://www.tiktok.com/@kenaya_finances" target="_blank" rel="noopener" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a class="share-btn" href="https://cg.linkedin.com/company/kenaya-finances" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                    <a class="share-btn" href="https://youtube.com/@kenayafinances" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="col-lg-7 reveal" style="--d:.12s">
                <div class="card form-card" id="formulaire">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h4 fw-bold mb-1">Envoyez-nous un message</h2>
                        <p class="text-muted mb-4">Les champs marqués d'un * sont obligatoires.</p>

                        @if (session('success'))
                            <div class="success-box mb-4" role="status">
                                <i class="bi bi-check-circle-fill"></i>
                                <div>
                                    <strong class="d-block">Message envoyé</strong>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <strong>Merci de corriger les champs signalés :</strong>
                                <ul class="mb-0 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}" id="contactForm" novalidate>
                            @csrf
                            <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">Prénom *</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" maxlength="100"
                                    class="form-control @error('first_name') is-invalid @enderror" required aria-required="true">
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" maxlength="100"
                                    class="form-control @error('last_name') is-invalid @enderror" required aria-required="true">
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse e-mail *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="255"
                                    class="form-control @error('email') is-invalid @enderror" required aria-required="true">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone (facultatif)</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                                    class="form-control @error('phone') is-invalid @enderror">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Sujet *</label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" maxlength="200"
                                    class="form-control @error('subject') is-invalid @enderror" required aria-required="true">
                                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message *</label>
                                <textarea id="message" name="message" rows="6" minlength="20" maxlength="3000"
                                        class="form-control @error('message') is-invalid @enderror" required aria-required="true">{{ old('message') }}</textarea>
                                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text d-flex justify-content-between">
                                    <span>Minimum 20 caractères.</span>
                                    <span><span id="msgCount">0</span> / 3000</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="contactSubmit" class="btn btn-primary btn-lg w-100">
                                    <span class="label">Envoyer le message <i class="bi bi-send ms-1"></i></span>
                                </button>
                            </div>

                              </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═════════ APPEL À L'ACTION ═════════ --}}
<section class="cta-band py-5">
    <span class="blob blob-1"></span>
    <div class="container position-relative text-center py-lg-4 reveal">
        <h2 class="fw-bold display-6">Préférez-vous venir nous voir ?</h2>
        <p class="mb-4 lead">Nos conseillers vous accueillent et vous orientent en agence.</p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="btn btn-bright btn-lg">
                <i class="bi bi-geo-alt me-1"></i> Voir sur la carte
            </a>
            <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg">Nos services</a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    var form = document.getElementById('contactForm');
    var btn  = document.getElementById('contactSubmit');

    // Anti double-envoi
    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.classList.add('btn-loading');
            btn.setAttribute('aria-disabled', 'true');
            btn.querySelector('.label').innerHTML =
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Envoi en cours…';
        });
    }

    // Après envoi ou erreur : ramener le visiteur sur le formulaire
    @if (session('success') || $errors->any())
        var card = document.getElementById('formulaire');
        if (card) card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    @endif
})();
</script>
@endpush