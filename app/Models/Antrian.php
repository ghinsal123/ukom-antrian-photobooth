<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'pengguna_id',
        'nama_lengkap',
        'no_telp',
        'booth_id',
        'paket_id',
        'tanggal',
        'nomor_antrian',
        'status',
        'catatan',
    ];

    public function booth()
    {
        return $this->belongsTo(Booth::class, 'booth_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

        public function logs()
    {
        return $this->hasMany(Log::class, 'antrian_id');
    }

}
