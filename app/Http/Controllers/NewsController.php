<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::published()->with('category');

        // Filter by category
        $categorySlug = $request->query('categorie');
        $activeCategory = null;
        if ($categorySlug) {
            $activeCategory = NewsCategory::where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        // Search
        $search = $request->query('recherche');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(9)->appends($request->query());
        $categories = NewsCategory::withCount(['news as published_news_count' => function ($q) {
            $q->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
        }])->having('published_news_count', '>', 0)->get();

        return view('pages.news.index', compact('news', 'categories', 'activeCategory', 'search'));
    }

    public function show(string $slug): View|RedirectResponse
    {
        $article = News::where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('category')
            ->firstOrFail();

        $related = News::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        // return view('pages.news.show', compact('article', 'related'));
        return view('pages.news.show', ['news' => $article, 'related' => $related]);
    }
}
