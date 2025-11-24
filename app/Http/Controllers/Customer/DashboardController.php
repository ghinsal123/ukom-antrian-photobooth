<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Pengguna;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil customer ID dari session (cek siapa yang login)
        $customerId = session('customer_id');

        // Kalau belum login balik ke halaman login
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // Ambil data user/customer yang lagi login
        $pengguna = Pengguna::findOrFail($customerId);

        /*
        1. AMBIL SEMUA ANTRIAN PUNYA CUSTOMER INI
        Jadi ini buat nampilin daftar antrianku di dashboard
        diurutkan dari tanggal terbaru → lalu id terbaru
        */
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        /*
        2. AMBIL SEMUA BOOTH + ANTRIAN DI DALAMNYA
        Jadi customer bisa lihat booth apa aja dan antrinya
        antrian diurutkan berdasarkan tanggal dan nomor
        */
        $booth = Booth::with([
            'antrian' => function ($q) {
                // ngambil antrian per booth, diurutkan
                $q->orderBy('tanggal', 'DESC')
                  ->orderBy('nomor_antrian', 'ASC')
                  ->with(['pengguna', 'paket']); // ikut ambil user & paket
            }
        ])->get();

        /*
        3. RETURN KE HALAMAN DASHBOARD CUSTOMER
        Bawa data booth, antrian user, dan data loginnya
        */
        return view('customer.dashboard', [
            'booth'     => $booth,
            'antrianku' => $antrianku,
            'pengguna'  => $pengguna
        ]);
    }

    /*
    HALAMAN ARSIP
    Ini halaman buat nampilin antrian yang sudah selesai/dibatalkan
    */
    public function arsip()
    {
        // ambil id siapa yang login
        $customerId = session('customer_id');

        // kalau belum login → tendang ke login
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        // ambil data customer
        $pengguna = Pengguna::findOrFail($customerId);

        /*
        Ambil daftar antrian yang statusnya "selesai" atau "dibatalkan"
        Ini biar masuk ke arsip, bukan tampil di dashboard utama
        */
        $arsip = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->whereIn('status', ['selesai', 'dibatalkan']) // filter status
            ->orderBy('tanggal', 'DESC')
            ->get();

        // kirim data ke view arsip.blade.php
        return view('customer.arsip', compact('arsip', 'pengguna'));
    }

}
