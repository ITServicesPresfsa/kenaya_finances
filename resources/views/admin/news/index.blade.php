@extends('layouts.admin')
@section('title', 'Actualités')
@section('heading', 'Actualités')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nouvel article</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Titre</th><th>Catégorie</th><th>Statut</th><th>Publication</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse ($news as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->title }}</td>
                        <td>{{ $item->category->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->status === 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td>{{ $item->published_at?->translatedFormat('d/m/Y H:i') ?? '—' }}</td>
                        <td class="text-end text-nowrap">
                            @if ($item->status === 'published')
                                <a href="{{ route('news.show', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Voir"><i class="bi bi-eye"></i></a>
                            @endif
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer définitivement cet article ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Aucun article pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($news instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="mt-3">{{ $news->links() }}</div>
@endif
@endsection