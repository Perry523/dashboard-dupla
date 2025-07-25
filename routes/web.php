<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PixController;
use App\Http\Controllers\GeneratePixChargeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/welcome', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('GeneratePixCharge', [GeneratePixChargeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('GeneratePixCharge');

Route::get('MyPixes', [GeneratePixChargeController::class, 'browsePixes'])
    ->middleware(['auth', 'verified'])
    ->name('MyPixes');

Route::get('MyPixDetail', [GeneratePixChargeController::class, 'showPixDetail'])
    ->middleware(['auth', 'verified'])
    ->name('MyPixDetail');

Route::get('UsersList', [GeneratePixChargeController::class, 'browseUsers'])
    ->middleware(['auth', 'verified'])
    ->name('UsersList');

Route::middleware(['auth'])->group(function () {
    Route::get('pix/generate', function () {
        return Inertia::render('Pix/Generate');
    })->name('pix.generate');

    Route::get('pix/list', function (Request $request) {
        $pixController = new PixController();
        $apiResponse = $pixController->index($request);
        $data = $apiResponse->getData(true);

        return Inertia::render('Pix/List', [
            'pixList' => $data['data'],
            'filters' => $data['filters'],
            'total' => $data['meta']['total'],
        ]);
    })->name('pix.list');

    Route::post('pix', [PixController::class, 'store'])->name('pix.store');
});

Route::get('pix/{token}', [PixController::class, 'confirm'])->name('pix.confirm');
Route::get('pix/{token}/qrcode', [PixController::class, 'qrcode'])->name('pix.qrcode');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
