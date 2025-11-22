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
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        return view('customer.antrian', [
            'booth' => Booth::all(),
            'paket' => Paket::all(),
            'pengguna' => Pengguna::find($customerId)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'booth_id' => 'required',
            'paket_id' => 'required',
            'tanggal'  => 'required|date',
            'no_telp'  => 'required'
        ]);

        $customerId = session('customer_id');
        $pengguna = Pengguna::find($customerId);

        // update nomor telepon
        $pengguna->update(['no_telp' => $request->no_telp]);

        // nomor antrian otomatis
        $last = Antrian::where('booth_id', $request->booth_id)
            ->whereDate('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian', 'DESC')
            ->first();

        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        Antrian::create([
            'pengguna_id'   => $customerId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'tanggal'       => $request->tanggal,
            'nomor_antrian' => $nextNumber,
            'status'        => 'menunggu'
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function detail($id)
    {
        $detail = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        return view('customer.detail', compact('detail'));
    }

    public function edit($id)
    {
        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        if ($antrian->status !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diubah.');
        }

        return view('customer.edit', [
            'antrian' => $antrian,
            'booth'   => Booth::all(),
            'paket'   => Paket::all(),
            'pengguna' => $antrian->pengguna
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'booth_id' => 'required',
            'paket_id' => 'required',
            'tanggal'  => 'required|date'
        ]);

        $antrian = Antrian::findOrFail($id);

        if ($antrian->status !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diubah.');
        }

        // Jika booth berubah → hitung nomor baru
        if ($antrian->booth_id != $request->booth_id) {

            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $request->tanggal)
                ->orderBy('nomor_antrian', 'DESC')
                ->first();

            $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

            $antrian->nomor_antrian = $nextNumber;
        }

        // Update data
        $antrian->update([
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id,
            'tanggal'  => $request->tanggal
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);

        if ($antrian->status !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        $antrian->delete();

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil dibatalkan.');
    }
}
