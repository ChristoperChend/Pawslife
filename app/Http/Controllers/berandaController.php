<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class berandaController
{
    public function adopterBeranda()
    {
        return view('adopter.beranda');
    }

    public function shelterBeranda()
    {
        return view('shelter.beranda');
    }

    public function adminBeranda()
    {
        return view('admin.beranda');
    }
}
