
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PageController, ProjectController, AjaxController, ThemeController};

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/projects', [ProjectController::class, 'page'])->name('projects.page');
Route::get('/contact', [PageController::class, 'contact'])->name('contact.page');

// Public portfolio routes
Route::get('/portfolio/{username}', [PageController::class, 'portfolio'])->name('portfolio.public');
Route::get('/portfolio/{username}/projects', [ProjectController::class, 'publicPage'])->name('portfolio.projects');
Route::get('/portfolio/{username}/contact', [PageController::class, 'publicContact'])->name('portfolio.contact');

Route::prefix('ajax')->group(function () {
  Route::get('/projects', [AjaxController::class, 'projects'])->name('ajax.projects');
  Route::get('/skills',   [AjaxController::class, 'skills'])->name('ajax.skills');
  Route::post('/contact', [AjaxController::class, 'contact'])->name('ajax.contact');
});

// Portfolio sharing routes (require authentication)
Route::middleware('auth')->prefix('portfolio')->group(function () {
    Route::post('/generate-link', [\App\Http\Controllers\PortfolioController::class, 'generateShareLink'])->name('portfolio.generate-link');
    Route::put('/visibility', [\App\Http\Controllers\PortfolioController::class, 'updateVisibility'])->name('portfolio.visibility');
    Route::get('/sharing-info', [\App\Http\Controllers\PortfolioController::class, 'getSharingInfo'])->name('portfolio.sharing-info');
});

// Dynamic theme CSS
Route::get('/theme.css', [ThemeController::class, 'css'])->name('theme.css');
