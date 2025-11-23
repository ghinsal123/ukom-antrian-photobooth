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
        // Ambil customer ID dari session
        $customerId = session('customer_id');

        // Jika belum login → redirect
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // Ambil data customer
        $pengguna = Pengguna::findOrFail($customerId);

        /*
        |--------------------------------------------------------------------------
        | 1. AMBIL ANTRIAN MILIK CUSTOMER
        |--------------------------------------------------------------------------
        */
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 2. AMBIL SEMUA BOOTH + ANTRIAN
        |--------------------------------------------------------------------------
        */
        $booth = Booth::with([
            'antrian' => function ($q) {
                $q->orderBy('tanggal', 'DESC')
                  ->orderBy('nomor_antrian', 'ASC')
                  ->with(['pengguna', 'paket']);
            }
        ])->get();

        /*
        |--------------------------------------------------------------------------
        | 3. RETURN VIEW DASHBOARD
        |--------------------------------------------------------------------------
        */
        return view('customer.dashboard', [
            'booth'     => $booth,
            'antrianku' => $antrianku,
            'pengguna'  => $pengguna
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ⭐ ARSIP PAGE CUSTOMER
    |--------------------------------------------------------------------------
    | Menampilkan semua antrian yang statusnya "selesai"
    */
    public function arsip()
{
    $customerId = session('customer_id');

    if (!$customerId) {
        return redirect()->route('customer.login');
    }

    $pengguna = Pengguna::findOrFail($customerId);

    //  Ambil antrian yang statusnya selesai / dibatalkan
    $arsip = Antrian::with(['booth', 'paket'])
        ->where('pengguna_id', $customerId)
        ->whereIn('status', ['selesai', 'dibatalkan'])
        ->orderBy('tanggal', 'DESC')
        ->get();

    return view('customer.arsip', compact('arsip', 'pengguna'));
}

    }
