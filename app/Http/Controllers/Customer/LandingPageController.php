<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Pengguna;
use App\Models\Paket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    public function index()
    {
        // Update status antrian yang kadaluarsa
        $this->updateAntrianKadaluarsa();

        $customerId = session('customer_id');
        $pengguna = $customerId ? Pengguna::find($customerId) : null;

        // Ambil booth dengan antrian HARI INI & AKTIF saja
        $booth = Booth::with([
            'antrian' => function ($q) {
                $q->hariIni() // Hanya hari ini
                  ->aktif() // Hanya menunggu & proses
                  ->belumKadaluarsa() // Belum lewat 10 menit
                  ->orderBy('jam', 'ASC')
                  ->with(['pengguna', 'paket']);
            }
        ])->get();

        // Ambil semua paket
        $paket = Paket::all();

        // Antrian milik user yang login (hari ini & aktif)
        $antrianku = [];
        if ($customerId) {
            $antrianku = Antrian::with(['booth', 'paket'])
                ->where('pengguna_id', $customerId)
                ->hariIni()
                ->aktif()
                ->orderBy('jam', 'ASC')
                ->get();
        }

        return view('customer.landingpage', [
            'pengguna' => $pengguna,
            'booth' => $booth,
            'paket' => $paket,
            'antrianku' => $antrianku,
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
            ->whereIn('status', ['selesai', 'dibatalkan', 'kadaluarsa'])
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('customer.arsip', compact('arsip', 'pengguna'));
    }

    // Method untuk update antrian yang kadaluarsa
    private function updateAntrianKadaluarsa()
    {
        $antrianKadaluarsa = Antrian::where('status', 'menunggu')
            ->hariIni()
            ->whereRaw("TIMESTAMPDIFF(MINUTE, CONCAT(tanggal, ' ', jam), NOW()) > 10")
            ->get();

        foreach ($antrianKadaluarsa as $antrian) {
            $antrian->setKadaluarsa();
        }
    }

    // API endpoint untuk auto-update via JavaScript
    public function updateStatusAntrian()
    {
        $this->updateAntrianKadaluarsa();

        return response()->json([
            'success' => true,
            'message' => 'Status antrian berhasil diperbarui'
        ]);
    }
}