<?php

namespace App\Http\Controllers;

use App\Models\hewan;
use App\Models\shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class berandaController
{
    public function adopterBeranda() {
        $user = Auth::user();
        $listHewan = hewan::with('shelter')->inRandomOrder()->limit(8)->get();
        return view('adopter.beranda', compact('user', 'listHewan'));
    }

    public function shelterBeranda() {
        return view('shelter.beranda');
    }

    public function adminBeranda() {
        return view('admin.beranda');
    }
}
