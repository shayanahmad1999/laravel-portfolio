<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController, SkillController, ProjectController, CategoryController, AboutController, SiteSettingsController, TestimonialController, TimelineEntryController, ContactMessageController};

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Skills management
    Route::resource('skills', SkillController::class);

    // Projects management
    Route::resource('projects', ProjectController::class);

    // Categories management
    Route::resource('categories', CategoryController::class);

    // Testimonials management
    Route::resource('testimonials', TestimonialController::class);

    // Timeline management
    Route::resource('timeline', TimelineEntryController::class);

    // Contact messages
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

    // About page management
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::post('about', [AboutController::class, 'update'])->name('about.update');

    // Site settings management
    Route::get('settings', [SiteSettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SiteSettingsController::class, 'update'])->name('settings.update');
});
