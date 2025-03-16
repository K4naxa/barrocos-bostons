<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/login', function () {
    return Inertia::render('Auth.Login');
});


Route::middleware('auth')->group(function () {
    // Hallintasivu
    Route::get('/hallinta', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Lista järjestelmän koirista
    Route::get('/hallinta/koirat', [AdminController::class, 'dogs'])->name('admin.dogs');
    // Uuden koiran luomis sivu
    Route::get('/hallinta/koira/uusi', [DogController::class, 'create'])->name('dog.create');

    Route::get('/hallinta/kuvat/uusi', [MediaController::class, 'create'])->name('media.create');

    Route::get('/hallinta/kuvat', [MediaController::class, 'managementGallery'])->name('admin.managementGallery');
});

Route::prefix('/api')->middleware('auth')->group(function () {
    // Tallenna luotu koira
    Route::post('/dog/store', [DogController::class, 'store'])->name('dog.store');
    Route::post('/media/store', [MediaController::class, 'upload'])->name('media.upload');
    Route::delete('/images/{image}', [MediaController::class, 'destroy'])->name('images.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
