<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
    'nama_lengkap' => 'required',
    'no_telp' => 'required',
    'paket_id' => 'required',
    'booth_id' => 'required'
]);


        // Pastikan session customer ada
        if (!session('customer_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Membuat nomor antrian unik
        $nomorAntrian = now()->format('dmy') . rand(100, 999);

        // Simpan ke database
        Antrian::create([
    'pengguna_id' => session('customer_id'),
    'booth_id' => $request->booth_id,
    'paket_id' => $request->paket_id,
    'nomor_antrian' => rand(100, 999),
    'tanggal' => now(),
    'status' => 'menunggu',
    'catatan' => '-'
]);

        return redirect()->route('customer.dashboard')
                         ->with('success', 'Antrian berhasil ditambah!');
    }
}
