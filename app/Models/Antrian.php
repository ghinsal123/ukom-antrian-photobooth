<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'pengguna_id',
        'booth_id',
        'paket_id',
        'nomor_antrian',
        'tanggal',
        'status',
        'catatan'
    ];
}
