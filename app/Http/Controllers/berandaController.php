<?php

namespace App\Http\Controllers;

use App\Models\favorit;
use App\Models\hewan;
use App\Models\shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class berandaController
{
    public function adopterBeranda() {
        $user = Auth::user();
        $listHewan = hewan::with('shelter')->inRandomOrder()->limit(8)->get();
        $favoritHewanIds = favorit::where('adopter_id', Auth::id())->pluck('hewan_id')->toArray();
        return view('adopter.beranda', compact('user', 'listHewan', 'favoritHewanIds'));
    }

    public function shelterBeranda() {
        return view('shelter.beranda');
    }

    public function adminBeranda() {
        return view('admin.beranda');
    }

    public function tentangKami() {
        return view('layout.tentangKami');
    }
}
