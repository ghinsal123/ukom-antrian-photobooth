<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    protected $table = 'booth';

    protected $fillable = ['nama_booth', 'status'];
}
