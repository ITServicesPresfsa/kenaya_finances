@php $item = $news ?? null; @endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <div class="mb-3">
                <label for="title" class="form-label">Titre *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $item->title ?? '') }}"
                       class="form-control @error('title') is-invalid @enderror" required>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $item->slug ?? '') }}"
                       class="form-control @error('slug') is-invalid @enderror" placeholder="généré automatiquement si vide">
            </div>
            <div class="mb-3">
                <label for="excerpt" class="form-label">Extrait</label>
                <textarea id="excerpt" name="excerpt" rows="3" maxlength="300"
                          class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $item->excerpt ?? '') }}</textarea>
            </div>
            <div class="mb-0">
                <label class="form-label">Contenu *</label>
                <div id="editor" style="height:320px" class="bg-white"></div>
                <input type="hidden" name="content" id="content" value="{{ old('content', $item->content ?? '') }}">
            </div>
        </div></div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3"><div class="card-body">
            <div class="mb-3">
                <label for="status" class="form-label">Statut *</label>
                <select id="status" name="status" class="form-select">
                    <option value="draft" @selected(old('status', $item->status ?? 'draft') === 'draft')>Brouillon</option>
                    <option value="published" @selected(old('status', $item->status ?? '') === 'published')>Publié</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="published_at" class="form-label">Date de publication</label>
                <input type="datetime-local" id="published_at" name="published_at"
                       value="{{ old('published_at', optional($item->published_at ?? null)->format('Y-m-d\TH:i')) }}"
                       class="form-control @error('published_at') is-invalid @enderror">
            </div>
            <div class="mb-0">
                <label for="category_id" class="form-label">Catégorie</label>
                <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">— Aucune —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $item->category_id ?? '') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="form-text"><a href="{{ route('admin.categories.index') }}" target="_blank">Gérer les catégories</a></div>
            </div>
        </div></div>
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
    <h2 class="h6 fw-bold">Référencement (SEO)</h2>
    <div class="mb-3">
        <label for="meta_title" class="form-label">Titre SEO</label>
        <input type="text" id="meta_title" name="meta_title" maxlength="60"
               value="{{ old('meta_title', $item->meta_title ?? '') }}" class="form-control">
    </div>
    <div>
        <label for="meta_description" class="form-label">Description SEO</label>
        <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                  class="form-control">{{ old('meta_description', $item->meta_description ?? '') }}</textarea>
    </div>
</div></div>
        <div class="card border-0 shadow-sm"><div class="card-body">
            <label for="featured_image" class="form-label">Image de couverture</label>
            @if (!empty($item?->featured_image))
                <img src="{{ asset('storage/' . $item->featured_image) }}" alt="" class="img-fluid rounded mb-2">
            @endif
            <input type="file" id="featured_image" name="featured_image" accept="image/jpeg,image/png,image/webp"
                   class="form-control @error('featured_image') is-invalid @enderror">
            <div class="form-text">JPG, PNG ou WebP. Taille limitée côté serveur.</div>
        </div></div>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: { toolbar: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'],
                       [{ list: 'ordered' }, { list: 'bullet' }], ['link', 'blockquote'], ['clean']] }
        });
        const field = document.getElementById('content');
        if (field.value) quill.clipboard.dangerouslyPasteHTML(field.value);
        field.form.addEventListener('submit', () => {
            field.value = quill.getText().trim() === '' ? '' : quill.root.innerHTML;
        });
    </script>
@endpush