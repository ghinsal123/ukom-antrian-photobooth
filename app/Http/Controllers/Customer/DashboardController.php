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
    public function index(Request $request)
    {
        // Pakai session, BUKAN auth()
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $customer = Pengguna::find($customerId);
        $nama = $customer ? $customer->nama_pengguna : 'Pengguna';

        $booths = Booth::all();

        // Antrian di setiap booth
        $antrianBooth = [];
        foreach ($booths as $booth) {
            $antrianBooth[$booth->id] = Antrian::with(['paket', 'pengguna'])
                ->where('booth_id', $booth->id)
                ->orderBy('nomor_antrian')
                ->get();
        }

        // Antrian milik user
        $antrianku = Antrian::with(['booth', 'paket'])
            ->where('pengguna_id', $customerId)
            ->orderBy('id', 'desc')
            ->get();

        return view('customer.dashboard', [
            'nama' => $nama,
            'booths' => $booths,
            'antrianBooth' => $antrianBooth,
            'antrianku' => $antrianku
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
