<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'pengguna_id',
        'booth_id',
        'paket_id',
        'nomor_antrian',
        'tanggal',
        'status',
        'catatan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function booth()
    {
        return $this->belongsTo(Booth::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
