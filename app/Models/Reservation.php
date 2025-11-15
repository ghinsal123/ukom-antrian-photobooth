<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'customer_name',
        'studio',
        'kode',
        'status',
        'tanggal',
        'waktu'
    ];
}
