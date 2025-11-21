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
    /**
     * FORM TAMBAH ANTRIAN
     */
    public function create()
    {
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $pengguna = Pengguna::find($customerId);

        return view('customer.antrian', [
            'booth' => Booth::all(),
            'paket' => Paket::all(),
            'pengguna' => $pengguna
        ]);
    }

    /**
     * SIMPAN ANTRIAN BARU
     */
    public function store(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'booth_id'     => 'required',
            'paket_id'     => 'required',
            'tanggal'      => 'required|date'
        ]);

        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // Ambil data user yang login
        $pengguna = Pengguna::find($customerId);

        // CARI NOMOR ANTRIAN TERAKHIR PER BOOTH
        $last = Antrian::where('booth_id', $request->booth_id)
            ->orderBy('nomor_antrian', 'DESC')
            ->first();

        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // SIMPAN ANTRIAN
        Antrian::create([
            'pengguna_id'   => $customerId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'tanggal'       => $request->tanggal,
            'nomor_antrian' => $nextNumber,
            'status'        => 'menunggu'
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil ditambahkan!');
    }

    /**
     * DETAIL ANTRIAN
     */
    public function detail($id)
    {
        $detail = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        return view('customer.detail', compact('detail'));
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        if ($antrian->status !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diedit.');
        }

        return view('customer.edit', [
            'antrian' => $antrian,
            'booth'   => Booth::all(),
            'paket'   => Paket::all(),
            'pengguna' => $antrian->pengguna
        ]);
    }

    /**
     * UPDATE ANTRIAN
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'booth_id'     => 'required',
            'paket_id'     => 'required',
            'tanggal'      => 'required|date'
        ]);

        $antrian = Antrian::findOrFail($id);

        if ($antrian->status !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diedit.');
        }

        // UPDATE DATA ANTRIAN
        $antrian->update([
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id,
            'tanggal'  => $request->tanggal,
        ]);

        return redirect()->route('customer.dashboard')
            ->with('warning', 'Antrian berhasil diperbarui!');
    }

    /**
     * HAPUS / BATALKAN ANTRIAN
     */
    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);

        if ($antrian->status !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        $antrian->delete();

        return redirect()->route('customer.dashboard')
            ->with('error', 'Antrian berhasil dibatalkan!');
    }
}
