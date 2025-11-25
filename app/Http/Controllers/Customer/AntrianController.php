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
    // HALAMAN BUAT FORM ANTRIAN
    public function create()
    {
        // cek apakah customer login
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


   
    // MENYIMPAN ANTRIAN BARU
    public function store(Request $request)
    {
        $customerId = session('customer_id');

        // Validasi input
        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tanggal'  => 'required|date',

            // nomor telepon gaboleh sama untuk user yang beda
            'no_telp'  => 'required|min:10|max:15|unique:pengguna,no_telp,' . $customerId,
        ], [
            'no_telp.unique' => 'Nomor telepon ini sudah digunakan oleh pengguna lain.',
        ]);

        // Update nomor telepon customer
        $pengguna = Pengguna::find($customerId);
        $pengguna->update(['no_telp' => $request->no_telp]);

        // Ambil antrian terakhir berdasarkan booth dan tanggal
        $last = Antrian::where('booth_id', $request->booth_id)
            ->whereDate('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian', 'DESC')
            ->first();

        // Hitung nomor antrian berikutnya
        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // Simpan antrian baru
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
        $detail = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        return view('customer.detail', compact('detail'));
    }
    // HALAMAN EDIT ANTRIAN
    public function edit($id)
    {
        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        // Hanya bisa edit jika status menunggu
        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diubah.');
        }

        return view('customer.edit', [
            'antrian'  => $antrian,
            'booth'    => Booth::all(),
            'paket'    => Paket::all(),
            'pengguna' => $antrian->pengguna
        ]);
    }

    // PROSES UPDATE ANTRIAN
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tanggal'  => 'required|date'
        ]);

        $antrian = Antrian::findOrFail($id);

        // Cek status
        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diubah.');
        }

        // Jika booth/tanggal berubah → hitung ulang nomor antrian
        if ($antrian->booth_id != $request->booth_id || $antrian->tanggal != $request->tanggal) {

            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $request->tanggal)
                ->orderBy('nomor_antrian', 'DESC')
                ->first();

            $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

            $antrian->nomor_antrian = $nextNumber;
        }

        // Update data antrian
        $antrian->update([
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id,
            'tanggal'  => $request->tanggal
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil diperbarui.');
    }


    // BATALKAN ANTRIAN
    public function destroy(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);

        // Hanya bisa dibatalkan jika masih menunggu
        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        // Validasi alasan
        $request->validate([
            'alasan' => 'required|string|max:500',
            'catatan_tambahan' => 'nullable|string|max:500',
        ]);

        // Update status
        $antrian->update([
            'status' => 'dibatalkan',
            'catatan' => $request->alasan .
                ($request->catatan_tambahan ? " | Catatan: " . $request->catatan_tambahan : ''),
        ]);

        // Simpan log
        \App\Models\Log::create([
            'pengguna_id' => $antrian->pengguna_id,
            'antrian_id'  => $antrian->id,
            'aksi'        => 'hapus_antrian',
            'keterangan'  => 'Antrian dibatalkan.',
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil dibatalkan.');
    }
}
