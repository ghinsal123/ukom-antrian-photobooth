<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;
use App\Models\Log;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalBooth   = Booth::count();
        $totalPaket   = Paket::count();
        $totalAkun    = Pengguna::count();
        $totalLaporan = Log::count();

        // Booth Terpopuler
        $boothTerpopuler = Booth::withCount('antrian')
            ->orderBy('antrian_count', 'DESC')
            ->limit(5)
            ->get();

        // Aktivitas Terbaru
        $aktivitas = Log::with('pengguna')
            ->latest()
            ->limit(10)
            ->get();

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
