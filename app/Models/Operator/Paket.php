<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket'; 

    protected $fillable = [
        'nama_paket',
        'harga',
        'gambar',
        'deskripsi',
    ];
}
