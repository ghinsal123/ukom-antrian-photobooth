<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Paket;

class AntrianController extends Controller
{
    public function create()
    {
        return view('customer.antrian', [
            'booths' => Booth::all(),
            'pakets' => Paket::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_telp'      => 'required',
            'booth_id'     => 'required',
            'paket_id'     => 'required',
            'tanggal'      => 'required|date',
        ]);

        $customerId = session('customer_id');

        $last = Antrian::where('booth_id', $request->booth_id)
            ->orderBy('nomor_antrian', 'DESC')
            ->first();

        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        Antrian::create([
            'pengguna_id'   => $customerId,
            'nama_lengkap'  => $request->nama_lengkap,
            'no_telp'       => $request->no_telp,
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
