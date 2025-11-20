<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;
use App\Models\Antrian;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalBooth'   => Booth::count(),
            'totalPaket'   => Paket::count(),
            'totalAkun'    => Pengguna::count(),
            'totalLaporan' => Antrian::count(), // atau ganti sesuai log nanti
        ]);
    }
}
