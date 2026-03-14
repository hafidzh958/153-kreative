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

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('home', [AdminHomeController::class, 'index'])->name('home.index');
    Route::put('home', [AdminHomeController::class, 'update'])->name('home.update');
    
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

    Route::resource('portfolio', AdminPortfolioController::class);
    Route::resource('services', AdminServiceController::class);
    Route::resource('missions', AdminMissionController::class);
    Route::resource('processes', AdminProcessController::class);
    Route::resource('contact', AdminContactController::class)->only(['index', 'destroy']);
    Route::resource('settings', AdminSettingController::class)->only(['index', 'update']);
});