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
        'jam',
        'barcode',
        'start_time',
        'end_time',
        'expired_at',
        'status',
        'catatan',
    ];

    // Relasi ke tabel booth
    public function booth()
    {
        return $this->belongsTo(Booth::class, 'booth_id');
    }

    // Relasi ke tabel paket
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    // Relasi ke tabel pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

        public function log()
    {
        return $this->hasMany(Log::class, 'antrian_id');
    }

}
