<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class penggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([
            [
                'id' => 1,
                'email' => 'admin@gmail.com',
                'kata_sandi' => hash::make('admin132'),
                'tipe_pengguna' => 'admin',
            ],
            [
                'id' => 2,
                'email' => 'adopter@gmail.com',
                'kata_sandi' => hash::make('adopter132'),
                'tipe_pengguna' => 'adopter',
            ],
            [
                'id' => 3,
                'email' => 'shelter@gmail.com',
                'kata_sandi' => hash::make('shelter132'),
                'tipe_pengguna' => 'shelter',
            ]
        ]);
    }
}
