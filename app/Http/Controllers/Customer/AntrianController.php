<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AntrianController extends Controller
{
    // FORM ANTRIAN BARU (tanpa ID)
    public function create()
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $pengguna = Pengguna::find($customerId);
        
        if (!$pengguna) {
            return redirect()->route('customer.login');
        }

        $booth = Booth::select('id', 'nama_booth', 'kapasitas', 'gambar')->get();
        $paket = Paket::all();

        return view('customer.antrian', [
            'booth'    => $booth,
            'paket'    => $paket,
            'pengguna' => $pengguna
        ]);
    }

    // TAMPILKAN TIKET/SHOW (dengan ID)
    public function show($id)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])->findOrFail($id);
        
        if ($antrian->pengguna_id != $customerId) {
            abort(403, 'Anda tidak memiliki akses ke antrian ini.');
        }
        
        // Gunakan view yang sama dengan tiket()
        return view('customer.tiket', compact('antrian'));
    }

    // CHECK AVAILABILITY - AJAX ENDPOINT
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'booth_id' => 'required|exists:booth,id'
        ]);

        $bookedTimes = Antrian::where('booth_id', $request->booth_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['menunggu', 'proses', 'sesi_foto'])
            ->pluck('jam')
            ->toArray();

        return response()->json([
            'success' => true,
            'booked_times' => $bookedTimes
        ]);
    }

    // ANTRIAN BARU
    public function store(Request $request)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'booth_id'      => 'required|exists:booth,id',
            'paket_id'      => 'required|exists:paket,id',
            'tanggal'       => 'required|date|after_or_equal:today',
            'jam'           => 'required',
            'tambah_strip'  => 'nullable|integer|min:0|max:10'
        ]);

        $selectedDate = Carbon::parse($request->tanggal);
        
        if ($selectedDate->isPast() && !$selectedDate->isToday()) {
            return back()->with('error', 'Tanggal tidak valid. Pilih tanggal hari ini atau setelahnya.');
        }

        // CEK KETERSEDIAAN WAKTU
        $existingAntrian = Antrian::where('booth_id', $request->booth_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->whereIn('status', ['menunggu', 'proses', 'sesi_foto'])
            ->first();
            
        if ($existingAntrian) {
            return back()->with('error', 'Waktu yang dipilih sudah terisi. Silakan pilih waktu lain.');
        }

        // Validasi jam operasional (09:00 - 21:30)
        $jam = $request->jam;
        $jamPisah = explode(':', $jam);
        $jamInt = (int)$jamPisah[0];
        $menitInt = (int)($jamPisah[1] ?? 0);
        
        if ($jamInt < 9 || $jamInt > 21 || ($jamInt == 21 && $menitInt > 30)) {
            return back()->with('error', 'Waktu harus antara 09:00 - 21:30.');
        }

        // Jika hari ini, cek waktu sudah lewat
        if ($selectedDate->isToday()) {
            $currentTime = Carbon::now();
            $selectedTime = Carbon::createFromFormat('H:i', $jam);
            
            if ($selectedTime->lte($currentTime)) {
                return back()->with('error', 'Waktu yang dipilih sudah terlewat. Silakan pilih waktu yang akan datang.');
            }
        }

        $paket = Paket::findOrFail($request->paket_id);
        $booth = Booth::findOrFail($request->booth_id);
        
        $paket_strip = 4; // Default 4 strip
        $tambah_strip = $request->tambah_strip ?? 0;
        $total_strip = $paket_strip + $tambah_strip;

        // GENERATE NOMOR ANTRIAN OTOMATIS PER BOOTH PER HARI
        $nextNumber = 1;
        $maxAttempts = 100;
        
        for ($i = 1; $i <= $maxAttempts; $i++) {
            $exists = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $request->tanggal)
                ->where('nomor_antrian', $i)
                ->exists();
            
            if (!$exists) {
                $nextNumber = $i;
                break;
            }
        }
        
        if ($nextNumber === $maxAttempts) {
            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $request->tanggal)
                ->orderBy('nomor_antrian', 'DESC')
                ->first();
            
            $nextNumber = $last ? (int)$last->nomor_antrian + 1 : 1;
        }

        // Generate barcode unik
        $barcode = 'PBFF-' . Str::upper(Str::random(8)) . '-' . Carbon::now()->format('Ymd');

        // Buat catatan detail
        $catatan = "Paket: {$paket->nama_paket} ({$paket_strip} strip) | ";
        $catatan .= "Booth: {$booth->nama_booth} (Maks. {$booth->kapasitas} orang)";
        
        if ($tambah_strip > 0) {
            $catatan .= " | Tambah: {$tambah_strip} strip";
        }

        // Data untuk insert
        $antrianData = [
            'pengguna_id'   => $customerId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'tanggal'       => $request->tanggal,
            'jam'           => $request->jam,
            'nomor_antrian' => $nextNumber,
            'barcode'       => $barcode,
            'status'        => 'menunggu',
            'catatan'       => $catatan
        ];

        // Tambahkan kolom strip jika ada
        try {
            $columns = Schema::getColumnListing('antrian');
            if (in_array('strip', $columns)) {
                $antrianData['strip'] = $total_strip;
            }
            
            if (in_array('expired_at', $columns)) {
                $antrianData['expired_at'] = Carbon::createFromFormat('Y-m-d H:i', $request->tanggal . ' ' . $request->jam)
                    ->addMinutes(10);
            }
        } catch (\Exception $e) {
            // Ignore error
        }

        // Buat antrian
        $antrian = Antrian::create($antrianData);

        // Redirect ke halaman tiket
        return redirect()->route('customer.antrian.tiket', $antrian->id)
            ->with('success', 'Antrian berhasil dibuat! Nomor antrian Anda: #' . $nextNumber);
    }

    // DETAIL ANTRIAN
    public function detail($id)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])->findOrFail($id);
        
        if ($antrian->pengguna_id != $customerId) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('customer.detail', compact('antrian'));
    }

    // FORM EDIT ANTRIAN
    public function edit($id)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])->findOrFail($id);
        
        if ($antrian->pengguna_id != $customerId) {
            abort(403, 'Unauthorized access.');
        }

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.landingpage')->with('error', 'Antrian tidak bisa diubah.');
        }

        $booth = Booth::select('id', 'nama_booth', 'kapasitas', 'gambar')->get();
        $paket = Paket::all();

        // Hitung tambah strip dari catatan
        $tambah_strip = 0;
        if (preg_match('/Tambah:\s*(\d+)/i', $antrian->catatan, $matches)) {
            $tambah_strip = (int)$matches[1];
        }

        return view('customer.edit', [
            'antrian'      => $antrian,
            'booth'        => $booth,
            'paket'        => $paket,
            'tambah_strip' => $tambah_strip
        ]);
    }

    // UPDATE ANTRIAN
    public function update(Request $request, $id)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $antrian = Antrian::findOrFail($id);
        
        if ($antrian->pengguna_id != $customerId) {
            abort(403, 'Unauthorized access.');
        }

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.landingpage')->with('error', 'Antrian tidak bisa diubah.');
        }

        $request->validate([
            'booth_id' => 'required|exists:booth,id',
            'paket_id' => 'required|exists:paket,id',
            'tambah_strip' => 'nullable|integer|min:0|max:10'
        ]);

        // Cek ketersediaan booth baru
        if ($antrian->booth_id != $request->booth_id) {
            $existingAntrian = Antrian::where('booth_id', $request->booth_id)
                ->where('tanggal', $antrian->tanggal)
                ->where('jam', $antrian->jam)
                ->whereIn('status', ['menunggu', 'proses', 'sesi_foto'])
                ->where('id', '!=', $id)
                ->first();
                
            if ($existingAntrian) {
                return back()->with('error', 'Booth yang dipilih sudah terisi pada waktu tersebut.');
            }
        }

        $paket = Paket::findOrFail($request->paket_id);
        $booth = Booth::findOrFail($request->booth_id);
        
        $paket_strip = 4; // Default
        $tambah_strip = $request->tambah_strip ?? 0;
        $total_strip = $paket_strip + $tambah_strip;

        // Update catatan
        $catatan = "Paket: {$paket->nama_paket} ({$paket_strip} strip) | ";
        $catatan .= "Booth: {$booth->nama_booth} (Maks. {$booth->kapasitas} orang)";
        
        if ($tambah_strip > 0) {
            $catatan .= " | Tambah: {$tambah_strip} strip";
        }

        $updateData = [
            'booth_id' => $request->booth_id,
            'paket_id' => $request->paket_id,
            'catatan'  => $catatan
        ];

        // Tambahkan strip jika kolom ada
        try {
            $columns = Schema::getColumnListing('antrian');
            if (in_array('strip', $columns)) {
                $updateData['strip'] = $total_strip;
            }
        } catch (\Exception $e) {
            // Ignore
        }

        // Jika booth berubah, hitung ulang nomor antrian
        if ($antrian->booth_id != $request->booth_id) {
            $last = Antrian::where('booth_id', $request->booth_id)
                ->whereDate('tanggal', $antrian->tanggal)
                ->whereIn('status', ['menunggu', 'proses', 'sesi_foto', 'selesai'])
                ->orderBy('nomor_antrian', 'DESC')
                ->first();
            $updateData['nomor_antrian'] = $last ? (int)$last->nomor_antrian + 1 : 1;
        }

        $antrian->update($updateData);

        return redirect()->route('customer.landingpage')->with('success', 'Antrian berhasil diperbarui.');
    }

    // BATAL ANTRIAN
    public function destroy(Request $request, $id)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $antrian = Antrian::findOrFail($id);
        
        if ($antrian->pengguna_id != $customerId) {
            abort(403, 'Unauthorized access.');
        }

        if (strtolower($antrian->status) !== 'menunggu') {
            return redirect()->route('customer.landingpage')->with('error', 'Antrian tidak bisa dibatalkan.');
        }

        $request->validate([
            'alasan' => 'required|string|max:500',
            'catatan_tambahan' => 'nullable|string|max:500',
        ]);

        $booth = Booth::find($antrian->booth_id);
        $paket = Paket::find($antrian->paket_id);
        
        $catatan = "DIBATALKAN | ";
        $catatan .= "Alasan: " . $request->alasan . " | ";
        $catatan .= "Booth: " . ($booth ? $booth->nama_booth : 'Tidak ditemukan') . " | ";
        $catatan .= "Paket: " . ($paket ? $paket->nama_paket : 'Tidak ditemukan');
        
        if ($request->catatan_tambahan) {
            $catatan .= " | Catatan: " . $request->catatan_tambahan;
        }

        $antrian->update([
            'status' => 'dibatalkan',
            'catatan' => $catatan
        ]);

        return redirect()->route('customer.landingpage')->with('success', 'Antrian berhasil dibatalkan.');
    }

    // LIHAT TIKET
    public function tiket($id)
    {
        $customerId = session('customer_id');
        
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $antrian = Antrian::with(['booth', 'paket', 'pengguna'])->findOrFail($id);
        
        if ($antrian->pengguna_id != $customerId) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('customer.tiket', compact('antrian'));
    }
}