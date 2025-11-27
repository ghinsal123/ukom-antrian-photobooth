<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // mengambil customer dari session
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // mengambil data customer
        $pengguna = Pengguna::find($customerId);

        
        //  ANTRIAN 
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->where(function ($q) {
                $q->whereNotIn('status', ['selesai', 'dibatalkan'])   
                  ->orWhereDate('tanggal', '>=', now()->subDay()->toDateString()); 
            })
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        // Ambil semua booth + antrian
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

        // Arsip 
        $arsip = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('customer.arsip', compact('arsip', 'pengguna'));
    }
}
