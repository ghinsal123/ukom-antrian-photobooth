<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Operator\Antrian;
use App\Models\Pengguna;
use App\Models\Operator\Paket;
use App\Models\Operator\Booth;
use App\Models\Admin\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    /**
     * Tampilkan daftar antrian
     */
    public function index()
    {
        $antrian = Antrian::with(['pengguna', 'paket', 'booth'])->get();
        return view('Operator.antrian.index', compact('antrian'));
    }

    /**
     * Form tambah antrian
     */
    public function create()
    {
        $pengguna = Pengguna::all();
        $paket = Paket::all();
        $booth = Booth::all();

        return view('Operator.antrian.create', compact('pengguna', 'paket', 'booth'));
    }

    /**
     * Simpan antrian baru
     */
    public function store(Request $request)
    {
        // Ambil nomor terakhir di tanggal hari ini
        $last = Antrian::whereDate('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian', 'desc')
            ->first();

        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // Simpan data antrian
        $antrian = Antrian::create([
            'pengguna_id'   => $request->pengguna_id,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'nomor_antrian' => $nextNumber,
            'tanggal'       => $request->tanggal,
            'status'        => 'menunggu',
            'catatan'       => $request->catatan,
        ]);

        // Catat log aktivitas operator
        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'buat_reservasi',
            'keterangan'  => 'Operator membuat antrian untuk pengguna ID ' . $request->pengguna_id,
        ]);

        return redirect()->route('operator.antrian.index');
    }

    /**
     * Tampilkan detail antrian
     */
    public function show($id)
    {
        $data = Antrian::with(['pengguna', 'booth', 'paket'])->findOrFail($id);
        return view('Operator.antrian.show', compact('data'));
    }

    /**
     * Form edit antrian
     */
    public function edit($id)
    {
        $data = Antrian::findOrFail($id);
        $pengguna = Pengguna::all();
        $paket = Paket::all();
        $booth = Booth::all();

        return view('Operator.antrian.edit', compact('data', 'pengguna', 'paket', 'booth'));
    }

    /**
     * Update data antrian
     */
    public function update(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update($request->all());

        // Catat log update
        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'update_status',
            'keterangan'  => 'Operator mengubah data antrian ID ' . $antrian->id,
        ]);

        return redirect()->route('operator.antrian.index');
    }

    /**
     * Hapus antrian
     */
    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);

        // Catat log hapus
        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'hapus_reservasi',
            'keterangan'  => 'Operator menghapus antrian ID ' . $antrian->id,
        ]);

        $antrian->delete();

        return redirect()->route('operator.antrian.index');
    }
}
