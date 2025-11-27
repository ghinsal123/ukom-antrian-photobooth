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

class AntrianController extends Controller
{
    /**
     * Menampilkan daftar antrian & pencarian 
     */
    public function index(Request $request)
    {
        $query = Antrian::with(['pengguna', 'booth', 'paket']);

        // fitur pencarian
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
        // validasi input
        $request->validate([
            'pengguna_id'   => 'nullable|exists:pengguna,id',
            'nama_pengguna' => 'nullable|string|max:255',
            'no_telp'       => 'required|numeric|digits_between:10,15',
            'booth_id'      => 'required|exists:booth,id',
            'paket_id'      => 'required|exists:paket,id',
            'catatan'       => 'nullable|string|max:500',
        ], [
            'no_telp.required'        => 'Nomor telepon wajib diisi.',
            'no_telp.numeric'         => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.digits_between'  => 'Nomor telepon harus terdiri dari 10 hingga 15 angka.',
            'booth_id.required'       => 'Booth wajib dipilih.',
            'paket_id.required'       => 'Paket wajib dipilih.',
        ]);

        // cek apakah nomor telepon dipakai orang lain
        if ($request->pengguna_id == null) {

            // membuat pengguna baru 
            if (Pengguna::where('no_telp', $request->no_telp)->exists()) {
                return back()->withErrors([
                    'no_telp' => 'Nomor telepon sudah digunakan pengguna lain.'
                ])->withInput();
            }

        } else {

            // pilih pengguna lama 
            if (
                Pengguna::where('no_telp', $request->no_telp)
                        ->where('id', '!=', $request->pengguna_id)
                        ->exists()
            ) {
                return back()->withErrors([
                    'no_telp' => 'Nomor telepon sudah digunakan pengguna lain.'
                ])->withInput();
            }
        }

        // buat pengguna baru jika tidak memilih pengguna lama
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

        $tanggal = Carbon::today('Asia/Jakarta')->format('Y-m-d');
        $boothId = $request->booth_id;
        $antrian = null;

        // transaksi untuk memastikan nomor antrian tidak bentrok
        DB::transaction(function () use ($boothId, $tanggal, $penggunaId, $request, &$antrian) {

            // dapatkan nomor antrian terakhir untuk booth & tanggal
            $lastNomor = Antrian::where('booth_id', $boothId)
                ->where('tanggal', $tanggal)
                ->lockForUpdate()
                ->max('nomor_antrian');

            $nomorAntrian = ($lastNomor ?? 0) + 1;

            // simpan antrian baru
            $antrian = Antrian::create([
                'pengguna_id'   => $penggunaId,
                'booth_id'      => $boothId,
                'paket_id'      => $request->paket_id,
                'nomor_antrian' => $nomorAntrian,
                'tanggal'       => $tanggal,
                'status'        => 'menunggu',
                'catatan'       => $request->catatan,
            ]);

            // catat log
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
     * Form edit antrian
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
        $antrian = Antrian::findOrFail($id);

        // tidak boleh edit jika status dibatalkan
        if ($antrian->status === 'dibatalkan') {
            return redirect()->route('operator.antrian.index')
                ->with('error', 'Antrian yang dibatalkan tidak dapat diedit.');
        }

        // validasi input update
        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'no_telp'  => 'nullable|string|max:20',
            'catatan'  => 'nullable|string|max:500',
            'status'   => 'required|in:menunggu,proses,selesai,dibatalkan',
        ]);

        DB::transaction(function () use ($antrian, $request) {

            // update data antrian
            $antrian->update([
                'booth_id' => $request->booth_id,
                'paket_id' => $request->paket_id,
                'catatan'  => $request->catatan,
                'status'   => $request->status,
            ]);

            // update nomor telepon pengguna jika ada
            if ($request->no_telp && $antrian->pengguna) {
                $antrian->pengguna->update([
                    'no_telp' => $request->no_telp
                ]);
            }

            // log aktivitas
            Log::create([
                'pengguna_id' => Auth::id(),
                'antrian_id'  => $antrian->id,
                'aksi'        => 'update_antrian',
                'keterangan'  => 'Operator mengupdate antrian',
            ]);
        });

        return redirect()->route('operator.antrian.index')
            ->with('success', 'Antrian berhasil diedit!');
    }

    /**
     * Hapus antrian
     */
    public function destroy($id)
    {
        $antrian = Antrian::findOrFail($id);

        DB::transaction(function () use ($antrian) {

            // simpan log sebelum hapus
            Log::create([
                'pengguna_id' => Auth::id(),
                'antrian_id'  => $antrian->id,
                'aksi'        => 'hapus_antrian',
                'keterangan'  => 'Operator menghapus antrian ID ' . $antrian->id,
            ]);
            
            $antrian->delete();
        });

        return redirect()->route('operator.antrian.index')
            ->with('success', 'Antrian berhasil dihapus!');
    }
    /**
     * Batalkan antrian oleh customer
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $antrian = Antrian::findOrFail($id);

        $antrian->update([
            'status' => 'dibatalkan',
            'catatan' => $request->alasan, 
        ]);

        Log::create([
            'pengguna_id' => $antrian->pengguna_id,
            'antrian_id'  => $antrian->id,
            'aksi'        => 'batal_customer',
            'keterangan'  => $request->alasan, 
        ]);

        return back()->with('success', 'Antrian berhasil dibatalkan!');
    }
}
