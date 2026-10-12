@php $item = $service ?? null; @endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="card border-0 shadow-sm"><div class="card-body">
    <div class="mb-3">
        <label for="name" class="form-label">Nom *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $item->name ?? '') }}"
               class="form-control @error('name') is-invalid @enderror" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description *</label>
        <textarea id="description" name="description" rows="5"
                  class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $item->description ?? '') }}</textarea>
    </div>
   
    <div class="mb-3">
    <label for="image" class="form-label">Image</label>
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
           class="form-control @error('image') is-invalid @enderror">
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @if ($item?->image)
        <img src="{{ asset('storage/'.$item->image) }}" alt="" height="60" class="mt-2 rounded">
    @endif
</div>

<div class="mb-3">
    <label for="sort_order" class="form-label">Ordre d'affichage</label>
    <input type="number" id="sort_order" name="sort_order" min="0"
           value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control">
</div>
    <div class="form-check form-switch">
        {{-- Valeur 0 envoyée quand la case est décochée --}}
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
               @checked(old('is_active', $item->is_active ?? true))>
        <label class="form-check-label" for="is_active">Service actif (visible sur le site)</label>
    </div>
</div></div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>