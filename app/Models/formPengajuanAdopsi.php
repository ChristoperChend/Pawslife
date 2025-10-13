<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formPengajuanAdopsi extends Model
{
    protected $table = 'form_pengajuan_adopsi';

    protected $fillable = ['adopter_id', 'hewan_id', 'shelter_id', 'status_pengajuan', 'alasan', 'alasan_persetujuan_pengajuan_adopsi', 'alasan_penolakan_pengajuan_adopsi'];

    public function adopter() {
        return $this->belongsTo(adopter::class);
    }

    public function hewan() {
        return $this->belongsTo(hewan::class);
    }

    public function shelter() {
        return $this->belongsTo(shelter::class);
    }
}
