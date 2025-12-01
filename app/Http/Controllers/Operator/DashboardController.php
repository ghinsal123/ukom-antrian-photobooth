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
        // tanggal hari ini 
        $hariIni = Carbon::now('Asia/Jakarta')->startOfDay();

        // hitung statistik utama berdasarkan tanggal hari ini
        $antrianHariIni = Antrian::whereDate('tanggal', $hariIni)->count();
        $menunggu       = Antrian::whereDate('tanggal', $hariIni)->where('status', 'menunggu')->count();
        $dalamProses    = Antrian::whereDate('tanggal', $hariIni)->where('status', 'proses')->count();
        $selesai        = Antrian::whereDate('tanggal', $hariIni)->where('status', 'selesai')->count();
        $batal          = Antrian::whereDate('tanggal', $hariIni)->where('status', 'dibatalkan')->count();
        $kadaluarsa     = Antrian::whereDate('tanggal', $hariIni)->where('status', 'kadaluarsa')->count();

        $booths = Booth::all();

        // siapkan data grafik (total antrian per booth)
        $chartPerBooth = [];
        $labelBooth = [];

        foreach ($booths as $booth) {
            $labelBooth[] = $booth->nama_booth;
            $chartPerBooth[] = Antrian::where('booth_id', $booth->id)
                ->whereDate('tanggal', $hariIni)
                ->count();
        }

        // daftar customer per booth lengkap dengan nama dan jam
        $customerData = [];
        foreach ($booths as $booth) {
            $customerData[$booth->id] = Antrian::with('pengguna')
                ->where('booth_id', $booth->id)
                ->whereDate('tanggal', $hariIni)
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function($a) {
                    return [
                        'id'     => $a->id,
                        'name'   => $a->pengguna->nama_pengguna ?? '-',
                        'time'   => Carbon::parse($a->created_at)
                                        ->timezone('Asia/Jakarta')
                                        ->format('H:i'),
                        'status' => $a->status
                    ];
                });
        }

        // kirim data ke view dashboard
        return view('Operator.dashboard', compact(
            'antrianHariIni',
            'menunggu',
            'dalamProses',
            'selesai',
            'batal',
            'kadaluarsa',
            'chartPerBooth',
            'labelBooth',
            'customerData',
            'booths'
        ));
    }
}
