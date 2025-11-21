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
        // Set tanggal hari ini menggunakan timezone WIB
        $hariIni = Carbon::now('Asia/Jakarta')->startOfDay();

        // Statistik utama berdasarkan WIB
        $antrianHariIni = Antrian::whereDate('tanggal', $hariIni)->count();
        $menunggu       = Antrian::whereDate('tanggal', $hariIni)->where('status', 'menunggu')->count();
        $dalamProses    = Antrian::whereDate('tanggal', $hariIni)->where('status', 'proses')->count();
        $selesai        = Antrian::whereDate('tanggal', $hariIni)->where('status', 'selesai')->count();
        $batal          = Antrian::whereDate('tanggal', $hariIni)->where('status', 'dibatalkan')->count();

        // Ambil semua booth
        $booths = Booth::all();

        // Data chart per booth: total reservasi per booth hari ini (WIB)
        $chartPerBooth = [];
        $labelBooth = [];
        foreach ($booths as $booth) {
            $labelBooth[] = $booth->nama_booth;
            $chartPerBooth[] = Antrian::where('booth_id', $booth->id)
                ->whereDate('tanggal', $hariIni)
                ->count();
        }

        // Data customer per booth untuk daftar customer, waktu ditampilkan WIB
        $customerData = [];
        foreach ($booths as $booth) {
            $customerData[$booth->id] = Antrian::with('pengguna')
                ->where('booth_id', $booth->id)
                ->whereDate('tanggal', $hariIni)
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function($a) {
                    return [
                        'id'   => $a->id, 
                        'name' => $a->pengguna->nama_pengguna ?? '-', 
                        'time' => Carbon::parse($a->created_at)
                                    ->timezone('Asia/Jakarta') 
                                    ->format('H:i') // format jam WIB
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
