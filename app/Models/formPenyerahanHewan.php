<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formPenyerahanHewan extends Model
{
    protected $table = 'form_penyerahan_hewan';

    protected $fillable = ['shelter_id', 'adopter_id', 'nama_hewan', 'ras', 'berat', 'status_steril', 'status_vaksin', 'tanggal_steril', 'tanggal_vaksin', 'catatan_medis', 'foto_hewan', 'jenis_hewan', 'alasan_penyerahan', 'jenis_kelamin', 'deskripsi_hewan', 'status_penyerahan'];

    public function shelter() {
        return $this->belongsTo(shelter::class);
    }

    public function adopter() {
        return $this->belongsTo(shelter::class);
    }
}
