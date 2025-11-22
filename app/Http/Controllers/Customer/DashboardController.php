<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $pengguna = Pengguna::find($customerId);
        $today = now()->toDateString();

        // Hapus antrian hari lama
        Antrian::whereDate('tanggal', '<', $today)->delete();

        // Antrian user hari ini
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->whereDate('tanggal', $today)
            ->orderBy('id', 'DESC')
            ->get();

        // Antrian semua booth
        $booth = Booth::with(['antrian' => function($q) use ($today) {
            $q->whereDate('tanggal', $today)
              ->orderBy('nomor_antrian', 'ASC')
              ->with(['pengguna', 'paket']);
        }])->get();

        return view('customer.dashboard', [
            'booth'      => $booth,
            'antrianku'  => $antrianku,
            'pengguna'   => $pengguna
        ]);
    }
}
