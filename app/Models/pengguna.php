<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $fillable = ['email', 'kata_sandi', 'tipe_pengguna'];
    protected $hidden = ['kata_sandi', 'remember_token'];

    public function adopter() {
        return $this->hasOne(adopter::class, 'pengguna_id', 'id');
    }

    public function shelter() {
        return $this->hasOne(shelter::class, 'pengguna_id', 'id');
    }

    public function getAuthPassword() {
        return $this->kata_sandi;
    }
}
