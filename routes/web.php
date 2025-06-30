<?php

use App\Http\Controllers\adopter\adopterController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\favoritController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\registerController;
use Illuminate\Support\Facades\Mail;
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

    Route::get('lupa_kata_sandi', [loginController::class, 'lupaKataSandi'])->name('lupaKataSandi');
    Route::post('lupa_kata_sandi/validasi_email', [loginController::class, 'validasiEmail'])->name('lupaKataSandi.validasiEmail');
    Route::get('lupa_kata_sandi/send-email/{email}/{otp}', [mailController::class, 'sendEmail']);
    Route::post('lupa_kata_sandi/verifikasi_otp', [loginController::class, 'validasiOTP'])->name('lupaKataSandi.validasiOTP');
    Route::post('lupa_kata_sandi/ganti_kata_sandi', [loginController::class, 'gantiKataSandi'])->name('lupaKataSandi.gantiKataSandi');
    
    Route::get('register', [registerController::class, 'showRegisterForm'])->name('register');
    Route::post('register/validasiAdopterTahap1', [registerController::class, 'validasiAdopterTahap1'])->name('register.validasiAdopterTahap1');
    Route::post('register/validasiAdopterTahap2', [registerController::class, 'validasiAdopterTahap2'])->name('register.validasiAdopterTahap2');
    Route::post('register/validasiShelterTahap1', [registerController::class, 'validasiShelterTahap1'])->name('register.validasiShelterTahap1');
    Route::post('register/validasiShelterTahap2', [registerController::class, 'validasiShelterTahap2'])->name('register.validasiShelterTahap2');
    Route::post('registerAdopter', [registerController::class, 'registerAdopter'])->name('registerAdopter');
    Route::post('registerShelter', [registerController::class, 'registerShelter'])->name('registerShelter');
});

Route::post('/logout', [loginController::class, 'logout'])->name('logout');
Route::get('/tentang_kami', [berandaController::class, 'tentangKami'])->name('tentangKami');

Route::prefix('adopter')->group(function () {
    Route::get('beranda', [berandaController::class, 'adopterBeranda'])->name('beranda.adopterBeranda');
    Route::get('daftar_hewan', [adopterController::class, 'daftarHewan'])->name('adopter.daftarHewan');
    Route::get('detail_hewan', [adopterController::class, 'detailHewan'])->name('adopter.detailHewan');
    Route::get('daftar_shelter', [adopterController::class, 'daftarShelter'])->name('adopter.daftarShelter');
    Route::post('favorit', [adopterController::class, 'tambahFavorit'])->name('adopter.tambahFavorit');
    Route::get('daftar_favorit', [adopterController::class, 'daftarFavorit'])->name('adopter.daftarFavorit');
    Route::get('profile', [adopterController::class, 'profile'])->name('adopter.profile');
});

Route::prefix('shelter')->group(function () {
    Route::get('beranda', [berandaController::class, 'shelterBeranda'])->name('beranda.shelterBeranda');
});

Route::prefix('admin')->group(function () {
    Route::get('beranda', [berandaController::class, 'adminBeranda'])->name('beranda.adminBeranda');
});
