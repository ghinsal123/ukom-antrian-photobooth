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
        // Ambil customer dari session
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // Ambil data customer
        $pengguna = Pengguna::find($customerId);

        
        //  ANTRIAN 
        // menampilkan:
        // - Semua antrian aktif (menunggu, proses)
        // - Antrian selesai/dibatalkan hanya jika masih <= 1 hari
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->where(function ($q) {
                $q->whereNotIn('status', ['selesai', 'dibatalkan'])   // tampilkan aktif
                  ->orWhereDate('tanggal', '>=', now()->subDay()->toDateString()); // selesai/dibatalkan tapi masih 1 hari
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

        // Arsip tetap menampilkan semuanya
        $arsip = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('customer.arsip', compact('arsip', 'pengguna'));
    }
}
