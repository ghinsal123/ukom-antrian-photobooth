<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // Statistik utama
        $antrianHariIni = Antrian::whereDate('tanggal', $hariIni)->count();
        $menunggu        = Antrian::where('status', 'menunggu')->count();
        $dalamProses     = Antrian::where('status', 'proses')->count();
        $selesai         = Antrian::where('status', 'selesai')->count();
        $batal           = Antrian::where('status', 'dibatalkan')->count();

        // Ambil semua booth
        $booths = Booth::all();

        // Data chart per booth: total reservasi per booth hari ini
        $chartPerBooth = [];
        $labelBooth = [];
        foreach ($booths as $booth) {
            $labelBooth[] = $booth->nama_booth;
            $chartPerBooth[] = Antrian::where('booth_id', $booth->id)
                ->whereDate('tanggal', $hariIni)
                ->count();
        }

        // Data customer per booth untuk daftar customer
        $customerData = [];
        foreach ($booths as $booth) {
            $customerData[$booth->id] = Antrian::with('pengguna')
                ->where('booth_id', $booth->id)
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function($a) {
                    return [
                        'id'   => $a->id, 
                        'name' => $a->pengguna->nama_pengguna ?? '-', 
                        'time' => Carbon::parse($a->created_at)
                                    ->timezone('Asia/Jakarta') 
                                    ->format('H:i')
                    ];
                });
        }

        return view('Operator.dashboard', compact(
            'antrianHariIni',
            'menunggu',
            'dalamProses',
            'selesai',
            'batal',
            'chartPerBooth',
            'labelBooth',
            'customerData',
            'booths'
        ));
    }
}
