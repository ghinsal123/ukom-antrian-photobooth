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
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
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
            ->with('success', 'Antrian berhasil ditambahkan.');
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

        if (strtolower($antrian->status) !== 'menunggu') {
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
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tanggal'  => 'required|date'
        ]);

        $antrian = Antrian::findOrFail($id);

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diubah.');
        }

        // hitung nomor baru jika booth/tanggal berubah
        if ($antrian->booth_id != $request->booth_id || $antrian->tanggal != $request->tanggal) {
            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $request->tanggal)
                ->orderBy('nomor_antrian', 'DESC')
                ->first();

            $nextNumber = $last ? $last->nomor_antrian + 1 : 1;
            $antrian->nomor_antrian = $nextNumber;
        }

        $antrian->update([
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id,
            'tanggal'  => $request->tanggal
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        // ubah status (jangan delete)
        $antrian->update(['status' => 'dibatalkan']);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil dibatalkan.');
    }
}
