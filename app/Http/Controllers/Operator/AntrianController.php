<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Pengguna;
use App\Models\Paket;
use App\Models\Booth;
use App\Models\Log;
use Carbon\Carbon;
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

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('pengguna', fn($q2) => $q2->where('nama_pengguna', 'like', "%$keyword%"))
                  ->orWhere('nomor_antrian', 'like', "%$keyword%")
                  ->orWhereHas('booth', fn($q3) => $q3->where('nama_booth', 'like', "%$keyword%"))
                  ->orWhereHas('paket', fn($q4) => $q4->where('nama_paket', 'like', "%$keyword%"));
            });
        }

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

            // Paksa tanggal WIB dan format Y-m-d
            $tanggal = Carbon::parse($request->tanggal, 'Asia/Jakarta')->format('Y-m-d');

            $nomorAntrian = $this->generateNomorAntrian($request->booth_id, $tanggal);

            // Saat membuat antrian
        $antrian = Antrian::create([
            'pengguna_id'   => $penggunaId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'nomor_antrian' => $nomorAntrian,
            'tanggal'       => $tanggal,
            'status'        => 'menunggu',
            'catatan'       => $request->catatan,
        ]);

        // Buat log
        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'buat_antrian',
            'keterangan'  => 'Operator membuat antrian ID ' . $antrian->id,
        ]);

        // Saat update status
        $antrian->update([
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ]);

        // Buat log update
        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'update_status',
            'keterangan'  => 'Operator mengubah status antrian ID ' . $antrian->id . ' menjadi ' . $request->status,
        ]);
    return redirect()->route('operator.antrian.index')
        ->with('success', 'Antrian berhasil ditambahkan!');
}

    /**
     * Generate nomor antrian otomatis per booth
     */
    private function generateNomorAntrian($boothId, $tanggal)
    {
        // Ambil nomor terakhir di booth yang sama pada tanggal yang sama
        $last = Antrian::where('booth_id', $boothId)
                    ->where('tanggal', $tanggal)
                    ->orderBy('nomor_antrian', 'DESC')
                    ->first();

        return $last ? $last->nomor_antrian + 1 : 1;
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
            'aksi'        => 'hapus_antrian',
            'keterangan'  => 'Operator menghapus antrian ID ' . $antrian->id,
        ]);

        $antrian->delete();

        return redirect()->route('operator.antrian.index');
    }
}
