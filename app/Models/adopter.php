<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class adopter extends Model
{
    protected $table = 'adopter';

    protected $fillable = ['pengguna_id', 'nama_lengkap', 'alamat', 'usia', 'pekerjaan', 'no_handphone', 'no_whatsapp', 'foto_adopter', 'status'];

    public function pengguna() {
        return $this->belongsTo(pengguna::class);
    }
}
