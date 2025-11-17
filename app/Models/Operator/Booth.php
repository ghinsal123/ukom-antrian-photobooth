<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    use HasFactory;

    protected $table = 'booth'; // optional kalau nama tabel sesuai konvensi

    protected $fillable = [
        'nama_booth',
        'kapasitas',
        'status',
        'jam_mulai',
        'jam_selesai',
    ];
}
