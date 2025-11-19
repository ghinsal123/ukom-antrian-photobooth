<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    protected $table = 'booth';

    protected $fillable = [
        'nama_booth',
        'kapasitas',
        'gambar',
    ];
}
