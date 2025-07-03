<?php

namespace App\Http\Controllers\adopter;

use App\Models\favorit;
use App\Models\formPengajuanAdopsi;
use App\Models\hewan;
use App\Models\shelter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class adopterController extends Controller
{
    public function daftarHewan(Request $request) {
        $query = hewan::with('shelter');
        if ($request->filled('jenis_hewan')) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        $listHewan = $query->paginate(12);
        $favoritHewanIds = favorit::where('adopter_id', Auth::id())->pluck('hewan_id')->toArray();
        return view('adopter.daftarHewan', compact('listHewan', 'favoritHewanIds'));
    }

    public function detailHewan(Request $request) {
        if(!Auth::check()) {
            $adopter_id = 0;
        } else {
            $adopter_id = Auth::user()->id;
        }
        $query = hewan::with('shelter');
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }
        $detailHewan = $query->first();
        return view('adopter.detailHewan', compact('detailHewan', 'adopter_id'));
    }

    public function daftarShelter() {
        $listShelter = shelter::paginate(12);
        return view('adopter.daftarShelter', compact('listShelter'));
    }

    public function tambahFavorit(Request $request) {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'error' => true,
                    'title' => '',
                    'message' => 'Lakukan login sebagai adopter untuk menambahkan hewan ke favorit'
                ]);
            }

            $request->validate([
                'hewan_id' => 'required|exists:hewan,id',
            ]);

            $adopter_id = Auth::user()->id;

            $favorit = favorit::where('adopter_id', $adopter_id)
                        ->where('hewan_id', $request->hewan_id)
                        ->first();
            
            if ($favorit) {
                $favorit->delete();
                return response()->json([
                    'status' => 'removed',
                    'title' => '',
                    'message' => 'Hewan berhasil dihapus dari favorit'
                ]);
            } else {
                favorit::create([
                    'adopter_id' => $adopter_id,
                    'hewan_id' => $request->hewan_id,
                ]);
                return response()->json([
                    'status' => 'added',
                    'title' => '',
                    'message' => 'Hewan berhasil ditambah ke favorit'
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error tambahFavorit: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat penambahan favorit, silahkan coba lagi.'
            ]);
        }
    }

    public function daftarFavorit(Request $request) {
        $adopter_id = Auth::id();

        $query = favorit::with(['hewan.shelter'])
            ->where('adopter_id', $adopter_id);

        // Filter berdasarkan dropdown jika ada
        if ($request->filled('jenis_hewan')) {
            $query->whereHas('hewan', function($q) use ($request) {
                $q->where('jenis_hewan', $request->jenis_hewan);
            });
        }
        if ($request->filled('jenis_kelamin')) {
            $query->whereHas('hewan', function($q) use ($request) {
                $q->where('jenis_kelamin', $request->jenis_kelamin);
            });
        }

        $listFavorit = $query->paginate(12);
        $favoritHewanIds = favorit::where('adopter_id', Auth::id())->pluck('hewan_id')->toArray();
        return view('adopter.daftarFavorit', compact('listFavorit', 'favoritHewanIds'));   
    }

    public function profile() {
        $adopter = Auth::user();
        return view('adopter.profile', compact('adopter'));
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();
        $adopter = $user->adopter;
        $field = $request->field;
        $value = $request->value;
        if (in_array($field, ['nama_lengkap', 'alamat', 'usia', 'no_handphone', 'no_whatsapp', 'pekerjaan'])) {
            $adopter->$field = $value;
            $adopter->save();
            return response()->json([
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Berhasil mengubah data'
            ]);
        }
        return response()->json([
            'error' => true, 
            'title' => 'Gagal',
            'message' => 'Gagal mengubah data'
        ]);
    }

    public function ajukanAdopsi(Request $request) {
        try {
            if ($request->adopter_id == 0) {
                return response()->json([
                    'error' => true,
                    'title' => '',
                    'message' => 'Silahlan lakukan login sebagai adopter untuk melanjutkan proses pengajuan adopsi.'
                ]);
            }

            DB::beginTransaction();

            formPengajuanAdopsi::create([
                'adopter_id' => $request->adopter_id,
                'hewan_id' => $request->hewan_id,
                'shelter_id' => $request->shelter_id,
                'status_pengajuan' => 'Masa Percobaan',
                'alasan' => ''
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'title' => 'Pengajuan adopsi berhasil dilakukan!',
                'message' => 'Silahkan lihat di Riwayat Pengajuan Adopsi untuk perkembangan yang lebih lanjut.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error ajukanAdopsi: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat pengajuan adopsi, silahkan coba lagi.'
            ]);
        }
    }
}
