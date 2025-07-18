<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PixController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/home', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('pix', [PixController::class, 'store'])->name('pix.store');
});

Route::get('pix/{token}', [PixController::class, 'confirm'])->name('pix.confirm');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
