<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{
    protected $table = 'pengguna';

    protected $fillable = ['email', 'kata_sandi', 'tipe_pengguna'];

    public function adopter() {
        return $this->hasMany(adopter::class);
    }
}
