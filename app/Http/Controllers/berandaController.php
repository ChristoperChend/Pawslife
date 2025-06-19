<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class berandaController
{
    public function adopterBeranda() {
        $user = Auth::user();
        return view('adopter.beranda', compact('user'));
    }

    public function shelterBeranda() {
        return view('shelter.beranda');
    }

    public function adminBeranda() {
        return view('admin.beranda');
    }
}
