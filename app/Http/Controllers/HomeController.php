<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::active()->get();
        $latestNews = News::published()->with('category')->take(3)->get();

        return view('pages.home', compact('services', 'latestNews'));
    }
}
