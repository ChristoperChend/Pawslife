<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class shelter extends Model
{
    // use Notifiable;
    protected $table = 'shelter';

    protected $casts = [
        'persyaratan_adopsi' => 'array'
    ];
    protected $fillable = ['pengguna_id', 'nama_shelter', 'email_shelter', 'alamat_shelter', 'no_telepon_shelter', 'foto_shelter', 'dokumen_legal', 'masa_percobaan', 'persyaratan_adopsi', 'deskripsi_shelter', 'status', 'nama_bank', 'nomor_rekening'];

    public function pengguna() {
        return $this->belongsTo(pengguna::class);
    }

    public function hewan() {
        return $this->hasMany(hewan::class);
    }    
}
