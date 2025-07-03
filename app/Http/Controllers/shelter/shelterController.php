<?php

namespace App\Http\Controllers;

use App\Models\shelter;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class shelterController
{
     public function shelterBeranda()
    {
        $shelterDatas   = Shelter::all();
        // if you’re using the default guard:
        // $currentShelter = Auth::user();
        // OR, if you set up a custom 'shelter' guard in config/auth.php:
        // $currentShelter = Auth::guard('shelter')->user();

        return view('shelter.beranda', [
            'shelterDatas'   => $shelterDatas,
            // 'currentShelter' => $currentShelter,
        ]);
    }
}
