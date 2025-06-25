<?php

namespace App\Http\Controllers;

use App\Models\shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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
}
