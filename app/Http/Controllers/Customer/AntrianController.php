<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;

class AntrianController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'booth_id' => 'required|integer',
            'paket_id' => 'required|integer',
            'catatan'  => 'nullable|string'
        ]);

        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        Antrian::create([
            'pengguna_id'   => $customerId,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'nomor_antrian' => $this->generateNomorAntrian(),
            'tanggal'       => now()->format('Y-m-d'),
            'status'        => 'menunggu',
            'catatan'       => $request->catatan,
        ]);

        return redirect()->route('customer.dashboard');
    }

    private function generateNomorAntrian()
    {
        $last = Antrian::orderBy('id', 'desc')->first();
        $next = $last ? $last->id + 1 : 1;

        return now()->format('dmy') . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
