<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;
use App\Models\Log;

/**
 * Controller untuk halaman Dashboard Admin
 * Berisi statistik website, booth tepopuler, dan aktivitas terbaru
 */
class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalBooth   = Booth::count();     // Hitung total booth
        $totalPaket   = Paket::count();     // Hitung total paket
        $totalAkun    = Pengguna::count();  // Hitung total akun pengguna
        $totalLaporan = Log::count();       // Hitung total log aktivitas

        // Booth Terpopuler berdasarakan jumlah antrian terbanyak
        $boothTerpopuler = Booth::withCount('antrian')
            ->orderBy('antrian_count', 'DESC')
            ->limit(5)
            ->get();

        // Aktivitas Terbaru dari tabel log (max 10 data terakhir)
        $aktivitas = Log::with('pengguna')
            ->latest()
            ->limit(10)
            ->get();

        // Kirim data ke view dashboard
        return view('admin.dashboard', compact(
            'totalBooth',
            'totalPaket',
            'totalAkun',
            'totalLaporan',
            'boothTerpopuler',
            'aktivitas'
        ));
    }
}
