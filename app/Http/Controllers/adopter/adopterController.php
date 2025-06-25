<?php

namespace App\Http\Controllers\adopter;

use App\Models\hewan;
use App\Models\shelter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class adopterController extends Controller
{
    public function daftarHewan(Request $request) {
        $query = hewan::with('shelter');
        if ($request->has('jenis_hewan')) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }
        $listHewan = $query->paginate(12);
        return view('adopter.daftarHewan', compact('listHewan'));
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
}
