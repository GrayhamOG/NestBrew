<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuApiController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// ── Public routes ──────────────────────────────────────────────

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Menu page (returns blade view)
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Menu items API (returns JSON for JavaScript to load)
Route::get('/menu-items', [MenuApiController::class, 'index']);

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Auth required routes ───────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart',          [CartController::class, 'index']);
    Route::post('/cart',         [CartController::class, 'store']);
    Route::patch('/cart/{id}',   [CartController::class, 'update']);
    Route::delete('/cart/{id}',  [CartController::class, 'destroy']);
    Route::delete('/cart',       [CartController::class, 'clear']);

    // Orders
    Route::post('/orders', [OrderController::class, 'store']);

});

// ── Admin routes ───────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu', MenuItemController::class);
});

require __DIR__.'/auth.php';