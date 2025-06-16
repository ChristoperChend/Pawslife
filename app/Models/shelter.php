<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shelter extends Model
{
    protected $table = 'shelter';

    protected $fillable = ['pengguna_id', 'nama_shelter', 'email_shelter', 'alamat_shelter', 'no_telepon_shelter', 'foto_shelter', 'dokumen_legal', 'deskripsi_shelter', 'status'];

    public function pengguna() {
        return $this->belongsTo(pengguna::class);
    }
}
