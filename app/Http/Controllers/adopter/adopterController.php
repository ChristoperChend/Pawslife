<?php

namespace App\Http\Controllers\adopter;

use App\Models\adopter;
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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class adopterController extends Controller
{
    private function checkLogin() {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        return null;
    }

    public function daftarHewan(Request $request) {
        $query = Hewan::with('shelter');

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_hewan', 'LIKE', "%{$searchTerm}%")
                ->orWhere('jenis_hewan', 'LIKE', "%{$searchTerm}%")
                ->orWhere('ras', 'LIKE', "%{$searchTerm}%")
                ->orWhere('jenis_kelamin', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('jenis_hewan')) {
            $jenisHewan = $request->jenis_hewan;
            $query->where('jenis_hewan', $jenisHewan); 
        }

        if ($request->filled('shelter_id')) {
            $shelter_id = $request->shelter_id;
            $query->where('shelter_id', $shelter_id); 
        }

        $listHewan = $query->paginate(12);
        if (Auth::check() && Auth::user()->adopter) {
            $favoritHewanIds = favorit::where('adopter_id', Auth::user()->adopter->id)->pluck('hewan_id')->toArray();
        } else {
            $favoritHewanIds = [];
        }

        return view('adopter.daftarHewan', compact('listHewan', 'favoritHewanIds'));
    }

    public function detailHewan(Request $request) {
        if(!Auth::check()) {
            $adopter_id = 0;
        } else {
            $adopter = adopter::where('pengguna_id', Auth::user()->id)->first();
            $adopter_id = $adopter ? $adopter->id : 0;
        }
        $query = hewan::with('shelter');
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }
        $detailHewan = $query->first();

        if ($detailHewan && $detailHewan->status_steril === 'belum_steril') {
            $detailHewan->status_steril = 'Belum steril';
        } elseif ($detailHewan && $detailHewan->status_steril === 'sudah_steril') {
            $detailHewan->status_steril = 'Sudah steril';
        } 
        
        if ($detailHewan && $detailHewan->status_vaksin === 'belum_vaksin') {
            $detailHewan->status_vaksin = 'Belum vaksin';
        } elseif ($detailHewan && $detailHewan->status_vaksin === 'sudah_vaksin') {
            $detailHewan->status_vaksin = 'Sudah vaksin';
        }
        return view('adopter.detailHewan', compact('detailHewan', 'adopter_id'));
    }

    public function detailPenyerahanHewan(Request $request) {
        $data = formPenyerahanHewan::where('id', $request->id)
        ->where('adopter_id', $request->adopter_id)
        ->first();

        if ($data && $data->status_steril === 'belum_steril') {
            $data->status_steril = 'Belum steril';
        } elseif ($data && $data->status_steril === 'sudah_steril') {
            $data->status_steril = 'Sudah steril';
        } 
        
        if ($data && $data->status_vaksin === 'belum_vaksin') {
            $data->status_vaksin = 'Belum vaksin';
        } elseif ($data && $data->status_vaksin === 'sudah_vaksin') {
            $data->status_vaksin = 'Sudah vaksin';
        }

        return view('adopter.dataPenyerahanHewan', compact('data'));
    }

    private function simplifyAlamat($alamat) {
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

    /**
     * @param string $alamat
     * @return string
     **/
    private function getLokasiFromAlamat($alamat) {
        $alamatSederhana = $this->simplifyAlamat($alamat);

        if (empty($alamatSederhana)) {
            return 'Lokasi tidak ditemukan';
        }

        $cacheKey = 'lokasi_alamat_' . md5($alamatSederhana);

        return cache()->remember($cacheKey, 3600, function () use ($alamatSederhana) {
            $response = Http::withHeaders([
                'User-Agent' => 'PawsLife/1.0 (contact: christoper.chendra15@gmail.com)',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $alamatSederhana,
                'format' => 'json',
                'addressdetails' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data) && isset($data[0]['address'])) {
                    $address = $data[0]['address'];

                    if (isset($address['city_district'])) {
                        return $address['city_district'];
                    } elseif (isset($address['suburb'])) {
                        return $address['suburb'];
                    } elseif (isset($address['city'])) {
                        return $address['city'];
                    } elseif (isset($address['county'])) {
                        return $address['county'];
                    }
                }
                return 'Lokasi tidak ditemukan';
            }

            return 'Gagal memproses alamat';
        });
    }

    public function daftarShelter(Request $request) {
        $query = Shelter::query();

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_shelter', 'LIKE', "%{$searchTerm}%")
                ->orWhere('alamat_shelter', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $listShelter = $query->paginate(12);

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


            $adopter = Auth::user()->adopter;
            $adopter_id = $adopter->id;

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
        $adopter_id = Auth::user()->adopter->id;
        
        $query = favorit::with(['hewan.shelter'])
            ->where('adopter_id', $adopter_id);

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->whereHas('hewan', function ($q) use ($searchTerm) {
                $q->where('nama_hewan', 'LIKE', "%{$searchTerm}%")
                ->orWhere('jenis_hewan', 'LIKE', "%{$searchTerm}%")
                ->orWhere('jenis_kelamin', 'LIKE', "%{$searchTerm}%");
            });
        }
        $listFavorit = $query->paginate(12);
        if (Auth::check() && Auth::user()->adopter) {
            $favoritHewanIds = favorit::where('adopter_id', Auth::user()->adopter->id)->pluck('hewan_id')->toArray();
        } else {
            $favoritHewanIds = [];
        }
        return view('adopter.daftarFavorit', compact('listFavorit', 'favoritHewanIds'));   
    }

    public function profile() {
        $adopter = Auth::user()->adopter;
        return view('adopter.profile', compact('adopter'));
    }

    public function updateProfile(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama_adopter' => 'required|string|max:255',
            'alamat_adopter' => 'required|string',
            'usia_adopter' => 'required|integer|min:1|max:120',
            'nomor_telepon_adopter' => 'required|string|max:15',
            'nomor_wa_adopter' => 'required|string|max:15',
            'pekerjaan_adopter' => 'required|string|max:255',
            'foto_adopter' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = Auth::user();
        $adopter = $user->adopter;

        if (!$adopter || $adopter->id != $id) {
            return response()->json([
                'error' => true,
                'title' => '',
                'message' => 'Silahlan lakukan login sebagai adopter.'
            ]);
        }

        $adopter->nama_lengkap = $request->nama_adopter;
        $adopter->alamat = $request->alamat_adopter;
        $adopter->usia = $request->usia_adopter;
        $adopter->no_handphone = $request->nomor_telepon_adopter;
        $adopter->no_whatsapp = $request->nomor_wa_adopter;
        $adopter->pekerjaan = $request->pekerjaan_adopter;

        $fotoAdopterPath = $request->file('foto')->store('fotoAdopter', 'public');

        if ($request->hasFile('foto_adopter')) {
            File::delete($adopter->foto_adopter);
            $adopter->foto_adopter = $fotoAdopterPath;
        } else {
            return response()->json([
                'error' => true,
                'title' => 'Gagal mengedit profile!',
                'message' => 'Tidak menemukan file foto.'
            ]);
        }
        $adopter->save();

        return response()->json([
            'success' => true,
            'title' => 'Berhasil',
            'message' => 'Berhasil mengubah data adopter.'
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
                ->whereIn('status_pengajuan', ['diajukan'])
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
                'status_pengajuan' => 'diajukan',
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
        $adopter = Auth::user()->adopter;

        $adopter_id = $adopter->id;

        $riwayat = formPengajuanAdopsi::where('adopter_id', $adopter_id)->latest()->paginate(4);

        foreach ($riwayat as $item) {
            $item->selesai_masa_percobaan = $item->updated_at->addDays(7)->isPast();
        }
        
        return view('adopter.riwayatPengajuanAdopsi', compact('riwayat'));
    }

    public function showLepasAdopsi() {
        return view('adopter.lepasAdopsi');
    }

    public function lepasAdopsi(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'namaHewan'=> 'required',
                'jenisHewan' =>'required|in:anjing,kucing',
                'jenisKelaminHewan' =>'required|in:jantan,betina',
                'statusVaksinHewan' =>'required|in:sudahVaksin,belumVaksin',
                'statusSterilHewan' =>'required|in:sudahSteril,belumSteril',
                'beratHewan' =>'required|numeric',
                'rasHewan' =>'required',
                'fotoHewan' =>'required|image|mimes:jpeg,png,jpg|max:2048',
                'catatanMedisHewan'=> 'required',
                'alasanPenyerahanHewan'=> 'required',
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
                'fotoHewan.max' => '*Ukuran foto maksimal 2MB.',
                'catatanMedisHewan.required' => '*Catatan Medis Hewan Harus di Isi',
                'alasanPenyerahanHewan.required' => '*Alasan Penyerahan Hewan Harus di Isi'
            ]);

            if($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $fotoHewanPath = $request->file('fotoHewan')->store('fotoHewanAdopter', 'public');

            if($request->hasFile('fotoHewan')) {
                if(!Auth::check()) {
                    return response()->json([
                        'error' => true,
                        'title' => 'Error',
                        'message' => 'Lakukan login terlebih dahulu sebelum melakukan penyerahan hewan peliharaan',
                    ]);
                } else {
                    $adopter = adopter::where('pengguna_id', Auth::user()->id)->first();
                    $adopter_id = $adopter ? $adopter->id : 0;
                }

                DB::beginTransaction();

                $statusVaksin = $request->statusVaksinHewan === 'sudahVaksin' ? 'sudah_vaksin' : 'belum_vaksin';
                $statusSteril = $request->statusSterilHewan === 'sudahSteril' ? 'sudah_steril' : 'belum_steril';

                $formPenyerahanHewan = formPenyerahanHewan::create([
                    'shelter_id' => null,
                    'adopter_id' => $adopter_id,
                    'nama_hewan' => $request->namaHewan,
                    'ras' => $request->rasHewan,
                    'berat' => $request->beratHewan,
                    'status_steril' => $statusSteril,
                    'status_vaksin' => $statusVaksin,
                    'catatan_medis' => $request->catatanMedisHewan,
                    'foto_hewan' => $fotoHewanPath,
                    'jenis_hewan' => $request->jenisHewan,
                    'alasan_penyerahan' => $request->alasanPenyerahanHewan,
                    'jenis_kelamin' => $request->jenisKelaminHewan,
                    'status_penyerahan' => 'diajukan',
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'title' => 'Error',
                    'message' => 'Foto hewan peliharaan wajib diunggah!'
                ]);
            }

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
        $adopter = Auth::user()->adopter;
        $adopter_id = $adopter->id;

        $riwayat = formPenyerahanHewan::where('adopter_id', $adopter_id)->latest()->paginate(4);
        return view('adopter.riwayatPenyerahanHewan', compact('riwayat'));
    }

    public function detailShelter(Request $request) {
        $detailShelter = shelter::find($request->id);

        $listHewan = hewan::where('shelter_id', $detailShelter->id)->paginate(4);

        if (Auth::check() && Auth::user()->adopter) {
            $favoritHewanIds = favorit::where('adopter_id', Auth::user()->adopter->id)->pluck('hewan_id')->toArray();
        } else {
            $favoritHewanIds = [];
        }
        return view('adopter.detailShelter', compact('detailShelter', 'listHewan', 'favoritHewanIds'));
    }

    public function adopsiHewan(Request $request) {
        DB::beginTransaction();
        try {
            $adopter_id = Auth::user()->id;

            $pengajuan = formPengajuanAdopsi::where('adopter_id', $adopter_id)
                    ->where('hewan_id', $request->hewan_id)
                    ->first();

            if (!$pengajuan) {
                return response()->json([
                    'error' => true,
                    'title' => 'Adopsi Hewan Gagal',
                    'message' => 'Terjadi kesalahan ketika melakukan adopsi.'
                ]);
            }

            $pengajuan->status_pengajuan = 'diadopsi';
            $pengajuan->alasan_persetujuan_pengajuan_adopsi = $request->alasan_adopsi;
            $pengajuan->updated_at = now();
            $pengajuan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'title' => 'Adopsi Hewan Berhasil',
                'message' => 'Hewan telah diadopsi!'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error adopsiHewan: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat adopsi hewan, silahkan coba lagi.'
            ]);
        }
    }

    public function kembalikanHewan(Request $request) {
        DB::beginTransaction();
        try {
            $adopter_id = Auth::user()->id;

            $pengajuan = formPengajuanAdopsi::where('adopter_id', $adopter_id)
                    ->where('hewan_id', $request->hewan_id)
                    ->first();

            if (!$pengajuan) {
                return response()->json([
                    'error' => true,
                    'title' => 'Pengembalian Hewan Gagal',
                    'message' => 'Terjadi kesalahan ketika melakukan pengembalian.'
                ]);
            }

            $pengajuan->status_pengajuan = 'dikembalikan';
            $pengajuan->alasan_penolakan_pengajuan_adopsi = $request->alasan_adopsi;
            $pengajuan->updated_at = now();
            $pengajuan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'title' => 'Pengembalian Hewan Berhasil',
                'message' => 'Hewan telah dikembalikan!'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error kembalikanHewan: '. $e->getMessage());
            return response()->json([
                'error' => true,
                'title' => 'Error',
                'message' => 'Terjadi kesalahan saat mengembalikan hewan, silahkan coba lagi.'
            ]);
        }
    }

    public function persyaratanAdopsi(Request $request) {
        $detailHewan = hewan::with('shelter')
            ->where('id', $request->hewan_id)
            ->first();

        session()->flash('alasan_adopsi', $request->alasan);

        return response()->json([
            'success' => true,
            'redirect_url' => route('adopter.persyaratanAdopsiPage', $detailHewan->id)
        ]);
    }

    public function persyaratanAdopsiPage($id) {
        $detailShelter = hewan::with('shelter')->findOrFail($id);
        $alasan = session('alasan_adopsi');
        if(!Auth::check()) {
            $adopter_id = 0;
        } else {
            $adopter = adopter::where('pengguna_id', Auth::user()->id)->first();
            $adopter_id = $adopter ? $adopter->id : 0;
        }

        return view('adopter.persyaratanAdopsi', compact('detailShelter', 'alasan', 'adopter_id'));
    }
}