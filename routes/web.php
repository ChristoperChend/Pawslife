<?php

use App\Http\Controllers\berandaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/', function() {
    return redirect('beranda.adopterBeranda');
});

Route::fallback(function () {
    return redirect()->route('beranda.adopterBeranda');
});

Route::prefix('auth')->group(function () {    
    Route::get('login', [loginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [loginController::class, 'login']);

    Route::get('register', [registerController::class, 'showRegisterForm'])->name('register');
    Route::post('register/validasiAdopterTahap1', [registerController::class, 'validasiAdopterTahap1'])->name('register.validasiAdopterTahap1');
    Route::post('register/validasiAdopterTahap2', [registerController::class, 'validasiAdopterTahap2'])->name('register.validasiAdopterTahap2');
    Route::post('register/validasiShelterTahap1', [registerController::class, 'validasiShelterTahap1'])->name('register.validasiShelterTahap1');
    Route::post('register/validasiShelterTahap2', [registerController::class, 'validasiShelterTahap2'])->name('register.validasiShelterTahap2');
    Route::post('registerAdopter', [registerController::class, 'registerAdopter'])->name('registerAdopter');
    Route::post('registerShelter', [registerController::class, 'registerShelter'])->name('registerShelter');
});

Route::post('/logout', [loginController::class, 'logout'])->name('logout');

Route::prefix('adopter')->group(function () {
    Route::get('beranda', [berandaController::class, 'adopterBeranda'])->name('beranda.adopterBeranda');
});

Route::prefix('shelter')->group(function () {
    Route::get('/beranda', [berandaController::class, 'shelterBeranda'])->name('beranda.shelterBeranda');
});

Route::prefix('admin')->group(function () {
    Route::get('beranda', [berandaController::class, 'adminBeranda'])->name('beranda.adminBeranda');
});
