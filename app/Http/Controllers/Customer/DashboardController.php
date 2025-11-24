<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Paket;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil customer dari session, BUKAN Auth
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $pengguna = Pengguna::find($customerId);

        // Ambil antrian milik customer
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        // Ambil semua booth
        $booth = Booth::with([
            'antrian' => function ($q) {
                $q->orderBy('tanggal', 'DESC')
                  ->orderBy('nomor_antrian', 'ASC')
                  ->with(['pengguna', 'paket']);
            }
        ])->get();

        return view('customer.dashboard', [
            'booth'     => $booth,
            'antrianku' => $antrianku,
            'pengguna'  => $pengguna
        ]);
    }


    public function arsip()
    {
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $pengguna = Pengguna::find($customerId);

        $arsip = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('customer.arsip', compact('arsip', 'pengguna'));
    }
}
