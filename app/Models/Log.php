<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'pengguna_id',
        'antrian_id',
        'aksi',
        'keterangan',
    ];

    // Relasi ke tabel pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke antrian
    public function antrian()
    {
        return $this->belongsTo(Antrian::class, 'antrian_id');
    }
}
