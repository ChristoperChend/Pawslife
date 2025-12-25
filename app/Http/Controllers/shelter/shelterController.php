<?php

namespace App\Http\Controllers\shelter;

use App\Models\adopter;
use App\Models\formPengajuanAdopsi;
use App\Models\formPenyerahanHewan;
use App\Models\hewan;
use App\Models\shelter;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class shelterController
{
    public function shelterBeranda()
    {   
        $user = Auth::user();

        $hewanIds = Hewan::where('shelter_id', $user->shelter->id)->pluck('id');
        
        if ($hewanIds->isNotEmpty()) {
            $expiredAdoptionsQuery = formPengajuanAdopsi::whereIn('hewan_id', $hewanIds)
                ->where('status_pengajuan', 'setuju')
                ->whereNotNull('tanggal_akhir_percobaan')
                ->whereDate('tanggal_akhir_percobaan', '<', now('Asia/Jakarta'));

            $affectedHewanIds = $expiredAdoptionsQuery->pluck('hewan_id');

            if ($affectedHewanIds->isNotEmpty()) {
                $expiredAdoptionsQuery->update([
                    'status_pengajuan' => 'diadopsi',
                    'updated_at' => now('Asia/Jakarta')
                ]);

                Hewan::whereIn('id', $affectedHewanIds)->update([
                    'status_hewan' => 'di_adopsi',
                    'updated_at' => now('Asia/Jakarta')
                ]);
            }
        }

        $dataHewan = Hewan::where('shelter_id', $user->shelter->id)
        ->where('status_hewan', '!=', 'di_adopsi')
        ->orderBy('id', 'desc')
        ->take(10)
        ->get();

        $shelterDatas   = Shelter::where( 'pengguna_id',$user->id)->first();

        return view('shelter.beranda', [
            'shelterDatas'   => $shelterDatas,
            'dataHewan' => $dataHewan
        ]);
    }

    public function halamanTambahHewan(){

        return view('shelter.tambahHewan');
    }

    public function halamanTambahHewanPost(Request $request){
        $request->validate([
            'namaHewan'           => 'required',
            'jenisHewan'          => 'required|in:anjing,kucing',
            'jenisKelaminHewan'   => 'required|in:jantan,betina',
            'statusVaksinHewan'   => 'required|in:sudah_vaksin,belum_vaksin', 
            'statusSterilHewan'   => 'required|in:sudah_steril,belum_steril',
            
            'tanggalVaksinHewan'  => 'required_if:statusVaksinHewan,sudah_vaksin|nullable|date',
            'tanggalSterilHewan'  => 'required_if:statusSterilHewan,sudah_steril|nullable|date',
            
            'beratHewan'          => 'required|numeric',
            'deskripsiHewan'      => 'required|string|max:500',
            'catatanMedisHewan'   => 'required|string|max:500',
            'fotoHewan'           => 'required|image|max:3072', 
            'rasHewan'            => 'required'
        ],[
            'namaHewan.required'             => '*Nama Hewan Harus di Isi',
            'jenisHewan.required'            => '*Jenis Hewan Harus di Pilih',
            'jenisKelaminHewan.required'     => '*Jenis Kelamin Hewan Harus di Isi',
            'statusVaksinHewan.required'     => '*Status Vaksin Hewan Harus di Isi',
            'statusSterilHewan.required'     => '*Status Steril Hewan Harus di Isi',
            'tanggalSterilHewan.required_if' => '*Tanggal Steril Harus di Isi jika sudah steril',
            'tanggalVaksinHewan.required_if' => '*Tanggal Vaksin Harus di Isi jika sudah vaksin',
            'beratHewan.required'            => '*Berat Hewan Harus di Isi',
            'beratHewan.numeric'             => '*Berat Hewan Hanya Boleh Berupa Angka',
            'deskripsiHewan.required'        => '*Deskripsi Hewan Harus di Isi',
            'catatanMedisHewan.required'     => '*Catatan Medis Hewan Harus di Isi',
            'fotoHewan.required'             => '*Foto Hewan Harus di Isi',
            'rasHewan.required'              => '*Ras Hewan Harus di Isi'
        ]);

        $tanggalVaksin = ($request->statusVaksinHewan === 'sudah_vaksin') ? $request->tanggalVaksinHewan : null;
        $tanggalSteril = ($request->statusSterilHewan === 'sudah_steril') ? $request->tanggalSterilHewan : null;
        

        if($request->hasFile('fotoHewan')){
            try{
                $user = Auth::user();

                if(!$user->shelter) {
                    return back()->withErrors(['general' => 'Akun tidak terhubung ke shelter.'])->withInput();
                }
                $shelter_id = $user->shelter->id;

                $file = $request->file('fotoHewan');
                $fileName = time().'_'.preg_replace('/\s+/','_',$file->getClientOriginalName());
                $path = $file->storeAs('foto_hewan_shelter', $fileName, 'public');
                $fotoPath = 'foto_hewan_shelter/'.$fileName;

                hewan::create([
                    'shelter_id'      => $shelter_id,
                    'nama_hewan'      => $request->namaHewan,
                    'ras'             => $request->rasHewan,
                    'berat'           => $request->beratHewan,
                    'status_steril'   => $request->statusSterilHewan,
                    'status_vaksin'   => $request->statusVaksinHewan,
                    'tanggal_vaksin'  => $tanggalVaksin, 
                    'tanggal_steril'  => $tanggalSteril,
                    'catatan_medis'   => $request->catatanMedisHewan,
                    'deskripsi_hewan' => $request->deskripsiHewan, 
                    'foto_hewan'      => $fotoPath,
                    'jenis_hewan'     => $request->jenisHewan,
                    'jenis_kelamin'   => $request->jenisKelaminHewan,
                    'status_hewan'    => 'siap_di_adopsi'
                ]);
                
                return redirect()->route('beranda.shelterBeranda')->with('success', 'Hewan berhasil ditambahkan!');

            } catch (Exception $e) {
                Log::error('Gagal menambahkan hewan: '.$e->getMessage());
                if(isset($path)) Storage::disk('public')->delete($path);
                
                return back()->withErrors(['general' => 'Terjadi kesalahan sistem. Coba lagi.'])->withInput();
            }
        }
        
        return back()->withErrors(['fotoHewan' => 'Foto hewan wajib diunggah.'])->withInput();
    }

    public function getDataHewan(Request $request)
    {
        Paginator::useBootstrap();

        $user = Auth::user();

        $qRaw = trim($request->query('q', ''));

        $q = mb_strtolower($qRaw, 'UTF-8');

        $dataHewan = Hewan::query()
            ->where('shelter_id', $user->shelter->id)
            ->where('status_hewan', '!=', 'di_adopsi')
            ->when($q !== '', function ($query) use ($q) {
                $safe = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $q);

                $query->where(function ($sub) use ($safe) {
                    $sub->whereRaw('LOWER(nama_hewan) LIKE ?', ["%{$safe}%"])
                        ->orWhereRaw('LOWER(jenis_hewan) LIKE ?', ["%{$safe}%"])
                        ->orWhereRaw('LOWER(ras) LIKE ?', ["%{$safe}%"])
                        ->orWhereRaw('LOWER(jenis_kelamin) LIKE ?', ["%{$safe}%"]);
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('shelter.dataHewan', [
            'dataHewan' => $dataHewan,
            'q'         => $qRaw,
        ]);
    }


    public function detailHewan($id){
        $hewan = hewan::findOrFail($id);
        return view('shelter.detailHewan', compact('hewan'));
    }

    public function updateDataHewan(Request $request, $id){
        $hewan = hewan::findOrFail($id);
        $rules = [
            'nama_hewan'     => 'required|string|max:255',
            'jenis_hewan'    => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:jantan,betina',
            'berat'          => 'required|numeric|min:0.1',
            'ras'            => 'required|string|max:255',
            'status_steril'  => 'required|in:sudah_steril,belum_steril',
            'tanggal_steril' => 'required_if:status_steril, sudah_steril|nullable|date',
            'status_vaksin'  => 'required|in:sudah_vaksin,belum_vaksin',
            'tanggal_vaksin' => 'required_if:status_vaksin, sudah_vaksin|nullable|date',
            'deskripsi_hewan' => 'required|string|max:500',
            'catatan_medis'  => 'required|string|max:500',
            'foto_hewan'     => $hewan->foto_hewan 
                                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                                : 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $validate = $request->validate($rules);

        if($request->status_vaksin == 'belum_vaksin'){
            $validate['tanggal_vaksin'] = null;
        }

        if($request->status_steril == 'belum_steril'){
            $validate['tanggal_steril'] = null;
        }

        //Handle photo
        if($request->has('foto_hewan')){

            if(!empty($request->old_foto_hewan) && Storage::disk('public')->exists($request->old_foto_hewan)){
                Storage::disk('public')->delete($request->old_foto_hewan);
            }

            $file = $request->file('foto_hewan');
            $fileName = time().'_'.preg_replace('/\s+/','_',$file->getClientOriginalName());
            $path = $file->storeAs('foto_hewan_shelter', $fileName, 'public');

            $validate['foto_hewan'] = $path;
        }else {
            $validate['foto_hewan'] = $request->old_foto_hewan;
        }

        $hewan->update($validate);

        return redirect()->back()->with('success', 'Data hewan berhasil diperbarui!');
    }

    public function hapusDataHewan($id){
        $hewan = hewan::findOrFail($id);
        if ($hewan->foto_hewan && File::exists(public_path($hewan->foto_hewan))) {
            File::delete(public_path($hewan->foto_hewan));
        }
        $hewan->delete();

        return redirect()->route('shelter.data.hewan')->with('success', 'Berhasil menghapus data hewan!');
    }

    public function getDaftarPengajuanPenyerahanHewan(){
        Paginator::useBootstrap();
        $id = auth::user();
        $data = formPenyerahanHewan::where('shelter_id', '=', NULL)
        ->where('status_penyerahan', '=', 'diajukan')
        ->latest('id')->paginate(5);
        return view('shelter.daftarPengajuanPenyerahanHewan', compact('data'));
    }

    public function getDaftarPengajuanAdopsiHewan(){
        Paginator::useBootstrap();
        $user = auth::user();
        $data = formPengajuanAdopsi::orderBy('id', 'desc')
        ->where('status_pengajuan', '=', 'diajukan')
        ->where('shelter_id', '=', $user->shelter->id)
        ->paginate(5);
        return view('shelter.daftarPengajuanAdopsiHewan', compact('data'));
    }

    public function terimaPengajuanAdopsi(Request $request, $id){
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $pengajuan = formPengajuanAdopsi::find($id);

        if(!$pengajuan){
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan tidak ditemukan.'
            ], 404);
        }
        
        $tanggalMulai = Carbon::now('Asia/Jakarta');
        $shelterDatas = Auth::user()->shelter;
        $masaPercobaan = (int) $shelterDatas->masa_percobaan;
        $tanggalAkhir = $tanggalMulai->copy()->addDays($masaPercobaan);

        $pengajuan->status_pengajuan = 'setuju';
        $pengajuan->alasan_persetujuan_pengajuan_adopsi = $request->alasan;
        $pengajuan->updated_at = now();
        $pengajuan->tanggal_mulai_percobaan = $tanggalMulai->toDateString();
        $pengajuan->tanggal_akhir_percobaan = $tanggalAkhir->toDateString();
        $pengajuan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan adopsi berhasil disetujui'
        ]);
    }

    public function tolakPengajuanAdopsi(Request $request, $id){
        try{
            $request->validate([
                'alasan' => 'required|string|max:500'
            ]);

            $pengajuan = formPengajuanAdopsi::find($id);

            if(!$pengajuan){
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengajuan tidak ditemukan.'
                ], 404);
            }


            $pengajuan->status_pengajuan = 'tolak';
            $pengajuan->alasan_penolakan_pengajuan_adopsi = $request->alasan;
            $pengajuan->updated_at = now();
            $pengajuan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan adopsi berhasil ditolak'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses data.',
                'error' => $e->getMessage(),
            ], 500);
        }
      
    }

    public function batalkanMasaPercobaan(Request $request, $id){
        try {
            $request->validate([
                'alasan' => 'required|string|max:500'
            ]);
            $pengajuan = formPengajuanAdopsi::findOrFail($id);

            if(!$pengajuan){
                return response()->json([
                    'success' => false,
                    'message' => 'Data pengajuan tidak ditemukan.'
                ], 404);
            }

            $pengajuan->status_pengajuan = 'dibatalkan';
            $pengajuan->alasan_penolakan_pengajuan_adopsi = $request->alasan;
            $pengajuan->updated_at = now();
            $pengajuan->save();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan adopsi berhasil ditolak'
            ]);
        } catch (\Throwable $th) {
            log::error('Error ketika membatalkan masa percobaan: '.$th->getMessage());
             return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses data.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function getAdopterProfile($id){
        $data = adopter::with('pengguna')->findOrFail($id);

        return view('shelter.adopterProfile', compact('data'));
    }

    public function terimaPenyerahanAdopsi($id){
        $penyerahan = formPenyerahanHewan::find($id);

        if(!$penyerahan){
            return response()->json([
                'success' => false,
                'message' => 'Data penyerahan hewan tidak ditemukan.'
            ], 404);
        }

        $penyerahan->status_penyerahan = 'setuju';
        $penyerahan->shelter_id = auth::user()->shelter->id;
        $penyerahan->save();

        $oldPath = public_path($penyerahan->foto_hewan);

        // Folder tujuan
        $destinationPath = public_path('image/daftarHewan');
        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0775, true);
        }

        // Default: pakai path lama kalau file tidak ditemukan
        $fotoHewan = $penyerahan->foto_hewan;

        // Kalau file fisiknya ada, copy ke folder baru dengan nama unik
        if (File::exists($oldPath)) {
            $originalName = basename($oldPath);
            $fileName     = time() . '_' . preg_replace('/\s+/', '_', $originalName);

            File::copy($oldPath, $destinationPath . '/' . $fileName);

            $fotoHewan = 'image/daftarHewan/' . $fileName;
        }
        try{
            hewan::create([
            'shelter_id' => auth::user()->shelter->id,
            'nama_hewan' => $penyerahan->nama_hewan,
            'ras' => $penyerahan->ras,
            'berat' => $penyerahan->berat,
            'status_steril' => $penyerahan->status_steril,
            'tanggal_vaksin' => $penyerahan->tanggal_vaksin,
            'status_vaksin' => $penyerahan->status_vaksin,
            'tanggal_steril' => $penyerahan->tanggal_steril,
            'catatan_medis' => $penyerahan->catatan_medis,
            'foto_hewan' => $fotoHewan,
            'jenis_hewan' => $penyerahan->jenis_hewan,
            'jenis_kelamin' => $penyerahan->jenis_kelamin,
            'deskripsi_hewan' => $penyerahan->deskripsi_hewan,
            'status_hewan' => 'siap_di_adopsi'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Penyerahan adopsi berhasil disetujui'
            ]);
        }catch (Exception $e) {
            Log::error('Gagal menambahkan hewan: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Penyerahan adopsi gagal disetujui'
            ]);
        }
    }

    public function getDataPenyerahanHewan($id){
        $data = formPenyerahanHewan::find($id);
        return view('shelter.dataPenyerahanHewan', compact('data'));
    }

    public function getRiwayatPengambilanHewan(){
        Paginator::useBootstrap();
        $id = auth::user();

        $data = formPenyerahanHewan::where('shelter_id', $id->shelter->id)
        ->where(function ($query) {
            $query->where('status_penyerahan', 'setuju')
                ->orWhere('status_penyerahan', 'tolak');
        })
        ->latest('id')
        ->paginate(5);
        
        return view('shelter.riwayatPengambilanHewan', compact('data'));
    }
    public function getRiwayatPengajuanAdopsi(){
        Paginator::useBootstrap();
        $id = auth::user()->shelter;

        $data = formPengajuanAdopsi::where('shelter_id', $id['id'])
        ->where(function ($query) {
            $query->where('status_pengajuan', 'setuju')
                ->orWhere('status_pengajuan', 'tolak')
                ->orWhere('status_pengajuan', 'dikembalikan')
                ->orWhere('status_pengajuan', 'dibatalkan')
                ->orWhere('status_pengajuan', 'diadopsi');
        })
        ->latest('id')
        ->paginate(5);
        
        return view('shelter.riwayatPengajuanAdopsiHewan', compact('data'));
    }

    public function getProfilShelter(){
        $userId = auth::user()->shelter->id;
        $data = shelter::where('id', $userId)->first();
        return view('shelter.profilShelter', compact('data'));
    }

    public function updateDataShelter(Request $request, $id)
    {
        $shelter = shelter::findOrFail($id);

        $rules = [
            'nama_shelter'         => 'required|string|max:255',
            'alamat_shelter'       => 'required|string|max:255',
            'no_telepon_shelter'   => 'required|numeric',
            'deskripsi_shelter'    => 'required|string|max:1000', 
            'foto_shelter'         => $shelter->foto_shelter
                                        ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072'
                                        : 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
            'dokumen_legal'        => $shelter->dokumen_legal
                                        ? 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120'
                                        : 'required|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120',
            'nama_bank'            => 'required|string|max:255',
            'nomor_rekening'       => 'required|numeric'
        ];

        $validated = $request->validate($rules);

        // Handle foto_shelter
        if ($request->hasFile('foto_shelter')) {
            if ($shelter->foto_shelter) {
                Storage::disk('public')->delete($shelter->foto_shelter);
            }

            $fileName = time() . '_' . preg_replace('/\s+/', '_', $request->file('foto_shelter')->getClientOriginalName());
            $path = $request->file('foto_shelter')->storeAs('foto_shelter', $fileName, 'public');
            $validated['foto_shelter'] = $path;
        } else {
            $validated['foto_shelter'] = $shelter->foto_shelter;
        }

        // Handle dokumen_legal
        if ($request->hasFile('dokumen_legal')) {
            if ($shelter->dokumen_legal) {
                Storage::disk('public')->delete($shelter->dokumen_legal);
            }

            $fileName = time() . '_' . preg_replace('/\s+/', '_', $request->file('dokumen_legal')->getClientOriginalName());
            $path = $request->file('dokumen_legal')->storeAs('dokumen_legal', $fileName, 'public');
            $validated['dokumen_legal'] = $path;
        } else {
            $validated['dokumen_legal'] = $shelter->dokumen_legal;
        }

        $shelter->update($validated);

        return redirect()->back()->with('success', 'Data shelter berhasil diperbarui!');
    }

    public function getPersyaratanAdopsi(){
        $data = Auth::user();
        $shelterDatas = $data->shelter;
        return view('shelter.persyaratanAdopsi', compact('shelterDatas'));
    }

    public function insertPersyaratanAdopsi(Request $request){
        $request->validate([
            'requirements' => 'required|array|max:25',
            'requirements.*' => 'required|string|max:500',
            'has_trial' => 'required|in:0,1',
            'trial_duration' => 'nullable|required_if:has_trial,1|integer|min:14'
        ],[
            'requirements.required' => 'Persyaratan tidak boleh kosong.',
            'requirements.min' => 'Minimal harus ada 1 persyaratan.',
            'requirements.max' => 'Maksimal 25 persyaratan.',
            'requirements.*.required' => 'Isi persyaratan tidak boleh kosong.',
            'trial_duration.min'          => 'Durasi masa percobaan minimal 14 hari.',
            'trial_duration.integer'      => 'Durasi harus berupa angka.',
        ]);

        try {
            $data = Auth::user();
            $shelterDatas = $data->shelter;

            $cleanRequirements = array_values(array_filter($request->requirements));

            $cleanRequirements = array_map('ucfirst', $cleanRequirements);

            $shelterDatas->persyaratan_adopsi = $cleanRequirements;

            if($request->has_trial == 1){
                $shelterDatas->masa_percobaan = $request->trial_duration;
            }else {
                $shelterDatas->masa_percobaan = null;
            }

            $shelterDatas->save();

            return back()->with('success', 'Persyaratan adopsi berhasil diperbarui');

        } catch (\Throwable $th) {
            log::error('Error ketika memperbarui persyaratan adopsi: ' .$th->getMessage());
            return back()->with('error', 'Persyaratan adopsi gagal diperbarui');
        }
    }
}



