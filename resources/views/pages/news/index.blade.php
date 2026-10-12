@extends('layouts.app')

@section('title', 'Actualités — Kenaya Finances')
@section('description', 'Toutes les actualités de Kenaya Finances.')

@php
    $heroBg = file_exists(public_path('images/news-hero.jpg'))
        ? "url('" . asset('images/news-hero.jpg') . "')" : null;

    $filtered = request()->filled('q') || request()->filled('category');

    // Premier article en grand : première page, sans filtre
    $items = $news->getCollection();
    $featured = (! $filtered && $news->currentPage() === 1) ? $items->first() : null;
    if ($featured) {
        $items = $items->slice(1);
    }
@endphp

@section('content')

{{-- ═════════ EN-TÊTE + RECHERCHE ═════════ --}}
<section class="hero hero-sm" @if ($heroBg) style="--img: {{ $heroBg }}" @endif>
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>
    <div class="container position-relative text-center reveal">
        <nav aria-label="Fil d'Ariane" class="mb-3 small">
            <a href="{{ route('home') }}" class="text-white-50">Accueil</a>
            <span class="text-white-50 mx-1">/</span>
            <span>Actualités</span>
        </nav>
        <h1 class="display-4 fw-bold text-white mb-3">Actualités</h1>
        <p class="lead col-lg-7 mx-auto mb-4">Suivez les nouvelles de Kenaya Finances.</p>

        <form action="{{ route('news.index') }}" method="GET" class="col-md-8 col-lg-6 mx-auto" role="search">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="search-bar">
                <i class="bi bi-search"></i>
                <label for="q" class="visually-hidden">Rechercher un article</label>
                <input type="search" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher un article">
                <button class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </div>
    <svg class="hero-wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,90 1440,40 L1440,80 L0,80 Z" fill="#ffffff"/>
    </svg>
</section>

<section class="py-5">
    <div class="container">

        {{-- ═════════ CATÉGORIES ═════════ --}}
        @isset($categories)
            @if ($categories->isNotEmpty())
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-5 reveal" role="navigation" aria-label="Catégories">
                    <a href="{{ route('news.index', request()->only('q')) }}"
                       class="cat-pill {{ request('category') ? '' : 'active' }}">Toutes</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('news.index', array_merge(request()->only('q'), ['category' => $category->slug])) }}"
                           class="cat-pill {{ request('category') === $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif
        @endisset

        @if ($filtered)
            <p class="text-center text-muted mb-4">
                {{ $news->total() }} résultat{{ $news->total() > 1 ? 's' : '' }}
                <a href="{{ route('news.index') }}" class="ms-2"><i class="bi bi-x-circle"></i> Effacer les filtres</a>
            </p>
        @endif

        {{-- ═════════ ARTICLE À LA UNE ═════════ --}}
        @if ($featured)
            <article class="card news-featured news-card border-0 shadow mb-5 reveal">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-6 thumb-wrap">
                        <div class="feat-media {{ $featured->featured_image ? '' : 'empty' }}">
                            @if ($featured->featured_image)
                                <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}">
                            @else
                                <i class="bi bi-newspaper"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body p-4 p-lg-5 d-flex flex-column justify-content-center h-100">
                            <div class="mb-2">
                                <span class="badge bg-bright">À la une</span>
                                @if ($featured->category)
                                    <span class="text-muted small ms-2">{{ $featured->category->name }}</span>
                                @endif
                            </div>
                            <h2 class="h3 fw-bold">{{ $featured->title }}</h2>
                            @if ($featured->published_at)
                                <small class="text-muted mb-3"><i class="bi bi-calendar3 me-1"></i>
                                    <time datetime="{{ $featured->published_at->toDateString() }}">{{ $featured->published_at->translatedFormat('d F Y') }}</time>
                                </small>
                            @endif
                            <p class="text-muted">{{ $featured->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featured->content), 200) }}</p>
                            <a href="{{ route('news.show', $featured->slug) }}" class="stretched-link read-more">Lire l'article <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </article>
        @endif

        {{-- ═════════ GRILLE ═════════ --}}
        <div class="row g-4">
            @forelse ($items as $i => $item)
                <div class="col-md-6 col-lg-4 reveal" style="--d: {{ ($i % 3) * 0.12 }}s">
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
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>
                                    <time datetime="{{ $item->published_at->toDateString() }}">{{ $item->published_at->translatedFormat('d F Y') }}</time>
                                </small>
                            @endif
                            <h2 class="h5 fw-bold mt-1">{{ $item->title }}</h2>
                            <p class="text-muted">{{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}</p>
                            <a href="{{ route('news.show', $item->slug) }}" class="stretched-link read-more">Lire l'article <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </article>
                </div>
            @empty
                @unless ($featured)
                    <div class="col-12 text-center text-muted py-5">
                        <i class="bi bi-newspaper fs-1"></i>
                        <p class="mt-3 mb-0">
                            @if ($filtered)
                                Aucun article ne correspond à votre recherche.
                            @else
                                Aucune actualité publiée pour le moment. Revenez bientôt !
                            @endif
                        </p>
                    </div>
                @endunless
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">{{ $news->withQueryString()->links() }}</div>
    </div>
</section>

@endsection