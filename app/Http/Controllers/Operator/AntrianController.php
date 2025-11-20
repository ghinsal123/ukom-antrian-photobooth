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
     * Tampilkan daftar antrian + search + pagination
     */
    public function index(Request $request)
    {
        $query = Antrian::with(['pengguna', 'booth', 'paket']);

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('pengguna', function ($q2) use ($keyword) {
                    $q2->where('nama_pengguna', 'like', "%$keyword%");
                })
                ->orWhere('nomor_antrian', 'like', "%$keyword%")
                ->orWhereHas('booth', function ($q3) use ($keyword) {
                    $q3->where('nama_booth', 'like', "%$keyword%");
                })
                ->orWhereHas('paket', function ($q4) use ($keyword) {
                    $q4->where('nama_paket', 'like', "%$keyword%");
                });
            });
        }

        // Pagination
        $antrian = $query->paginate(10);

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
        $request->validate([
            'pengguna_id'   => 'nullable|exists:pengguna,id',
            'nama_pengguna' => 'nullable|string|max:255',
            'booth_id'      => 'required|exists:booth,id',
            'paket_id'      => 'required|exists:paket,id',
            'tanggal'       => 'required|date',
            'catatan'       => 'nullable|string|max:500',
        ]);

        // Jika operator mengetik nama customer baru
        if (!$request->pengguna_id && $request->nama_pengguna) {
            $user = Pengguna::create([
                'nama_pengguna' => $request->nama_pengguna,
                'no_telp'       => null,
                'password'      => bcrypt('password123'),
                'role'          => 'customer',
            ]);
            $penggunaId = $user->id;
        } else {
            $penggunaId = $request->pengguna_id;
        }

        // Nomor antrian otomatis
        $nomorAntrian = $this->generateNomorAntrian();

        $antrian = Antrian::create([
            'pengguna_id'   => $penggunaId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'nomor_antrian' => $nomorAntrian,
            'tanggal'       => $request->tanggal,
            'status'        => 'menunggu',
            'catatan'       => $request->catatan,
        ]);

        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'buat_reservasi',
            'keterangan'  => 'Operator membuat antrian untuk pengguna ID ' . $penggunaId,
        ]);

        return redirect()->route('operator.antrian.index')
            ->with('success', 'Antrian berhasil ditambahkan!');
    }

    /**
     * Generate nomor antrian otomatis
     */
    private function generateNomorAntrian()
    {
        $last = Antrian::orderBy('id', 'DESC')->first();

        if (!$last) {
            return 'A-001';
        }

        $lastNumber = intval(substr($last->nomor_antrian, 2));
        $newNumber = $lastNumber + 1;

        return 'A-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Detail antrian
     */
    public function show($id)
    {
        $data = Antrian::with(['pengguna', 'booth', 'paket'])->findOrFail($id);
        return view('Operator.antrian.show', compact('data'));
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $data = Antrian::with(['pengguna','booth','paket'])->findOrFail($id);
        $pengguna = Pengguna::all();
        $paket = Paket::all();
        $booth = Booth::all();

        return view('Operator.antrian.edit', compact('data', 'pengguna', 'paket', 'booth'));
    }

    /**
     * Update antrian
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|in:menunggu,proses,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:500',
        ]);

        $antrian = Antrian::findOrFail($id);

        $antrian->update([
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ]);

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
