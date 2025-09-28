<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class shelter extends Model
{
    // use Notifiable;
    protected $table = 'shelter';

    protected $fillable = ['pengguna_id', 'nama_shelter', 'email_shelter', 'alamat_shelter', 'no_telepon_shelter', 'foto_shelter', 'dokumen_legal', 'deskripsi_shelter', 'status'];

    public function pengguna() {
        return $this->belongsTo(pengguna::class);
    }

    public function hewan() {
        return $this->hasMany(hewan::class);
    }
}
