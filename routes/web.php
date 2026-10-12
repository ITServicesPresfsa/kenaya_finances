<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ServiceController;

use App\Http\Middleware\AdminAuth;
use App\Models\News;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
// ─── Routes publiques ─────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/actualites', [NewsController::class, 'index'])->name('news.index');
Route::get('/actualites/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
// Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');


// ─── Sitemap & robots ──────────────────────────────────────────────────────────
Route::get('/sitemap.xml', function () {
    $news = News::published()->get();
    $services = Service::active()->get();

    return response()->view('sitemap', compact('news', 'services'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\nDisallow: /admin/\nSitemap: ".url('/sitemap.xml'),
        200
    )->header('Content-Type', 'text/plain');
})->name('robots');

// ─── Administration ───────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (non protégées)
    Route::get('/connexion', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('/deconnexion', [Admin\AuthController::class, 'logout'])->name('logout');

    // Routes protégées par AdminAuth
      // Routes protégées par AdminAuth
    Route::middleware(AdminAuth::class)->group(function () {

        // Tableau de bord
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Articles
        Route::get('articles', [Admin\NewsController::class, 'index'])->name('news.index');
        Route::get('articles/creer', [Admin\NewsController::class, 'create'])->name('news.create');
        Route::post('articles', [Admin\NewsController::class, 'store'])->name('news.store');
        Route::get('articles/{news}/modifier', [Admin\NewsController::class, 'edit'])->name('news.edit');
        Route::put('articles/{news}', [Admin\NewsController::class, 'update'])->name('news.update');
        Route::delete('articles/{news}', [Admin\NewsController::class, 'destroy'])->name('news.destroy');

        // Catégories d'actualités
        Route::get('categories', [Admin\NewsCategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [Admin\NewsCategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/modifier', [Admin\NewsCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [Admin\NewsCategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [Admin\NewsCategoryController::class, 'destroy'])->name('categories.destroy');

        // Services
        Route::get('services', [Admin\ServiceController::class, 'index'])->name('services.index');
        Route::get('services/creer', [Admin\ServiceController::class, 'create'])->name('services.create');
        Route::post('services', [Admin\ServiceController::class, 'store'])->name('services.store');
        Route::get('services/{service}/modifier', [Admin\ServiceController::class, 'edit'])->name('services.edit');
        Route::put('services/{service}', [Admin\ServiceController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [Admin\ServiceController::class, 'destroy'])->name('services.destroy');

        // Messages de contact
        Route::get('messages', [Admin\ContactController::class, 'index'])->name('contacts.index');
        Route::get('messages/{contact}', [Admin\ContactController::class, 'show'])->name('contacts.show');
        Route::patch('messages/{contact}/traiter', [Admin\ContactController::class, 'markTreated'])->name('contacts.treat');
        Route::delete('messages/{contact}', [Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

        // Paramètres
        Route::get('parametres', [Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('parametres', [Admin\SettingsController::class, 'update'])->name('settings.update');
    });
});

