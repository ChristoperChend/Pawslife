<?php

namespace App\Http\Controllers\adopter;

use App\Models\favorit;
use App\Models\formPengajuanAdopsi;
use App\Models\formPenyerahanHewan;
use App\Models\hewan;
use App\Models\shelter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
        if ($request->filled('shelter_id')) {
            $query->where('shelter_id', $request->shelter_id);
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

    private function simplifyAlamat($alamat) {
        // Ambil hanya Kecamatan & Kota
        if (preg_match('/Kecamatan\s([^,]*)|Kec\.?\s?([^,]*)/i', $alamat, $matches)) {
            $kecamatan = $matches[1] ?: $matches[2];
        } else {
            $kecamatan = '';
        }

        if (preg_match('/Kota\s([^,]*)|Kabupaten\s([^,]*)/i', $alamat, $matches)) {
            $kota = $matches[1] ?: $matches[2];
        } else {
            $kota = '';
        }

        return trim($kecamatan . ' ' . $kota);
    }

    private function getLokasiFromAlamat($alamat) {
        $alamatSederhana = $this->simplifyAlamat($alamat);

        if (empty($alamatSederhana)) {
            return 'Lokasi tidak ditemukan';
        }

        $response = Http::withHeaders([
            'User-Agent' => 'PawsLife/1.0 (contact: christoper.chendra15@gmail.com)',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $alamatSederhana,
            'format' => 'json',
            'addressdetails' => 1,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $address = $data[0]['address'] ?? [];

            // Prioritaskan city_district atau suburb jika ada
            if (isset($address['city_district'])) {
                return $address['city_district'];  // Biasanya "Jakarta Selatan", "Jakarta Barat"
            } elseif (isset($address['suburb'])) {
                return $address['suburb'];  // Alternatif
            } elseif (isset($address['city'])) {
                return $address['city'];
            } elseif (isset($address['county'])) {
                return $address['county'];
            } else {
                return 'Lokasi tidak ditemukan';
            }
        }

        return 'Gagal memproses alamat';
    }

    public function daftarShelter(Request $request) {
        $search = $request->input('search');

        $listShelter = shelter::when($search, function ($query, $search) {
            $query->where('nama_shelter', 'like', '%' . $search . '%');
        })->paginate(12);

        foreach ($listShelter as $shelter) {
            $shelter->lokasi = $this->getLokasiFromAlamat($shelter->alamat_shelter);
        }
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

            $sudahAda = formPengajuanAdopsi::where('adopter_id', $request->adopter_id)
                ->where('hewan_id', $request->hewan_id)
                ->whereIn('status_pengajuan', ['Diajukan ke shelter'])
                ->exists();
            
            if ($sudahAda) {
                return response()->json([
                    'error' => true,
                    'title' => 'Pengajuan Ganda',
                    'message' => 'Kamu sudah melakukan pengajuan adopsi terhadap hewan ini.'
                ]);
            }

            DB::beginTransaction();

            formPengajuanAdopsi::create([
                'adopter_id' => $request->adopter_id,
                'hewan_id' => $request->hewan_id,
                'shelter_id' => $request->shelter_id,
                'status_pengajuan' => 'Diajukan ke shelter',
                'alasan' => $request->alasan
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

    public function showRiwayatPengajuanAdopsi() {
        $adopter_id = Auth::user()->id;

        $riwayat = formPengajuanAdopsi::where('adopter_id', $adopter_id)->latest()->paginate(4);

        foreach ($riwayat as $item) {
            $item->selesai_masa_percobaan = $item->updated_at < now()->subDays(7);
        }
        
        return view('adopter.riwayatPengajuanAdopsi', compact('riwayat'));
    }

    public function showLepasAdopsi() {
        return view('adopter.lepasAdopsi');
    }

    public function lepasAdopsi(Request $request) {
        try {
            $request->validate([
                'namaHewan'=> 'required',
                'jenisHewan' =>'required|in:anjing,kucing',
                'jenisKelaminHewan' =>'required|in:jantan,betina',
                'statusVaksinHewan' =>'required|in:sudahVaksin,belumVaksin',
                'statusSterilHewan' =>'required|in:sudahSteril,belumSteril',
                'beratHewan' =>'required|numeric',
                'rasHewan' =>'required',
                'fotoHewan' =>'required|image|mimes:jpeg,png,jpg|max:2048',
            ],[
                'namaHewan.required' => '*Nama Hewan Harus di Isi',
                'jenisHewan.required' => '*Jenis Hewan Harus di Pilih',
                'jenisKelaminHewan.required' => '*Jenis Kelamin Hewan Harus di Isi',
                'statusVaksinHewan.required' => '*Status Vaksin Hewan Harus di Isi',
                'statusSterilHewan.required' => '*Status Steril Hewan Harus di Isi',
                'beratHewan.required' => '*Berat Hewan Harus di Isi',
                'beratHewan.numeric' => '*Berat Hewan Hanya Boleh Berupa Angka',
                'rasHewan.required' => '*Ras Hewan Harus di Isi',
                'fotoHewan.required' => '*Foto harus diisi.',
                'fotoHewan.image' => '*Foto harus berformat JPG, JPEG, atau PNG.',
                'fotoHewan.mimes' => '*Foto harus berformat JPG, JPEG, atau PNG.',
                'fotoHewan.max' => '*Ukuran foto maksimal 2MB.'
            ]);

            $fotoPath = $request->file('fotoHewan')->store('foto_hewan_adopter', 'public');

            if(!Auth::check()) {
                return response()->json([
                    'error' => true,
                    'title' => 'Error',
                    'message' => 'Lakukan login terlebih dahulu sebelum melakukan penyerahan hewan peliharaan',
                ]);
            } else {
                $adopter_id = Auth::user()->id;
            }

            DB::beginTransaction();

            $statusVaksin = $request->statusVaksinHewan === 'sudahVaksin' ? 'Sudah Vaksin' : 'Belum Vaksin';
            $statusSteril = $request->statusSterilHewan === 'sudahSteril' ? 'Sudah Steril' : 'Belum Steril';

            $formPenyerahanHewan = formPenyerahanHewan::create([
                'shelter_id' => null,
                'adopter_id' => $adopter_id,
                'nama_hewan' => $request->namaHewan,
                'ras' => $request->rasHewan,
                'berat' => $request->beratHewan,
                'status_steril' => $statusSteril,
                'status_vaksin' => $statusVaksin,
                'catatan_medis' => $request->catatanMedisHewan ?: '-',
                'foto_hewan' => $fotoPath,
                'jenis_hewan' => $request->jenisHewan,
                'alasan_penyerahan' => $request->alasanPenyerahanHewan ?: '-',
                'jenis_kelamin' => $request->jenisKelaminHewan,
                'status_penyerahan' => 'Mencari shelter',
            ]);

            DB::commit();

            if (!$formPenyerahanHewan) {
                return response()->json([
                    'error' => true,
                    'title' => 'Error',
                    'message' => 'Terjadi kesalahan ketika penyerahan hewan peliharaan!'
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Penyerahan hewan peliharaan berhasil dilakukan!',
                'message' => 'Silahkan lihat di Riwayat Penyerahan Hewan untuk perkembangan yang lebih lanjut'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error LepasAdopsi: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat penyerahan hewan peliharaan, silahkan coba lagi.'
            ]);
        }
    }

    public function showRiwayatPenyerahanHewan() {
        $adopter_id = Auth::user()->id;

        $riwayat = formPenyerahanHewan::where('adopter_id', $adopter_id)->latest()->paginate(4);
        return view('adopter.riwayatPenyerahanHewan', compact('riwayat'));
    }

    public function detailShelter(Request $request) {
        $detailShelter = shelter::find($request->id);

        $listHewan = hewan::where('shelter_id', $detailShelter->id)->paginate(4);

        $favoritHewanIds = favorit::where('adopter_id', Auth::id())->pluck('hewan_id')->toArray();
        return view('adopter.detailShelter', compact('detailShelter', 'listHewan', 'favoritHewanIds'));
    }
}
