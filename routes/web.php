<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\MissionController as AdminMissionController;
use App\Http\Controllers\Admin\ProcessController as AdminProcessController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;

Route::get('/', fn () => view('user.intro'));
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
use App\Models\AboutSetting;
use App\Models\Mission;
use App\Models\Process;

Route::get('/about', function () {
    $about = AboutSetting::firstOrNew(['id' => 1]);
    $missions = Mission::orderBy('order')->get();
    $processes = Process::orderBy('order')->get();
    return view('user.about', compact('about', 'missions', 'processes'));
})->name('about');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.home.index');
    })->name('dashboard.redirect');

    Route::get('home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home.index');
    Route::put('home', [\App\Http\Controllers\Admin\HomeController::class, 'update'])->name('home.update');
    
    // Home Services CRUD
    Route::post('home/services', [AdminHomeController::class, 'storeService'])->name('home.services.store');
    Route::put('home/services/{id}', [AdminHomeController::class, 'updateService'])->name('home.services.update');
    Route::delete('home/services/{id}', [AdminHomeController::class, 'deleteService'])->name('home.services.destroy');
    Route::post('home/services/reorder', [AdminHomeController::class, 'reorderService'])->name('home.services.reorder');

    // Home Projects CRUD
    Route::post('home/projects', [AdminHomeController::class, 'storeProject'])->name('home.projects.store');
    Route::put('home/projects/{id}', [AdminHomeController::class, 'updateProject'])->name('home.projects.update');
    Route::delete('home/projects/{id}', [AdminHomeController::class, 'deleteProject'])->name('home.projects.destroy');
    Route::post('home/projects/reorder', [AdminHomeController::class, 'reorderProject'])->name('home.projects.reorder');

    // About Page Management
    Route::get('about', [AdminAboutController::class, 'index'])->name('about.index');
    Route::put('about', [AdminAboutController::class, 'update'])->name('about.update');

    // Portfolio Categories
    Route::get('portfolio/categories', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'index'])->name('portfolio.categories.index');
    Route::post('portfolio/categories', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'store'])->name('portfolio.categories.store');
    Route::put('portfolio/categories/{id}', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'update'])->name('portfolio.categories.update');
    Route::delete('portfolio/categories/{id}', [\App\Http\Controllers\Admin\PortfolioCategoryController::class, 'destroy'])->name('portfolio.categories.destroy');

    // Portfolio
    Route::get('portfolio', [AdminPortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('portfolio', [AdminPortfolioController::class, 'store'])->name('portfolio.store');
    Route::post('portfolio/reorder', [AdminPortfolioController::class, 'reorder'])->name('portfolio.reorder');
    Route::put('portfolio/settings', [AdminPortfolioController::class, 'updateSettings'])->name('portfolio.settings.update');
    Route::put('portfolio/{id}', [AdminPortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('portfolio/{id}', [AdminPortfolioController::class, 'destroy'])->name('portfolio.destroy');
    // Services Management
    Route::get('services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::post('services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::post('services/reorder', [AdminServiceController::class, 'reorder'])->name('services.reorder');
    Route::put('services/settings', [AdminServiceController::class, 'updateSettings'])->name('services.settings.update');
    Route::put('services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    // Service Features CRUD
    Route::post('services/{service}/features', [AdminServiceController::class, 'storeFeature'])->name('services.features.store');
    Route::put('services/features/{feature}', [AdminServiceController::class, 'updateFeature'])->name('services.features.update');
    Route::delete('services/features/{feature}', [AdminServiceController::class, 'destroyFeature'])->name('services.features.destroy');

    Route::resource('missions', AdminMissionController::class);
    Route::resource('processes', AdminProcessController::class);
    // Contact Page Management
    Route::get('contact', [AdminContactController::class, 'index'])->name('contact.index');
    Route::put('contact', [AdminContactController::class, 'update'])->name('contact.update');
    Route::resource('settings', AdminSettingController::class)->only(['index', 'update']);
});