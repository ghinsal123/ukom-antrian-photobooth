<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Pengguna;
use App\Models\Paket; // Jangan lupa import model Paket
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // cek session
        $customerId = session('customer_id');

        // kalau belum login → tetap bisa lihat landing page
        $pengguna = $customerId ? Pengguna::find($customerId) : null;

        // data booth + antrian tetap ditampilkan
        $booth = Booth::with([
            'antrian' => function ($q) {
                $q->orderBy('tanggal', 'DESC')
                    ->orderBy('nomor_antrian', 'ASC')
                    ->with(['pengguna', 'paket']);
            }
        ])->get();

        // TAMBAHKIN INI: Ambil data paket
        $paket = Paket::all(); // atau Paket::where('status', 'aktif')->get() jika ada kolom status

        // jika login → tampilkan antrian miliknya
        $antrianku = [];
        if ($customerId) {
            $antrianku = Antrian::with(['booth', 'paket'])
                ->where('pengguna_id', $customerId)
                ->where(function ($q) {
                    $q->whereNotIn('status', ['selesai', 'dibatalkan'])
                        ->orWhereDate('tanggal', '>=', now()->subDay()->toDateString());
                })
                ->orderBy('tanggal', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('customer.landingpage', [
            'pengguna' => $pengguna,
            'booth' => $booth,
            'paket' => $paket, // TAMBAHKAN INI
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
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('customer.arsip', compact('arsip', 'pengguna'));
    }
}