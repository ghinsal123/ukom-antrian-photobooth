<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Pengguna;
use App\Models\Paket;
use App\Models\Booth;
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
        // Validasi input
        $request->validate([
            'pengguna_id'   => 'nullable|exists:pengguna,id',
            'nama_pengguna' => 'nullable|string|max:255',
            'booth_id'      => 'required|exists:booth,id',
            'paket_id'      => 'required|exists:paket,id',
            'tanggal'       => 'required|date',
            'catatan'       => 'nullable|string|max:500',
        ]);

        // Jika operator menulis nama baru, buat pengguna baru
        if (!$request->pengguna_id && $request->nama_pengguna) {
            $user = Pengguna::create([
                'nama_pengguna'     => $request->nama_pengguna,
                'email'    => 'dummy' . time() . '@example.com', // email dummy
                'password' => bcrypt('password123'), // password default
            ]);
            $penggunaId = $user->id;
        } else {
            $penggunaId = $request->pengguna_id;
        }

        // Ambil nomor terakhir di tanggal yang sama
        $last = Antrian::whereDate('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian', 'desc')
            ->first();
        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // Simpan data antrian
        $antrian = Antrian::create([
            'pengguna_id'   => $penggunaId,
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
            'keterangan'  => 'Operator membuat antrian untuk pengguna ID ' . $penggunaId,
        ]);

        return redirect()->route('operator.antrian.index')->with('success', 'Antrian berhasil ditambahkan!');
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
