<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\shelter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class adminController extends Controller
{
    public function detailShelter(Request $request) {
        $detailShelter = shelter::find($request->id);

        return view('admin.detailShelter', compact('detailShelter'));
    }

    public function riwayatPendaftaran() {
        $shelter = shelter::all();

        return view('admin.riwayatPendaftaran', compact('shelter'));
    }

    public function profile() {
        $admin = Auth::user();
        
        return view('admin.profile', compact('admin'));
    }

    public function tolakShelter(Request $request) {
        try {
            $shelter = shelter::find($request->shelter_id);

            if(!$shelter){
                return response()->json([
                    'success' => false,
                    'message' => 'Data shelter tidak ditemukan.'
                ]);
            }

            $shelter->status = 'Ditolak';
            $shelter->save();

            return response()->json([
                'success' => true,
                'title' => 'Akun shelter berhasil ditolak!',
                'message' => 'berikan informasi kepada shelter melalui email bahwa akun ditolak karena data tidak valid.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak akun shelter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function setujuShelter(Request $request) {
        try {
            $shelter = shelter::find($request->shelter_id);

            if(!$shelter){
                return response()->json([
                    'success' => false,
                    'message' => 'Data shelter tidak ditemukan.'
                ]);
            }

            $shelter->status = 'Diterima';
            $shelter->save();

            return response()->json([
                'success' => true,
                'title' => 'Akun shelter berhasil dibuat!',
                'message' => 'berikan informasi kepada shelter melalui email bahwa akun sudah diaktifkan dan bisa diakses.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat setuju akun shelter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
