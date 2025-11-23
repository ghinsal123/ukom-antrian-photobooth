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
    
    // Halaman buat create antrian
    public function create()
    {
        // cek customer sudah login
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // kirim data booth, paket, dan data user ke halaman form
        return view('customer.antrian', [
            'booth' => Booth::all(),
            'paket' => Paket::all(),
            'pengguna' => Pengguna::find($customerId)
        ]);
    }

    // Menyimpan antrian baru
    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tanggal'  => 'required|date',
            'no_telp'  => 'required'
        ]);

        // ambil data customer dari session
        $customerId = session('customer_id');
        $pengguna = Pengguna::find($customerId);

        // update nomor telepon customer
        $pengguna->update(['no_telp' => $request->no_telp]);

        // cari nomor antrian terakhir berdasarkan booth dan tanggal
        $last = Antrian::where('booth_id', $request->booth_id)
            ->whereDate('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian', 'DESC')
            ->first();

        // kalau ada nomor terakhir  tambah 1, kalau nggak ada → mulai dari 1
        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // simpan antrian baru
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

    
    // Detail antrian
    public function detail($id)
    {
        // ambil data antrian + relasi (booth, paket, pengguna)
        $detail = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        return view('customer.detail', compact('detail'));
    }

    // Halaman edit antrian
    public function edit($id)
    {
        // ambil data antrian
        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])
            ->findOrFail($id);

        // cuma bisa edit kalau status = menunggu
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

    
    // Proses update antrian
    public function update(Request $request, $id)
    {
        // validasi input
        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tanggal'  => 'required|date'
        ]);

        $antrian = Antrian::findOrFail($id);

        // hanya bisa update kalau status masih menunggu
        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa diubah.');
        }

        // kalau booth/tanggal berubah → hitung ulang nomor antrian baru
        if ($antrian->booth_id != $request->booth_id || $antrian->tanggal != $request->tanggal) {

            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $request->tanggal)
                ->orderBy('nomor_antrian', 'DESC')
                ->first();

            $nextNumber = $last ? $last->nomor_antrian + 1 : 1;
            $antrian->nomor_antrian = $nextNumber;
        }

        // update data antrian
        $antrian->update([
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id,
            'tanggal'  => $request->tanggal
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil diperbarui.');
    }

    // Membatalkan antrian
    public function destroy(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);

        // hanya antrian menunggu yang bisa dibatalkan
        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.dashboard')
                ->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        // validasi alasan dan catatan
        $request->validate([
            'alasan' => 'required|string|max:500',
            'catatan_tambahan' => 'nullable|string|max:500',
        ]);

        // update status jadi dibatalkan
        $antrian->update([
            'status' => 'dibatalkan',
            'catatan' => $request->alasan . 
                        ($request->catatan_tambahan ? " | Catatan: ".$request->catatan_tambahan : ''),
        ]);

        // simpan log pembatalan
        \App\Models\Log::create([
            'pengguna_id' => $antrian->pengguna_id,
            'antrian_id'  => $antrian->id,
            'aksi'        => 'hapus_antrian',
            'keterangan'  => 'Antrian dibatalkan. Alasan: ' . $antrian->catatan_operator,
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil dibatalkan.');
    }
}
