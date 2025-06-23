<?php

namespace App\Http\Controllers;

use App\Models\hewan;
use Illuminate\Http\Request;

class adopterController
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
}
