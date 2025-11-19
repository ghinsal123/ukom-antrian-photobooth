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
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'paket_id' => 'required|integer',
            'booth_id' => 'required|integer',
            'catatan' => 'nullable|string'
        ]);

        // Pastikan user login
        if (!session()->has('customer_id')) {
            return redirect()->route('customer.login')
                ->with('error', 'Sesi Anda berakhir. Silakan login kembali.');
        }

        // Generate nomor antrian
        $nomor = now()->format('dmy') . '-' . rand(100, 999);

        // Simpan database
        Antrian::create([
            'pengguna_id'   => session('customer_id'),
            'nama_lengkap'  => $request->nama_lengkap,
            'no_telp'       => $request->no_telp,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'nomor_antrian' => $nomor,
            'tanggal'       => now(),
            'status'        => 'menunggu',
            'catatan'       => $request->catatan
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', "Antrian berhasil! Nomor Anda: $nomor");
    }
}
