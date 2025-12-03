<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    protected $table = 'booth';

    protected $fillable = [
        'nama_booth',
        'kapasitas',
        'gambar',
    ];

    // Cast gambar JSON ke array otomatis
    protected $casts = [
        'gambar' => 'array',
    ];

    // Relasi ke tabel antrian
    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'booth_id');
    }
}
