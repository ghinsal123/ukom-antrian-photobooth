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

        // Ambil semua antrian milik user (semua status, semua tanggal)
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        // Ambil semua booth + antriannya (semua tanggal). Jika ingin hanya hari ini,
        // ubah whereDate('tanggal', now()->toDateString()) di query antrian.
        $booth = Booth::with(['antrian' => function ($q) {
            $q->orderBy('tanggal', 'DESC')
              ->orderBy('nomor_antrian', 'ASC')
              ->with(['pengguna', 'paket']);
        }])->get();

        return view('customer.dashboard', [
            'booth'     => $booth,
            'antrianku' => $antrianku,
            'pengguna'  => $pengguna
        ]);
    }
}
