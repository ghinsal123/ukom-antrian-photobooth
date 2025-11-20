<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    protected $table = 'booths';

    protected $fillable = [
        'nama_booth',
        'kapasitas',
        'gambar'
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'booth_id');
    }
}
