@extends('layouts.admin')
@section('title', 'Tableau de bord')
@section('heading', 'Tableau de bord')

@section('content')
<div class="row g-3 mb-4">
    @foreach ([
        ['Articles publiés', $stats['published_news'], 'bi-newspaper', 'text-primary'],
        ['Brouillons', $stats['draft_news'], 'bi-pencil-square', 'text-blue'],
        ['Messages non traités', $stats['untreated_messages'] . ' / ' . $stats['total_messages'], 'bi-envelope-exclamation', 'text-navy'],
        ['Services actifs', $stats['active_services'], 'bi-briefcase', 'text-primary'],
    ] as [$label, $value, $icon, $color])
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi {{ $icon }} fs-1 {{ $color }}"></i>
                    <div>
                        <div class="fs-3 fw-bold">{{ $value }}</div>
                        <div class="text-muted small">{{ $label }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <strong>Derniers articles modifiés</strong>
                <a href="{{ route('admin.news.index') }}" class="small">Tout voir</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($recentNews as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.news.edit', $item) }}" class="text-decoration-none">{{ \Illuminate\Support\Str::limit($item->title, 50) }}</a>
                        <span class="badge {{ $item->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->status === 'published' ? 'Publié' : 'Brouillon' }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aucun article.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <strong>Derniers messages</strong>
                <a href="{{ route('admin.contacts.index') }}" class="small">Tout voir</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($recentMessages as $msg)
                    <li class="list-group-item">
                        <a href="{{ route('admin.contacts.show', $msg) }}" class="text-decoration-none fw-semibold">{{ $msg->subject }}</a>
                        <div class="small text-muted">{{ $msg->name }} · {{ $msg->created_at->diffForHumans() }}</div>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aucun message.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection