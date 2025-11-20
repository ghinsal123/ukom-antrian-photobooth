<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Booth;
use App\Models\Paket;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');
        $customerName = session('customer_name');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $booths = Booth::with(['antrian' => function($q) {
            $q->orderBy('nomor_antrian', 'ASC')
              ->with(['pengguna', 'paket']);
        }])->get();

        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->orderBy('id', 'DESC')
            ->get();

        return view('customer.dashboard', [
            'nama'       => $customerName,
            'booths'     => $booths,
            'antrianku'  => $antrianku
        ]);
    }

    public function delete($id)
    {
        $customerId = session('customer_id');

        $antrian = Antrian::where('id', $id)
            ->where('pengguna_id', $customerId)
            ->first();

        if (!$antrian) {
            return redirect()->back()->with('error', 'Antrian tidak ditemukan');
        }

        $antrian->delete();

        return redirect()->route('customer.dashboard')
            ->with('success', 'Antrian berhasil dihapus!');
    }
}
