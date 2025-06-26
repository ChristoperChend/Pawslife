<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favorit extends Model
{
    protected $table = 'favorit';

    protected $fillable = ['adopter_id', 'hewan_id'];

    public function adopter() {
        return $this->belongsTo(adopter::class, 'adopter_id');
    }

    public function hewan() {
        return $this->belongsTo(hewan::class, 'hewan_id');
    }
}
