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
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class AntrianController extends Controller
{
    /**
     * Tampilkan daftar antrian + search + pagination
     */
    public function index(Request $request)
    {
        $query = Antrian::with(['pengguna', 'booth', 'paket']);

        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('pengguna', fn($q2) => 
                        $q2->where('nama_pengguna', 'like', "%$keyword%"))
                  ->orWhere('nomor_antrian', 'like', "%$keyword%")
                  ->orWhereHas('booth', fn($q3) => 
                        $q3->where('nama_booth', 'like', "%$keyword%"))
                  ->orWhereHas('paket', fn($q4) => 
                        $q4->where('nama_paket', 'like', "%$keyword%"));
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
        return view('Operator.antrian.create', [
            'pengguna' => Pengguna::all(),
            'paket'    => Paket::all(),
            'booth'    => Booth::all(),
        ]);
    }

    /**
     * Simpan antrian baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id'   => 'nullable|exists:pengguna,id',
            'nama_pengguna' => 'nullable|string|max:255',
            'no_telp'       => 'nullable|string|max:20',
            'booth_id'      => 'required|exists:booth,id',
            'paket_id'      => 'required|exists:paket,id',
            'tanggal'       => 'required|date',
            'catatan'       => 'nullable|string|max:500',
        ]);

        // Buat pengguna baru jika diisi manual
        if (!$request->pengguna_id && $request->nama_pengguna) {
            $user = Pengguna::create([
                'nama_pengguna' => $request->nama_pengguna,
                'no_telp'       => $request->no_telp,
                'password'      => bcrypt('password123'),
                'role'          => 'customer',
            ]);

            $penggunaId = $user->id;
        } else {
            $penggunaId = $request->pengguna_id;
        }

        $tanggal = Carbon::parse($request->tanggal, 'Asia/Jakarta')->format('Y-m-d');
        $boothId = $request->booth_id;
        $antrian = null;

        // Transaksi untuk memastikan nomor antrian unik
        DB::transaction(function () use ($boothId, $tanggal, $penggunaId, $request, &$antrian) {

            $lastNomor = Antrian::where('booth_id', $boothId)
                ->where('tanggal', $tanggal)
                ->lockForUpdate()
                ->max('nomor_antrian');

            $nomorAntrian = ($lastNomor ?? 0) + 1;

            $antrian = Antrian::create([
                'pengguna_id'   => $penggunaId,
                'booth_id'      => $boothId,
                'paket_id'      => $request->paket_id,
                'nomor_antrian' => $nomorAntrian,
                'tanggal'       => $tanggal,
                'status'        => 'menunggu',
                'catatan'       => $request->catatan,
            ]);

            Log::create([
                'pengguna_id' => Auth::id(),
                'antrian_id'  => $antrian->id,
                'aksi'        => 'buat_antrian',
                'keterangan'  => 'Operator membuat antrian ID ' . $antrian->id,
            ]);
        });

        return redirect()->route('operator.antrian.index')
            ->with('success', 'Antrian berhasil ditambahkan!');
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
        return view('Operator.antrian.edit', [
            'data'     => Antrian::with(['pengguna', 'booth', 'paket'])->findOrFail($id),
            'pengguna' => Pengguna::all(),
            'paket'    => Paket::all(),
            'booth'    => Booth::all(),
        ]);
    }

    /**
     * Update antrian
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pengguna_id' => 'nullable|exists:pengguna,id',
            'booth_id'    => 'required|exists:booth,id',
            'paket_id'    => 'required|exists:paket,id',
            'tanggal'     => 'required|date',
            'status'      => 'required|in:menunggu,proses,selesai,dibatalkan',
            'catatan'     => 'nullable|string|max:500',
        ]);

        $antrian = Antrian::findOrFail($id);

        // Log perubahan
        $changes = [];
        foreach (['booth_id', 'paket_id', 'tanggal', 'status', 'catatan'] as $field) {
            if ($antrian->$field != $request->$field) {
                $changes[$field] = [
                    'old' => $antrian->$field,
                    'new' => $request->$field,
                ];
            }
        }

        // Jika booth / tanggal diganti → reset nomor antrian
        if ($antrian->booth_id != $request->booth_id || $antrian->tanggal != $request->tanggal) {
            $lastNomor = Antrian::where('booth_id', $request->booth_id)
                ->where('tanggal', $request->tanggal)
                ->max('nomor_antrian');

            $antrian->nomor_antrian = ($lastNomor ?? 0) + 1;
        }

        // Update data utama
        $antrian->update([
            'pengguna_id' => $request->pengguna_id,
            'booth_id'    => $request->booth_id,
            'paket_id'    => $request->paket_id,
            'tanggal'     => $request->tanggal,
            'status'      => $request->status,
            'catatan'     => $request->catatan,
        ]);

        // Simpan log perubahan
        if (!empty($changes)) {
            Log::create([
                'pengguna_id' => Auth::id(),
                'antrian_id'  => $antrian->id,
                'aksi'        => 'update_antrian',
                'keterangan'  => json_encode($changes),
            ]);
        }

        return redirect()->route('operator.antrian.index')
            ->with('success', 'Antrian berhasil diupdate!');
    }
}
