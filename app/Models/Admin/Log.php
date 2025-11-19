<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pengguna;
use App\Models\Antrian;

class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'pengguna_id',
        'antrian_id',
        'aksi',
        'keterangan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }
}
