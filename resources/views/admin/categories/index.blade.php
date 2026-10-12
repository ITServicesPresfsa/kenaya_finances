@extends('layouts.admin')
@section('title', 'Catégories')
@section('heading', 'Catégories d\'actualités')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h6 fw-bold mb-3">Nouvelle catégorie</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" novalidate>
                @csrf
                <label for="name" class="form-label">Nom *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="100"
                       class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <button type="submit" class="btn btn-primary w-100 mt-3">
                    <i class="bi bi-plus-lg me-1"></i>Ajouter
                </button>
            </form>
        </div></div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Nom</th><th>Slug</th><th>Articles</th><th class="text-end">Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="fw-semibold">{{ $category->name }}</td>
                                <td class="text-muted">{{ $category->slug }}</td>
                                <td>{{ $counts[$category->id] ?? 0 }}</td>
                                <td class="text-end text-nowrap">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Renommer"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Supprimer cette catégorie ? Les articles associés resteront sans catégorie.');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Aucune catégorie. Ajoutez-en une à gauche.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection