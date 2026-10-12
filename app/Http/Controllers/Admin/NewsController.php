<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::with('category')->orderByDesc('updated_at');

        if ($status = $request->query('statut')) {
            $query->where('status', $status);
        }
        if ($search = $request->query('recherche')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $news = $query->paginate(15)->appends($request->query());

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        $categories = NewsCategory::orderBy('name')->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $validated['slug'] = News::generateSlug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('news', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(News $news): View
    {
        $categories = NewsCategory::orderBy('name')->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $this->validateRequest($request, $news->id);

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('news', 'public');
        }

        if ($validated['status'] === 'published' && ! $news->published_at) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(News $news): RedirectResponse
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Article supprimé.');
    }

    private function validateRequest(Request $request, ?int $excludeId = null): array
    {
        $slug = $request->input('slug') ?: News::generateSlug($request->input('title', ''), $excludeId);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:news_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            // 'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', 'in:published,draft'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'content.required' => 'Le contenu est obligatoire.',
            'featured_image.image' => 'Le fichier doit être une image.',
            'featured_image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ]);

        $validated['slug'] = News::generateSlug($validated['title'], $excludeId);
        if ($request->filled('slug')) {
            $validated['slug'] = $request->input('slug');
        }

        return $validated;
    }
}
