
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PageController, ProjectController, AjaxController, ThemeController};

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/projects', [ProjectController::class, 'page'])->name('projects.page');
Route::get('/contact', [PageController::class, 'contact'])->name('contact.page');

Route::prefix('ajax')->group(function () {
  Route::get('/projects', [AjaxController::class, 'projects'])->name('ajax.projects');
  Route::get('/skills',   [AjaxController::class, 'skills'])->name('ajax.skills');
  Route::post('/contact', [AjaxController::class, 'contact'])->name('ajax.contact');
});

// Dynamic theme CSS
Route::get('/theme.css', [ThemeController::class, 'css'])->name('theme.css');
