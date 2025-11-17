<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';

    protected $fillable = ['nama', 'email', 'password', 'role'];
}
