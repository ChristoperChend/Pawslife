<?php

namespace App\Http\Controllers\adopter;

use App\Models\favorit;
use App\Models\hewan;
use App\Models\shelter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class adopterController extends Controller
{
    public function daftarHewan(Request $request) {
        $query = hewan::with('shelter');
        if ($request->has('jenis_hewan')) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }
        $listHewan = $query->paginate(12);
        $favoritHewanIds = favorit::where('adopter_id', Auth::id())->pluck('hewan_id')->toArray();
        return view('adopter.daftarHewan', compact('listHewan', 'favoritHewanIds'));
    }

    public function detailHewan(Request $request) {
        $query = hewan::with('shelter');
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }
        $detailHewan = $query->first();
        return view('adopter.detailHewan', compact('detailHewan'));
    }

    public function daftarShelter() {
        $listShelter = shelter::paginate(12);
        return view('adopter.daftarShelter', compact('listShelter'));
    }

    public function tambahFavorit(Request $request) {
        $request->validate([
            'hewan_id' => 'required|exists:hewan,id',
        ]);

        $adopter_id = Auth::user()->id;

        $favorit = favorit::where('adopter_id', $adopter_id)
                    ->where('hewan_id', $request->hewan_id)
                    ->first();
        
        if ($favorit) {
            $favorit->delete();
            return response()->json(['status' => 'removed']);
        } else {
            favorit::create([
                'adopter_id' => $adopter_id,
                'hewan_id' => $request->hewan_id,
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function daftarFavorit() {
        $listFavorit = favorit::paginate(12);
        $favoritHewanIds = favorit::where('adopter_id', Auth::id())->pluck('hewan_id')->toArray();
        return view('adopter.daftarFavorit', compact('listFavorit', 'favoritHewanIds'));   
    }
}
