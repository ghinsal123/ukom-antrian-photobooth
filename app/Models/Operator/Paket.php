<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';

    protected $fillable = [
        'nama_paket',
        'harga',
        'gambar',
        'deskripsi'
    ];
}
