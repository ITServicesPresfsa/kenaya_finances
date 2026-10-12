@extends('layouts.admin')
@section('title', 'Renommer la catégorie')
@section('heading', 'Renommer la catégorie')

@section('content')
<div class="card border-0 shadow-sm col-lg-6"><div class="card-body">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" novalidate>
        @csrf @method('PUT')
        <label for="name" class="form-label">Nom *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" maxlength="100"
               class="form-control @error('name') is-invalid @enderror" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Le slug (<code>{{ $category->slug }}</code>) ne change pas, pour préserver les liens existants.</div>
        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div></div>
@endsection