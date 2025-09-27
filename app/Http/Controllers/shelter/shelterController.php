<?php

namespace App\Http\Controllers\shelter;

use App\Models\hewan;
use App\Models\shelter;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class shelterController
{
     public function shelterBeranda()
    {   
        $user = Auth::user();
        $dataHewan = hewan::where('shelter_id', $user->id)->get();
        // dump($dataHewan);

        $shelterDatas   = Shelter::where( 'id',$user->id)->first();
        // dd($shelterDatas);
        // if you’re using the default guard:
        // $currentShelter = Auth::user();
        // OR, if you set up a custom 'shelter' guard in config/auth.php:
        // $currentShelter = Auth::guard('shelter')->user();

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
}

