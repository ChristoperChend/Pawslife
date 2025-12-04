<?php

namespace App\Http\Controllers;

use App\Models\adopter;
use App\Models\pengguna;
use App\Models\shelter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class registerController
{
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function validasiAdopterTahap1(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'required',
                'email' => 'required|email|unique:pengguna,email',
                'password' => 'required|min:6',
                'confirmation_password' => 'required|same:password'
            ], [
                'nama_lengkap.required' => 'Nama lengkap harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Kata sandi harus diisi.',
                'password.min' => 'Kata sandi minimal 6 karakter',
                'confirmation_password.required' => 'Konfirmasi kata sandi harus diisi.',
                'confirmation_password.same' => 'Konfirmasi kata sandi tidak cocok',
            ]);

            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error validasiAdopterTahap1: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Kesalahan teknis',
                'message' => 'Terjadi kesalahan saat validasi tahap pertama, silahkan coba lagi.'
            ]);
        }
    }

    public function validasiAdopterTahap2(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'alamat' => 'required',
                'usia' => 'required|max:100',
                'pekerjaan' => 'required',
                'no_handphone' => 'required|numeric',
                'no_whatsapp' => 'required|numeric',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'alamat.required' => 'Alamat harus diisi.',
                'usia.required' => 'Usia harus diisi.',
                'usia.max' => 'Usia melebihi 100 tahun',
                'pekerjaan' => 'Pekerjaan harus diisi.',
                'no_handphone.required' => 'No handphone harus diisi.',
                'no_handphone.numeric' => 'No handphone tidak valid.',
                'no_whatsapp.required' => 'No whatsapp harus diisi.',
                'no_whatsapp.numeric' => 'No whatsapp tidak valid.',
                'foto.required' => 'Foto harus diisi.',
                'foto.image' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto.max' => 'Ukuran foto maksimal 2MB.'
            ]);

            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error validasiAdopterTahap2: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Kesalahan teknis',
                'message' => 'Terjadi kesalahan saat validasi tahap kedua, silahkan coba lagi.'
            ]);
        }
    }

    public function registerAdopter(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'required',
                'email' => 'required|email|unique:pengguna,email',
                'password' => 'required|min:6',
                'alamat' => 'required',
                'usia' => 'required|numeric|max:100',
                'pekerjaan' => 'required',
                'no_handphone' => 'required|numeric',
                'no_whatsapp' => 'required|numeric',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ], [
                'nama_lengkap.required' => 'Nama lengkap harus diisi.',
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Kata sandi harus diisi.',
                'password.min' => 'Kata sandi minimal 6 karakter',
                'alamat.required' => 'Alamat harus diisi.',
                'usia.required' => 'Usia harus diisi.',
                'usia.numeric' => 'Usia harus berupa angka.',
                'usia.max' => 'Usia melebihi 100 tahun',
                'pekerjaan.required' => 'Pekerjaan harus diisi.',
                'no_handphone.required' => 'Npo handphone harus diisi.',
                'no_handphone.numeric' => 'No handphone tidak valid.',
                'no_whatsapp.required' => 'No whatsapp harus diisi.',
                'no_whatsapp.numeric' => 'No whatsapp tidak valid.',
                'foto.required' => 'Foto harus diisi.',
                'foto.image' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto.max' => 'Ukuran foto maksimal 2MB.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors(),
                    'message' => 'Validasi gagal.'
                ]);
            }

            $fotoPath = $request->file('foto')->store('fotoAdopter', 'public');

            if($request->hasFile('foto')) {
                DB::beginTransaction();
            
                $pengguna = pengguna::create([
                    'email' => $request->email,
                    'kata_sandi' => Hash::make($request->password),
                    'tipe_pengguna' => 'adopter'
                ]);
    
                $adopter = adopter::create([
                    'pengguna_id' => $pengguna->id,
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'usia' => $request->usia,
                    'pekerjaan' => $request->pekerjaan,
                    'no_handphone' => $request->no_handphone,
                    'no_whatsapp' => $request->no_whatsapp,
                    'foto_adopter' => $fotoPath,
                    'status' => ''
                ]);
                if (!$adopter) {
                    return response()->json([
                        'error' => true,
                        'title' => 'Gagal membuat akun',
                        'message' => 'Terjadi kesalahan ketika melakukan registrasi'
                    ]);
                }
            } else {
                return response()->json([
                        'error' => true,
                        'title' => 'Gagal membuat akun',
                        'message' => 'Tidak menemukan file foto'
                    ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'title' => 'Akun kamu sudah selesai dibuat!',
                'message' => 'Silahkan melakukan login dengan akun yang dibuat',
                'redirect' => route('login')
            ]);
        } catch(Exception $e) {
            DB::rollBack();
            Log::error('Error registerAdopter: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Kesalahan teknis',
                'message' => 'Terjadi kesalahan saat registrasi adopter. Silakan coba lagi.'
            ]);
        }
    }

    public function validasiShelterTahap1(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'nama_shelter' => 'required',
                'email_shelter' => 'required|email|unique:pengguna,email',
                'alamat_shelter' => 'required',
                'no_telepon_shelter' => 'required|numeric'
            ], [
                'nama_shelter.required' => 'Nama shelter harus diisi.',
                'email_shelter.required' => 'Email shelter harus diisi.',
                'email_shelter.email' => 'Format email tidak valid.',
                'email_shelter.unique' => 'Email shelter sudah terdaftar.',
                'alamat_shelter.required' => 'Alamat shelter harus diisi.',
                'no_telepon_shelter.required' => 'No telepon harus diisi.',
                'no_telepon_shelter.numeric' => 'No telepon tidak valid.',
            ]);

            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }
            return response()->json(['success' => true]);   
        } catch (Exception $e) {
            Log::error('Error validasiShelterTahap1: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Kesalahan teknis',
                'message' => 'Terjadi kesalahan saat validasi tahap pertama. Silakan coba lagi.'
            ]);
        }
    }

    public function validasiShelterTahap2(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'foto_shelter' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'dokumen_legal' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'nama_bank' => 'required',
                'nomor_rekening' => 'required',
                'deskripsi_shelter' => 'required',
                'password_shelter' => 'required|min:6',
                'confirmation_password_shelter' => 'required|same:password_shelter',
            ], [
                'foto_shelter.required' => 'Foto harus diisi.',
                'foto_shelter.image' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto_shelter.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto_shelter.max' => 'Ukuran foto maksimal 2MB.',
                'dokumen_legal.required' => 'Dokumen harus diisi.',
                'dokumen_legal.image' => 'Dokumen harus berformat JPG, JPEG, atau PNG.',
                'dokumen_legal.mimes' => 'Dokumen harus berformat JPG, JPEG, atau PNG.',
                'dokumen_legal.max' => 'Ukuran dokumen maksimal 2MB.',
                'nama_bank.required' => 'Nama bank harus dipilih.',
                'nomor_rekening.required' => 'Nomor rekening harus diisi.',
                'deskripsi_shelter.required' => 'Deskripsi harus diisi.',
                'password_shelter.required' => 'Kata sandi harus diisi.',
                'password_shelter.min' => 'Kata sandi minimal 6 karakter',
                'confirmation_password_shelter.required' => 'Konfirmasi kata sandi harus diisi.',
                'confirmation_password_shelter.same' => 'Konfirmasi kata sandi tidak cocok',
            ]);

            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error validasiShelterTahap2: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Kesalahan teknis',
                'message' => 'Terjadi kesalahan saat validasi tahap kedua. Silakan coba lagi.'
            ]);
        }
    }

    public function registerShelter(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'nama_shelter' => 'required',
                'email_shelter' => 'required|email|unique:pengguna,email',
                'alamat_shelter' => 'required',
                'no_telepon_shelter' => 'required|numeric',
                'foto_shelter' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'dokumen_legal' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'deskripsi_shelter' => 'required',
                'password_shelter' => 'required|min:6',
            ], [
                'nama_shelter.required' => 'Nama shelter harus diisi.',
                'email_shelter.required' => 'Email shelter harus diisi.',
                'email_shelter.email' => 'Format email tidak valid.',
                'email_shelter.unique' => 'Email shelter sudah terdaftar.',
                'alamat_shelter.required' => 'Alamat shelter harus diisi.',
                'no_telepon_shelter.required' => 'No telepon harus diisi.',
                'no_telepon_shelter.numeric' => 'No telepon tidak valid.',
                'foto_shelter.required' => 'Foto harus diisi.',
                'foto_shelter.image' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto_shelter.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'foto_shelter.max' => 'Ukuran foto maksimal 2MB.',
                'dokumen_legal.required' => 'Dokumen harus diisi.',
                'dokumen_legal.image' => 'Dokumen harus berformat JPG, JPEG, atau PNG.',
                'dokumen_legal.mimes' => 'Dokumen harus berformat JPG, JPEG, atau PNG.',
                'dokumen_legal.max' => 'Ukuran dokumen maksimal 2MB.',
                'deskripsi_shelter' => 'Deskripsi harus diisi.',
                'password_shelter.required' => 'Kata sandi harus diisi.',
                'password_shelter.min' => 'Kata sandi minimal 6 karakter',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'errors' => $validator->errors(),
                    'message' => 'Validasi gagal.'
                ]);
            }

            $fotoShelterPath = $request->file('foto_shelter')->store('fotoShelter', 'public');
            $fotoDokumenLegalPath = $request->file('dokumen_legal')->store('fotoDokumenLegal', 'public');

            if($request->hasFile('foto_shelter') && $request->hasFile('dokumen_legal')) {
                DB::beginTransaction();
    
                $pengguna = pengguna::create([
                    'email' => $request->email_shelter,
                    'kata_sandi' => Hash::make($request->password_shelter),
                    'tipe_pengguna' => 'shelter'
                ]);

                $shelter = shelter::create([
                    'pengguna_id' => $pengguna->id,
                    'nama_shelter' => $request->nama_shelter,
                    'alamat_shelter' => $request->alamat_shelter,
                    'no_telepon_shelter' => $request->no_telepon_shelter,
                    'foto_shelter' => $fotoShelterPath,
                    'dokumen_legal' => $fotoDokumenLegalPath,
                    'deskripsi_shelter' => $request->deskripsi_shelter,
                    'status' => 'diajukan'
                ]);

                if (!$shelter) {
                    return response()->json([
                        'error' => true,
                        'title' => 'Gagal membuat akun',
                        'message' => 'Terjadi kesalahan ketika melakukan registrasi'
                    ]);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'title' => 'Gagal membuat akun',
                    'message' => 'Tidak menemukan file foto atau dokumen legal'
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'title' => 'Data shelter kamu telah berhasil diterima oleh kami!',
                'message' => 'Kami akan menginformasikan perkembangan akun kalian melalui email',
                'redirect' => route('login')
            ]);
        } catch(Exception $e) {
            DB::rollBack();
            Log::error('Error registerShelter: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'
            ]);
        }
    }

}
