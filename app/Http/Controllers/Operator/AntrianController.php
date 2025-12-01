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
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\DNS1D;

class AntrianController extends Controller
{
    // --- INDEX ---
    public function index(Request $request)
    {
        $this->expireDueAntrian();

        $query = Antrian::with(['pengguna', 'booth', 'paket']);

        // Filter pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('pengguna', fn($q2) => $q2->where('nama_pengguna', 'like', "%$keyword%"))
                  ->orWhere('nomor_antrian', 'like', "%$keyword%");
            });
        }

        $antrian = $query->orderBy('tanggal', 'desc')->orderBy('jam')->paginate(10);

        return view('Operator.antrian.index', compact('antrian'));
    }

    // --- CREATE ---
    public function create()
    {
        $booth = Booth::all();
        $paket = Paket::all();

        // generate jam list tiap 10 menit 
        $jamList = [];
        for ($time = strtotime('01:00'); $time <= strtotime('22:00'); $time += 600) {
            $jamList[] = date('H:i', $time);
        }

        $jamTerpakai = [];

        foreach ($booth as $b) {
            $jamTerpakai[$b->id] = Antrian::where('booth_id', $b->id)
                ->whereDate('tanggal', now('Asia/Jakarta'))
                ->pluck('jam')
                ->toArray();
        }

        // ambil semua antrian hari ini untuk keperluan lain (JS)
        $antrianHariIni = Antrian::whereDate('tanggal', now('Asia/Jakarta'))->get();

        // jam sekarang
        $jamSekarang = Carbon::now('Asia/Jakarta')->format('H:i');

        return view('Operator.antrian.create', compact(
            'booth',
            'paket',
            'jamList',
            'jamTerpakai',
            'antrianHariIni',
            'jamSekarang',
        ));
    }

    // --- STORE ---
    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id'   => 'nullable|exists:pengguna,id',
            'nama_pengguna' => 'nullable|string|max:255',
            'no_telp'       => 'required|numeric|digits_between:10,15',
            'booth_id'      => 'required|exists:booth,id',
            'paket_id'      => 'required|exists:paket,id',
            'jam'           => 'required|string',
        ]);

        // buat pengguna baru jika tidak ada pengguna_id
        if (!$request->pengguna_id) {
            if (Pengguna::where('no_telp', $request->no_telp)->exists()) {
                return back()->withErrors(['no_telp' => 'Nomor telepon sudah terdaftar'])->withInput();
            }

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
        $antrian = null;

        DB::transaction(function () use ($request, $tanggal, $penggunaId, &$antrian) {

            // Ambil nomor terakhir
            $lastNomor = Antrian::where('booth_id', $request->booth_id)
                ->where('tanggal', $tanggal)
                ->lockForUpdate()
                ->max('nomor_antrian');

            $lastNomorInt = 0;
            if ($lastNomor) {
                $lastNomorInt = (int) $lastNomor;
            }

            $nomorAntrian = $lastNomorInt + 1;
            $nomorAntrianFinal = str_pad($nomorAntrian, 3, '0', STR_PAD_LEFT); // 001, 002, 003

            // Barcode
            $barcodeValue = 'PB-' . $request->booth_id . '-' . time() . '-' . strtoupper(Str::random(5));
            $expiredAt = Carbon::parse($tanggal . ' ' . $request->jam, 'Asia/Jakarta')->addMinutes(10);

            // Simpan antrian
            $antrian = Antrian::create([
                'pengguna_id'   => $penggunaId,
                'booth_id'      => $request->booth_id,
                'paket_id'      => $request->paket_id,
                'nomor_antrian' => $nomorAntrianFinal,
                'tanggal'       => $tanggal,
                'jam'           => $request->jam,
                'barcode'       => $barcodeValue,
                'expired_at'    => $expiredAt,
                'status'        => 'menunggu',
                'catatan'       => $request->catatan ?? null,
            ]);

            // catat log pembuatan antrian
            Log::create([
                 'pengguna_id' => Auth::id(),
                 'antrian_id'  => $antrian->id,
                 'aksi'        => 'buat_antrian',
                 'keterangan'  => 'Operator membuat antrian ID ' . $antrian->id,
                ]);
            });

        if (!$antrian) abort(500, 'Terjadi kesalahan saat membuat antrian.');

        return redirect()->route('operator.antrian.tiket', $antrian->id)
                 ->with('success', 'Antrian berhasil dibuat. Silakan tunjukkan tiket ini.');
    }

    // --- SHOW ---
    public function show($id)
    {
        $this->expireDueAntrian();

        $data = Antrian::with(['pengguna','booth','paket'])->findOrFail($id);

        // Generate barcode image
        $barcodeImageBase64 = null;
        if (!empty($data->barcode)) {
            try {
                $png = (new DNS1D())->getBarcodePNG($data->barcode, 'C128', 2, 50);
                $barcodeImageBase64 = 'data:image/png;base64,' . $png;
            } catch (\Throwable $e) {
                $barcodeImageBase64 = null;
            }
        }

        return view('Operator.antrian.show', compact('data','barcodeImageBase64'));
    }

    // --- SCAN BARCODE ---
    public function scanBarcode(Request $request)
    {
        $this->expireDueAntrian(); 

        // Validasi input barcode
        $request->validate(['barcode' => 'required|string']);
        $barcode = trim($request->barcode);
        $antrian = Antrian::where('barcode', $barcode)->first();

        if (!$antrian) 
            return back()->with('error', 'Barcode tidak ditemukan.');

        if (in_array($antrian->status, ['kadaluarsa','dibatalkan'])) 
            return back()->with('error', 'Antrian sudah expired atau dibatalkan.');

        if ($antrian->status === 'proses') 
            return back()->with('info', 'Antrian sudah diproses sebelumnya.');

        // Cek apakah sudah waktunya scan
        $nowTime = Carbon::now('Asia/Jakarta');
        $jamAntrian = Carbon::parse($antrian->tanggal.' '.$antrian->jam, 'Asia/Jakarta');

        if ($nowTime->lt($jamAntrian)) {
            return redirect()->route('operator.antrian.index')
                    ->with('error', 'Belum waktunya scan. Harap tunggu hingga jam ' . $antrian->jam);
        }
        // Proses scan barcode
        $start = Carbon::now('Asia/Jakarta');
        $slotDuration = 10; // menit
        $durasiProses = 3;
        $durasiSesiFoto = 7;
        $durasiSelesai = 1;

        $fotoStartTime = $start->copy()->addMinutes($durasiProses);
        
        // Update status antrian
        $antrian->update([
            'status'    => 'proses',
            'scan_at'   => $start,
            'start_time'=> $start,
            'proses_start_time' => $start->copy()->addMinutes($durasiProses),
            'foto_start_time'  => $fotoStartTime,
            'end_time'  => $start->copy()->addMinutes($slotDuration),
            'step_durasi' => json_encode([
                'proses'     => $durasiProses,
                'sesi_foto'  => $durasiSesiFoto,
                'selesai'    => $durasiSelesai,
            ]),
        ]);

        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'update_status',
            'keterangan'  => 'Operator/Scanner mulai sesi untuk antrian ID ' . $antrian->id,
        ]);

        return back()->with('success', 'Barcode terdeteksi — sesi dimulai untuk nomor ' . $antrian->nomor_antrian);
    }

    // --- DESTROY ---
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

        return redirect()->route('operator.antrian.index')->with('success','Antrian dihapus.');
    }

    // --- EXPIRE DUE ANTRIAN ---
    public function expireDueAntrian()
    {
        $now = Carbon::now('Asia/Jakarta');

        // kadaluarsa jika melewati expired_at
        Antrian::where('status', 'menunggu')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<=', $now)
            ->update(['status' => 'kadaluarsa', 'catatan' => 'Tidak discan tepat waktu.']);

        // update status otomatis berdasarkan waktu
        Antrian::where('status', 'proses')
            ->whereNotNull('foto_start_time')
            ->where('foto_start_time', '<=', $now)
            ->update(['status' => 'sesi_foto', 'catatan' => 'Sedang melakukan sesi foto.']);

        // selesai otomatis jika end_time terlewati
        Antrian::where('status', 'sesi_foto')
            ->whereNotNull('end_time')
            ->where('end_time', '<=', $now)
            ->update(['status' => 'selesai', 'catatan' => 'Sudah melakukan sesi foto.']);
    }

    // --- API CHECK BARCODE ---
    public function apiCheckBarcode(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);
        $antrian = Antrian::where('barcode', $request->barcode)->first();

        if (!$antrian) return response()->json(['ok'=>false,'message'=>'Not found'], 404);

        return response()->json([
            'ok' => true,
            'data' => $antrian->only(['id','nomor_antrian','tanggal','jam','status','barcode'])
        ]);
    }

    // --- VIEW TIKET ANTRIAN ---
    public function tiket($id)
    {
        $this->expireDueAntrian();

        $data = Antrian::with(['pengguna','booth','paket'])->findOrFail($id);

        // Generate barcode image
        $barcodeImageBase64 = null;
        if (!empty($data->barcode)) {
            try {
                $png = (new DNS1D())->getBarcodePNG($data->barcode, 'C128', 2, 50);
                $barcodeImageBase64 = 'data:image/png;base64,' . $png;
            } catch (\Throwable $e) {
                $barcodeImageBase64 = null;
            }
        }

        return view('Operator.antrian.tiket', compact('data', 'barcodeImageBase64'));
    }

    // --- CETAK PDF TIKET ANTRIAN ---
    public function cetakPdf($id)
    {
        $data = Antrian::with(['pengguna','booth','paket'])->findOrFail($id);

        // Generate barcode image
        $barcodeImageBase64 = null;
        if (!empty($data->barcode)) {
            try {
                $png = (new DNS1D())->getBarcodePNG($data->barcode, 'C128', 2, 50);
                $barcodeImageBase64 = 'data:image/png;base64,' . $png;
            } catch (\Throwable $e) {
                $barcodeImageBase64 = null;
            }
        }

        // Generate PDF
        $pdf = Pdf::loadView('Operator.antrian.pdf', compact('data', 'barcodeImageBase64'))
          ->setPaper('a6', 'portrait')
          ->setOption('title', 'Tiket Antrian #'.$data->nomor_antrian.' - '.($data->pengguna->nama_pengguna ?? 'Customer'))
          ->setOption('isHtml5ParserEnabled', true)
          ->setOption('isPhpEnabled', true);

        $filename = 'tiket-antrian-'.$data->nomor_antrian.'.pdf';

        return $pdf->stream($filename); 
    }

    // --- CANCEL ANTRIAN ---
    public function cancel($id)
    {
        $antrian = Antrian::findOrFail($id);

        // hanya bisa batalkan jika status menunggu
        if ($antrian->status !== 'menunggu') {
            return back()->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        // lakukan pembatalan
        $antrian->update([
            'status'  => 'dibatalkan',
            'catatan' => 'Dibatalkan oleh operator',
        ]);

        // catat log pembatalan
        Log::create([
            'pengguna_id' => Auth::id(),
            'antrian_id'  => $antrian->id,
            'aksi'        => 'hapus_antrian',
            'keterangan'  => 'Operator membatalkan antrian ID ' . $antrian->id,
        ]);

        return redirect()->route('operator.antrian.index')->with('success', 'Antrian berhasil dibatalkan.');
    }
}
