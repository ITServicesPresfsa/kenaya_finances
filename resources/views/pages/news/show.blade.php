@extends('layouts.app')

@section('title', ($news->meta_title ?: $news->title) . ' — Kenaya Finances')
@section('description', $news->meta_description ?: \Illuminate\Support\Str::limit($news->excerpt ?: strip_tags($news->content), 155))
@section('og_type', 'article')

@push('head')
    @if ($news->published_at)
        <meta property="article:published_time" content="{{ $news->published_at->toIso8601String() }}">
    @endif
    @if ($news->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $news->featured_image) }}">
    @endif
@endpush

@php
    $words   = count(preg_split('/\s+/u', trim(strip_tags($news->content)), -1, PREG_SPLIT_NO_EMPTY));
    $minutes = max(1, (int) ceil($words / 200));
    $url     = urlencode(url()->current());
    $text    = urlencode($news->title);
    $related = $related ?? collect();
@endphp

@section('content')

<div class="read-progress" id="readProgress" aria-hidden="true"></div>

{{-- ═════════ EN-TÊTE ═════════ --}}
<section class="hero hero-sm hero-article {{ $news->featured_image ? 'has-cover' : '' }}">
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>
    <div class="container position-relative text-center reveal">
        <nav aria-label="Fil d'Ariane" class="mb-3 small">
            <a href="{{ route('home') }}" class="text-white-50">Accueil</a>
            <span class="text-white-50 mx-1">/</span>
            <a href="{{ route('news.index') }}" class="text-white-50">Actualités</a>
        </nav>
        @if ($news->category)
            <a href="{{ route('news.index', ['category' => $news->category->slug]) }}"
               class="badge bg-bright text-decoration-none mb-3 fs-6">{{ $news->category->name }}</a>
        @endif
        <h1 class="display-5 fw-bold text-white col-lg-10 mx-auto mb-3">{{ $news->title }}</h1>
        <div class="article-meta">
            @if ($news->published_at)
                <span><i class="bi bi-calendar3"></i>
                    <time datetime="{{ $news->published_at->toDateString() }}">{{ $news->published_at->translatedFormat('d F Y') }}</time>
                </span>
            @endif
            <span><i class="bi bi-clock"></i>{{ $minutes }} min de lecture</span>
        </div>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" fill="#ffffff"/>
    </svg>
</section>

{{-- ═════════ IMAGE DE COUVERTURE ═════════ --}}
@if ($news->featured_image)
    <div class="container article-cover reveal">
        <div class="col-lg-10 mx-auto p-0">
            <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}">
        </div>
    </div>
@endif

{{-- ═════════ CONTENU ═════════ --}}
<article class="py-5">
    <div class="container">
        <div class="article-body">

            @if ($news->excerpt)
                <p class="lead fw-semibold text-navy mb-4">{{ $news->excerpt }}</p>
            @endif

            <div class="article-content" id="articleBody">
                {{-- Le contenu doit être assaini à l'enregistrement (côté admin) avant d'utiliser {!! !!} --}}
                {!! $news->content !!}
            </div>

            {{-- Partage --}}
            <div class="share-bar mt-5">
                <strong class="me-2">Partager :</strong>
                <a class="share-btn" target="_blank" rel="noopener" aria-label="Partager sur WhatsApp"
                   href="https://wa.me/?text={{ $text }}%20{{ $url }}"><i class="bi bi-whatsapp"></i></a>
                <a class="share-btn" target="_blank" rel="noopener" aria-label="Partager sur Facebook"
                   href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"><i class="bi bi-facebook"></i></a>
                <a class="share-btn" target="_blank" rel="noopener" aria-label="Partager sur LinkedIn"
                   href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}"><i class="bi bi-linkedin"></i></a>
                <a class="share-btn" target="_blank" rel="noopener" aria-label="Partager sur X"
                   href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $text }}"><i class="bi bi-twitter-x"></i></a>
                <button type="button" id="copyLink" class="btn btn-outline-primary btn-sm ms-auto">
                    <i class="bi bi-link-45deg"></i> <span>Copier le lien</span>
                </button>
            </div>

            <div class="mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Retour aux actualités
                </a>
            </div>
        </div>
    </div>
</article>

{{-- ═════════ À LIRE AUSSI ═════════ --}}
@if ($related->isNotEmpty())
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 title-accent reveal">À lire aussi</h2>
        <div class="row g-4">
            @foreach ($related as $i => $item)
                <div class="col-md-6 col-lg-4 reveal" style="--d: {{ $i * 0.12 }}s">
                    <article class="card news-card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="thumb-wrap">
                            @if ($item->featured_image)
                                <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}"
                                     class="card-img-top news-thumb" loading="lazy">
                            @else
                                <div class="news-ph"><i class="bi bi-newspaper"></i></div>
                            @endif
                        </div>
                        @if ($item->category)
                            <span class="badge bg-bright position-absolute top-0 start-0 m-3">{{ $item->category->name }}</span>
                        @endif
                        <div class="card-body">
                            @if ($item->published_at)
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $item->published_at->translatedFormat('d F Y') }}</small>
                            @endif
                            <h3 class="h5 fw-bold mt-1">{{ $item->title }}</h3>
                            <p class="text-muted">{{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 110) }}</p>
                            <a href="{{ route('news.show', $item->slug) }}" class="stretched-link read-more">Lire l'article <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═════════ APPEL À L'ACTION ═════════ --}}
<section class="cta-band py-5">
    <span class="blob blob-1"></span>
    <div class="container position-relative text-center py-lg-4 reveal">
        <h2 class="fw-bold display-6">Une question sur nos services ?</h2>
        <p class="mb-4 lead">Rendez-vous dans l'une de nos agences ou écrivez-nous : notre équipe vous accompagne.</p>
        <a href="{{ route('contact') }}" class="btn btn-bright btn-lg">Contactez-nous <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    var bar = document.getElementById('readProgress');
    var art = document.getElementById('articleBody');

    function update() {
        if (!bar || !art) return;
        var r = art.getBoundingClientRect();
        var total = r.height - window.innerHeight * 0.5;
        var done = Math.min(Math.max(-r.top + window.innerHeight * 0.3, 0), Math.max(total, 0));
        bar.style.width = (total > 0 ? (done / total) * 100 : 100) + '%';
    }
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();

    var btn = document.getElementById('copyLink');
    if (btn) {
        btn.addEventListener('click', function () {
            var label = btn.querySelector('span');
            function ok() {
                label.textContent = 'Lien copié !';
                setTimeout(function () { label.textContent = 'Copier le lien'; }, 2000);
            }
            if (navigator.clipboard) {
                navigator.clipboard.writeText(window.location.href).then(ok);
            } else {
                var t = document.createElement('textarea');
                t.value = window.location.href;
                document.body.appendChild(t);
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
                ok();
            }
        });
    }
})();
</script>
@endpush