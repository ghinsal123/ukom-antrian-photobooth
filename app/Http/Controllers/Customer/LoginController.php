<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Antrian;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('customer.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255'
        ]);

        $user = Pengguna::firstOrCreate(
            ['nama_pengguna' => $request->full_name],
            ['role' => 'customer', 'password' => bcrypt('customer')]
        );

        session([
            'customer_id' => $user->id,
            'customer_name' => $user->nama_pengguna
        ]);

        return redirect()->route('customer.dashboard');
    }

    public function dashboard()
    {
        $nama = session('customer_name');
        $customer_id = session('customer_id');

        // Ambil semua antrian user
        $antrianku = Antrian::where('pengguna_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', compact('nama', 'antrianku'));
    }

    public function logout()
    {
        session()->forget(['customer_id', 'customer_name']);
        return redirect()->route('customer.login');
    }
}
