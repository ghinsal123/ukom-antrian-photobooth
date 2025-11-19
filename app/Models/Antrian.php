<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'pengguna_id',
        'booth_id',
        'paket_id',
        'nomor_antrian',
        'tanggal',
        'status',
        'catatan'
    ];

    // Relasi ke pengguna (customer)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Relasi ke booth
    public function booth()
    {
        return $this->belongsTo(Booth::class, 'booth_id');
    }

    // Relasi ke paket
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}
