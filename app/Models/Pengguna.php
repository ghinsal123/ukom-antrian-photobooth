<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama_pengguna',
        'no_telp',
        'password',
        'role',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];
}