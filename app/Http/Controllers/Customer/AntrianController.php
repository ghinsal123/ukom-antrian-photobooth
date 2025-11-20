<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;

class AntrianController extends Controller
{
    public function create()
    {
        return view('customer.antrian', [
            'booth' => Booth::all(),
            'paket' => Paket::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'booth_id' => 'required',
            'paket_id' => 'required',
            'tanggal'  => 'required|date',
        ]);

        $customerId = session('customer_id');
        $customer   = Pengguna::findOrFail($customerId); // ← AMBIL DATA PENGGUNA

        // Hitung nomor antrian berikutnya
        $last = Antrian::where('booth_id', $request->booth_id)
            ->orderBy('nomor_antrian', 'DESC')
            ->first();

        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // Simpan KE TABEL ANTRIAN (tanpa nama & no_telp)
        Antrian::create([
            'pengguna_id'   => $customerId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'tanggal'       => $request->tanggal,
            'nomor_antrian' => $nextNumber,
            'status'        => 'menunggu'
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil dibuat!');
    }
}