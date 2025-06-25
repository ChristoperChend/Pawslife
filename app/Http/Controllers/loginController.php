<?php

namespace App\Http\Controllers;

use App\Models\OtpMail;
use App\Models\pengguna;
use App\Models\shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class loginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi harus diisi.',
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($request->has('remember')) {
                $token = Str::random(50);
                $user->remember_token = $token;

                Cookie::queue('remember_token', $token, 60 * 24 * 7);
            }
            if ($user->tipe_pengguna === 'adopter') {
                return redirect()->route('beranda.adopterBeranda');
            } else if ($user->tipe_pengguna === 'shelter') {
                $shelter = shelter::where('pengguna_id', $user->id)->first();
                if ($shelter && $shelter->status === 'waiting for confirmation') {
                    Auth::logout();
                    Alert::warning('Akun shelter Anda menunggu konfirmasi admin.');
                    return back();
                }
                return redirect()->route('beranda.shelterBeranda');
            } else if ($user->tipe_pengguna === 'admin') {
                return redirect()->route('beranda.adminBeranda');
            }
        }

        Alert::error('Email atau kata sandi salah', 'silahkan periksa kembali dan coba lagi.');
        return back();
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget('remember_me'));
        Auth::logout();
        return redirect()->route('login');
    }

    public function lupaKataSandi() {
        return view('auth.lupaKataSandi');
    }

    public function validasiEmail(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $pengguna = pengguna::where('email', $request->email)->first();

        if(!$pengguna) {
            return response()->json([
                'errors' => [
                    'email' => ['Email yang Anda masukkan tidak terdaftar.']
                ]
            ], 422);
        }
        $otp = rand(100000, 999999);
        $pengguna->otp = $otp;
        $pengguna->otp_expired_at = now()->addMinutes(5);
        $pengguna->save();

        $mailCtrl = new mailController();
        $mailCtrl->sendEmail($pengguna->email, $otp);

        return response()->json(['success' => true, 'message' => 'Kode OTP berhasil dikirim ke email anda, silahkan cek di kotak masuk atau di spam']);
    }

    public function validasiOTP(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ],[
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'otp' => 'OTP harus diisi.'
        ]);

        $pengguna = pengguna::where('email', $request->email)
                            ->where('otp', $request->otp)
                            ->where('otp_expired_at', '>=', now())
                            ->first();

        if (!$pengguna) {
            return response()->json(['errors' => [
                'otp' => ['OTP tidak valid atau sudah kedaluwarsa']
            ]], 422);
        }

        return response()->json(['success' => true, 'message' => 'OTP valid']);
    }

    public function gantiKataSandi(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'kata_sandi' => 'required|min:6',
            'konfirmasi_kata_sandi' => 'required|same:kata_sandi'
        ],[
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'otp' => 'OTP harus diisi.',
            'kata_sandi.required' => 'Kata sandi harus diisi.',
            'kata_sandi.min' => 'Kata sandi minimal 6 karakter',
            'konfirmasi_kata_sandi.required' => 'Konfirmasi kata sandi harus diisi.',
            'konfirmasi_kata_sandi.same' => 'Konfirmasi kata sandi tidak cocok',
        ]);

        $pengguna = pengguna::where('email', $request->email)
                            ->where('otp', $request->otp)
                            ->where('otp_expired_at', '>=', now())
                            ->first();

        if (!$pengguna) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau sudah kedaluwarsa']);
        }

        $pengguna->kata_sandi = bcrypt($request->kata_sandi);
        $pengguna->otp = null;
        $pengguna->otp_expired_at = null;
        $pengguna->save();

        if (!$pengguna) {
            return response()->json(['errors' => [
                'otp' => ['OTP tidak valid atau sudah kedaluwarsa']
            ]], 422);
        }

        return response()->json(['success' => true, 'message' => 'Silahkan lakukan login kembali', 'redirect' => route('login')]);
    }
}
