<?php

namespace App\Http\Controllers\shelter;

use App\Models\formPengajuanAdopsi;
use App\Models\hewan;
use App\Models\shelter;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class shelterController
{
    public function shelterBeranda()
    {   
        $user = Auth::user();
        $dataHewan = hewan::where('shelter_id', $user->id)->orderBy('id', 'desc')->take(10)->get();

        $shelterDatas   = Shelter::where( 'id',$user->id)->first();

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
        return view('shelter.daftarPengajuanPenyerahanHewan');
    }

    public function getDaftarPengajuanAdopsiHewan(){
        Paginator::useBootstrap();
        $data = formPengajuanAdopsi::orderBy('id', 'desc')->paginate(10);
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

        $pengajuan->status_pengajuan = 'setuju';
        $pengajuan->alasan_persetujuan_pengajuan_adopsi = $request->alasan;
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

            $pengajuan->status_pengajuan = 'ditolak';
            $pengajuan->alasan_penolakan_pengajuan_adopsi = $request->alasan;
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
}



