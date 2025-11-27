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
    // FORM ANTRIAN
    public function create()
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        return view('customer.antrian', [
            'booth'    => Booth::all(),
            'paket'    => Paket::all(),
            'pengguna' => Pengguna::find($customerId)
        ]);
    }

    //  ANTRIAN BARU
    public function store(Request $request)
    {
        $customerId = session('customer_id');
        $pengguna = Pengguna::find($customerId);

        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tanggal'  => 'required|date'
        ]);

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

    // DETAIL ANTRIAN
    public function detail($id)
    {
        $detail = Antrian::with(['booth', 'paket', 'pengguna'])->findOrFail($id);
        return view('customer.detail', compact('detail'));
    }

    // FORM EDIT ANTRIAN
    public function edit($id)
    {
        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])->findOrFail($id);

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')->with('error', 'Antrian tidak bisa diubah.');
        }

        return view('customer.edit', [
            'antrian' => $antrian,
            'booth'   => Booth::all(),
            'paket'   => Paket::all()
        ]);
    }

    // UPDATE ANTRIAN
    public function update(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')->with('error', 'Antrian tidak bisa diubah.');
        }

        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id'
        ]);

        if ($antrian->booth_id != $request->booth_id) {
            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $antrian->tanggal)
                ->orderBy('nomor_antrian', 'DESC')
                ->first();
            $antrian->nomor_antrian = $last ? $last->nomor_antrian + 1 : 1;
        }

        $antrian->update([
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Antrian berhasil diperbarui.');
    }

    // BATAL ANTRIAN
    public function destroy(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        $request->validate([
            'alasan' => 'required|string|max:500',
            'catatan_tambahan' => 'nullable|string|max:500',
        ]);

        $antrian->update([
            'status' => 'dibatalkan',
            'catatan' => $request->alasan . ($request->catatan_tambahan ? " | Catatan: ".$request->catatan_tambahan : '')
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Antrian berhasil dibatalkan.');
    }
}
