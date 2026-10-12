<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\News;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'published_news' => News::where('status', 'published')->count(),
            'draft_news' => News::where('status', 'draft')->count(),
            'total_messages' => ContactMessage::count(),
            'untreated_messages' => ContactMessage::untreated()->count(),
            'active_services' => Service::where('is_active', true)->count(),
        ];

        $recentNews = News::with('category')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        $recentMessages = ContactMessage::orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentNews', 'recentMessages'));
    }
}
