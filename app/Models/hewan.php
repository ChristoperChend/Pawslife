<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hewan extends Model
{
    protected $table = 'hewan';

    protected $fillable = ['shelter_id', 'nama_hewan', 'ras', 'berat', 'status_steril', 'status_vaksin', 'tanggal_vaksin' ,'tanggal_steril','catatan_medis', 'foto_hewan', 'jenis_hewan', 'jenis_kelamin', 'deskripsi_hewan', 'status_hewan'];

    public function shelter() {
        return $this->belongsTo(shelter::class, 'shelter_id');
    }
}
