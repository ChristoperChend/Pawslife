<?php

use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\adopter\adopterController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\shelter\shelterController;
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
    Route::put('/adopter/profile/{id}', [adopterController::class, 'updateProfile'])->name('adopter.updateProfile');
    Route::post('ajukan_adopsi', [adopterController::class, 'ajukanAdopsi'])->name('adopter.ajukanAdopsi');
    Route::get('riwayat_pengajuan_adopsi', [adopterController::class, 'showRiwayatPengajuanAdopsi'])->name('adopter.showRiwayatPengajuanAdopsi');
    Route::get('lepas_adopsi', [adopterController::class, 'showLepasAdopsi'])->name('adopter.showLepasAdopsi');
    Route::post('lepas_adopsi_post', [adopterController::class, 'lepasAdopsi'])->name('adopter.lepasAdopsi');
    Route::get('riwayat_penyerahan_hewan', [adopterController::class, 'showRiwayatPenyerahanHewan'])->name('adopter.showRiwayatPenyerahanHewan');
    Route::get('detail_penyerahan_hewan', [adopterController::class, 'detailPenyerahanHewan'])->name('adopter.detailPenyerahanHewan');
    Route::get('detail_shelter', [adopterController::class, 'detailShelter'])->name('adopter.detailShelter');
    Route::post('adopsi_hewan', [adopterController::class, 'adopsiHewan'])->name('adopter.adopsiHewan');
    Route::post('kembalikan_hewan', [adopterController::class, 'kembalikanHewan'])->name('adopter.kembalikanHewan');
});

Route::prefix('shelter')->group(function () {
    Route::get('beranda', [shelterController::class, 'shelterBeranda'])->name('beranda.shelterBeranda');
    
    Route::get('tambah-hewan', [shelterController::class, 'halamanTambahHewan'])->name('shelter.tambahHewan');
    Route::post('tambah-hewanPost', [shelterController::class, 'halamanTambahHewanPost'])->name('shelter.tambahHewanPost');
    
    Route::get('data-hewan', [shelterController::class, 'getDataHewan'])->name('shelter.data.hewan');
    Route::get('detail-hewan/{id}', [shelterController::class, 'detailHewan'])->name('shelter.detail.hewan');
    Route::put('perbarui-data-hewan/{id}', [shelterController::class, 'updateDataHewan'])->name('shelter.perbarui.data.hewan');
    Route::delete('hapus-data-hewan/{id}', [shelterController::class, 'hapusDataHewan'])->name('shelter.hapus.data.hewan');
    
    Route::get('daftar-pengajuan-penyerahan-hewan', [shelterController::class, 'getDaftarPengajuanPenyerahanHewan'])->name('shelter.daftar.pengajuan.penyerahan.hewan');
    Route::post('terima-penyerahan-hewan/{id}', [shelterController::class, 'terimaPenyerahanAdopsi'])->name('shelter.terima.penyerahan.hewan');
    // Route::post('tolak-penyerahan-hewan/{id}', [shelterController::class, 'tolakPenyerahanAdopsi'])->name('shelter.tolak.penyerahan.hewan');
    Route::get('data-penyerahan-hewan/{id}', [shelterController::class, 'getDataPenyerahanHewan'])->name('shelter.data.penyerahan.hewan');

    Route::get('daftar-pengajuan-adopsi-hewan', [shelterController::class, 'getDaftarPengajuanAdopsiHewan'])->name('shelter.daftar.pengajuan.adopsi.hewan');
    Route::post('terima-pengajuan-adopsi/{id}', [shelterController::class, 'terimaPengajuanAdopsi'])->name('shelter.terima.pengajuan.adopsi');
    Route::post('tolak-pengajuan-adopsi/{id}', [shelterController::class, 'tolakPengajuanAdopsi'])->name('shelter.tolak.pengajuan.adopsi');

    Route::get('profile-adopter/{id}', [shelterController::class, 'getAdopterProfile'])->name('shelter.adopter.profile');

    Route::get('riwayat-pengambilan-hewan-adopter', [shelterController::class, 'getRiwayatPengambilanHewan'])->name('shelter.riwayat.pengambilan.hewan');
    Route::get('riwayat-pengajuan-adopsi-hewan', [shelterController::class, 'getRiwayatPengajuanAdopsi'])->name('shelter.riwayat.pengajuan.adopsi');

    Route::get('profil-shelter', [shelterController::class, 'getProfilShelter'])->name('shelter.profil');
    Route::put('perbarui-data-shelter/{id}', [shelterController::class, 'updateDataShelter'])->name('shelter.perbarui.data.shelter');

    Route::get('persyaratan-adopsi', [shelterController::class, 'getPersyaratanAdopsi'])->name('shelter.persyaratan.adopsi');
    Route::post('tambah-persyaratan-adopsi', [shelterController::class, 'insertPersyaratanAdopsi'])->name('shelter.tambah.persyaratan.adopsi');
});

Route::prefix('admin')->group(function () {
    Route::get('beranda', [berandaController::class, 'adminBeranda'])->name('beranda.adminBeranda');
    Route::get('detail_shelter', [adminController::class, 'detailShelter'])->name('admin.detailShelter');
    Route::get('profile', [adminController::class, 'profile'])->name('admin.profile');
    Route::get('riwayat_pendaftaran', [adminController::class, 'riwayatPendaftaran'])->name('admin.riwayatPendaftaran');
    Route::post('tolak_shelter', [adminController::class, 'tolakShelter'])->name('admin.tolakShelter');
    Route::post('setuju_shelter', [adminController::class, 'setujuShelter'])->name('admin.setujuShelter');
});
