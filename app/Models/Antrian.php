<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Antrian extends Model
{
    protected $table = 'antrian';

    protected $fillable = [
        'pengguna_id',
        'booth_id',
        'paket_id',
        'nomor_antrian',
        'tanggal',
        'jam',
        'barcode',
        'scan_at',
        'expired_at',
        'start_time',
        'foto_start_time',
        'end_time',
        'status',
        'catatan',
        'strip',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'foto_start_time' => 'datetime',
        'end_time' => 'datetime',
        'expired_at' => 'datetime',
        'scan_at' => 'datetime',
        'tanggal' => 'date',
    ];

    // Relasi
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

    public function log()
    {
        return $this->hasMany(Log::class, 'antrian_id');
    }

    // Accessor
    public function getTotalStripAttribute()
    {
        return $this->strip;
    }

    // ========== SCOPE BARU ==========
    
    // Scope untuk antrian hari ini saja
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    // Scope untuk antrian aktif (menunggu & proses)
    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['menunggu', 'proses']);
    }

    // Scope untuk antrian yang belum kadaluarsa
    public function scopeBelumKadaluarsa($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'proses')
              ->orWhere(function($subQ) {
                  $subQ->where('status', 'menunggu')
                       ->whereRaw("TIMESTAMPDIFF(MINUTE, CONCAT(tanggal, ' ', jam), NOW()) <= 10");
              });
        });
    }

    // Scope status
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeProses($query)
    {
        return $query->where('status', 'proses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    // ========== HELPER METHOD ==========
    
    // Cek apakah antrian sudah kadaluarsa (lebih dari 10 menit)
    public function isKadaluarsa()
    {
        if ($this->status !== 'menunggu') {
            return false;
        }

        $waktuReservasi = Carbon::parse($this->tanggal . ' ' . $this->jam);
        $sekarang = Carbon::now();
        
        return $sekarang->diffInMinutes($waktuReservasi, false) < -10;
    }

    // Update status jadi kadaluarsa
    public function setKadaluarsa()
    {
        $this->update(['status' => 'kadaluarsa']);
    }

    // Get waktu reservasi lengkap
    public function getWaktuReservasiAttribute()
    {
        return Carbon::parse($this->tanggal . ' ' . $this->jam);
    }
}