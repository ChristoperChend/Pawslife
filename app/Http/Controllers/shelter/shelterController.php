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

        $hewanIds = Hewan::where('shelter_id', $user->id)->pluck('id');
        if ($hewanIds->isNotEmpty()) {
            formPengajuanAdopsi::whereIn('hewan_id', $hewanIds)
                ->where('status_pengajuan', 'setuju')
                ->whereNotNull('tanggal_akhir_percobaan')
                ->whereDate('tanggal_akhir_percobaan', '<', now('Asia/Jakarta'))
                ->update([
                    'status_pengajuan' => 'diadopsi',
                    'updated_at' => now('Asia/Jakarta')
                ]);
        }

        $dataHewan = hewan::where('shelter_id', $user->id)->orderBy('id', 'desc')->take(10)->get();

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
            'namaHewan'=> 'required',
            'jenisHewan' =>'required|in:anjing,kucing',
            'jenisKelaminHewan' =>'required|in:jantan,betina',
            'statusVaksinHewan' =>'required|in:sudahVaksin, belumVaksin',
            'beratHewan' =>'required|numeric',
            'fotoHewan' =>'required|image',
        ],[
            'namaHewan.required' => '*Nama Hewan Harus di Isi',
            'jenisHewan.required' => '*Jenis Hewan Harus di Pilih',
            'jenisKelaminHewan.required' => '*Jenis Kelamin Hewan Harus di Isi',
            'statusVaksinHewan.required' => '*Status Vaksin Hewan Harus di Isi',
            'beratHewan.required' => '*Berat Hewan Harus di Isi',
            'beratHewan.numeric' => '*Berat Hewan Hanya Boleh Berupa Angka',
            'fotoHewan.required' => '*Foto Hewan Harus di Isi',
        ]);

        $data = $request->except('fotoHewan');
        
        if($request->hasFile('fotoHewan')){
            $user = Auth::user();
            $shelter_id = $user->id;

            
            $file = $request->file('fotoHewan');
            $destinationPath = public_path('image/daftarHewan');
            if(!File::exists($destinationPath)){
                File::makeDirectory($destinationPath, 0775, true);
            }
            $fileName = time().'_'.preg_replace('/\s+/','_',$file->getClientOriginalName());
            $file->move($destinationPath, $fileName);
            $data['fotoHewan'] = 'image/daftarHewan/'.$fileName;
            try{
                hewan::create([
                'shelter_id' => $shelter_id,
                'nama_hewan' => $data['namaHewan'],
                'ras' => $data['rasHewan'],
                'berat' => $data['beratHewan'],
                'status_steril' => $data['statusSterilHewan'],
                'status_vaksin' => $data['statusVaksinHewan'],
                'catatan_medis' => $data['catatanMedisHewan'],
                'foto_hewan' => $data['fotoHewan'],
                'jenis_hewan' => $data['jenisHewan'],
                'jenis_kelamin' => $data['jenisKelaminHewan'],
                'status_hewan' => 'siap_di_adopsi'
                ]);
                
                return redirect()->route('beranda.shelterBeranda')->with('success', 'Hewan berhasil ditambahan!');
            }catch (Exception $e) {
            Log::error('Gagal menambahkan hewan: '.$e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan. Coba lagi.'])->withInput();
            }
        }
        return back()->withErrors(['fotoHewan' => 'Foto hewan wajib diunggah.'])->withInput();
    }

    public function getDataHewan(Request $request){
        $user = Auth::user();
        $q = trim($request->query('q', ''));
        $dataHewan = hewan::query()
            ->where('shelter_id', $user->id)
            ->when($q !== '', function($query) use ($q){
                $safe = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $q);
                $query->where('nama_hewan', 'LIKE', "%{$safe}%");
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('shelter.dataHewan', compact('dataHewan', 'q'));
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
            'status_steril'  => 'required|in:sudahSteril,belumSteril',
            'status_vaksin'  => 'required|in:sudahVaksin,belumVaksin',
            'catatan_medis'  => 'required|string|max:500',
            'foto_hewan'     => $hewan->foto_hewan 
                                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                                : 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $validate = $request->validate($rules);

        //Handle photo
        if($request->has('foto_hewan')){
            $destinationPath = public_path('image/daftarHewan');

            if(!empty($request->old_foto_hewan) && File::exists(public_path($request->old_foto_hewan))){
                File::delete(public_path($request->old_foto_hewan));
            }

            $file = $request->file('foto_hewan');
            $fileName = time().'_'.preg_replace('/\s+/','_',$file->getClientOriginalName());
            $file->move($destinationPath, $fileName);

            $validate['foto_hewan'] = 'image/daftarHewan/' . $fileName;
        }else {
            // Simpan foto lama jika tidak ada foto baru
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
        // dd($id);
        $data = formPenyerahanHewan::where('shelter_id', $id['id'])
        ->where('status_penyerahan', '=', 'diajukan')
        ->latest('id')->paginate(5);
        return view('shelter.daftarPengajuanPenyerahanHewan', compact('data'));
    }

    public function getDaftarPengajuanAdopsiHewan(){
        Paginator::useBootstrap();
        $data = formPengajuanAdopsi::orderBy('id', 'desc')
        ->where('status_pengajuan', '=', 'diajukan')
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
        $tanggalAkhir = $tanggalMulai->copy()->addWeek();

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
        $penyerahan->save();

        return response()->json([
            'success' => true,
            'message' => 'Penyerahan adopsi berhasil disetujui'
        ]);
    }

    public function tolakPenyerahanAdopsi($id)
    {
        $hewan = formPenyerahanHewan::find($id);

        if (!$hewan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses data hewan!'
            ], 404);
        }

        $hewan->status_penyerahan = 'tolak';
        $hewan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan penyerahan hewan berhasil ditolak!'
        ]);
    }

    public function getDataPenyerahanHewan($id){
        $data = formPenyerahanHewan::find($id);
        return view('shelter.dataPenyerahanHewan', compact('data'));
    }

    public function getRiwayatPengambilanHewan(){
        Paginator::useBootstrap();
        $id = auth::user();

        $data = formPenyerahanHewan::where('shelter_id', $id['id'])
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
        $id = auth::user();

        $data = formPengajuanAdopsi::where('shelter_id', $id['id'])
        ->where(function ($query) {
            $query->where('status_pengajuan', 'setuju')
                ->orWhere('status_pengajuan', 'tolak')
                ->orWhere('status_pengajuan', 'dikembalikan')
                ->orWhere('status_pengajuan', 'diadopsi');
        })
        ->latest('id')
        ->paginate(5);
        
        return view('shelter.riwayatPengajuanAdopsiHewan', compact('data'));
    }

    public function getProfilShelter(){
        $userId = auth()->id();
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
                                        ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072' // 3MB
                                        : 'required|image|mimes:jpeg,png,jpg,gif|max:3072',
            'dokumen_legal'        => $shelter->dokumen_legal
                                        ? 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120' // 5MB
                                        : 'required|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120',
        ];

        $validated = $request->validate($rules);

        // Handle foto_shelter
        if ($request->hasFile('foto_shelter')) {
            // Delete old photo if exists
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
            // Delete old document if exists
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
}



