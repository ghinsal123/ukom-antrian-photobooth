<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';

    protected $fillable = [
        'nama_paket',
        'harga',
        'gambar',
        'deskripsi',
    ];

    // Relasi ke tabel antrian
    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'paket_id');
    }
}
