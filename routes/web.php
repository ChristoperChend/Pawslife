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

Route::get('auth/login', [loginController::class, 'showLoginForm'])->name('login');
Route::post('auth/login', [loginController::class, 'login']);

Route::get('auth/register', [registerController::class, 'showRegisterForm'])->name('register');
Route::post('auth/register/validasiAdopterTahap1', [registerController::class, 'validasiAdopterTahap1'])->name('register.validasiAdopterTahap1');
Route::post('auth/register/validasiAdopterTahap2', [registerController::class, 'validasiAdopterTahap2'])->name('register.validasiAdopterTahap2');
Route::post('auth/register/validasiShelterTahap1', [registerController::class, 'validasiShelterTahap1'])->name('register.validasiShelterTahap1');
Route::post('auth/register/validasiShelterTahap2', [registerController::class, 'validasiShelterTahap2'])->name('register.validasiShelterTahap2');
Route::post('auth/registerAdopter', [registerController::class, 'registerAdopter'])->name('registerAdopter');
Route::post('auth/registerShelter', [registerController::class, 'registerShelter'])->name('registerShelter');

Route::post('/logout', [loginController::class, 'logout'])->name('logout');

// Beranda Routes
Route::get('adopter/beranda', [berandaController::class, 'adopterBeranda'])->name('beranda.adopterBeranda');
Route::get('shelter/beranda', [berandaController::class, 'shelterBeranda'])->name('beranda.shelterBeranda');
Route::get('admin/beranda', [berandaController::class, 'adminBeranda'])->name('beranda.adminBeranda');