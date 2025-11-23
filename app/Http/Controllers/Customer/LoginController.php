<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Tampilin halaman login customer
    public function showLogin()
    {
        return view('customer.login');
    }

    // Proses login customer
    public function login(Request $request)
    {
        // Validasi input (nama harus diisi)
        $request->validate([
            'full_name' => 'required|string|max:255'
        ]);

        // Cek apakah nama customer sudah ada di database
        // kalau ada → ambil data
        $user = Pengguna::where('nama_pengguna', $request->full_name)->first();

        /*
        Kalau nama customer belum ada → buat user baru
        Passwordnya pake dummy "default123" biar tabel ga error
        Role-nya otomatis "customer"
        */
        if (!$user) {
            $user = Pengguna::create([
                'nama_pengguna' => $request->full_name,
                'password'      => bcrypt('default123'), // password dummy
                'role'          => 'customer'
            ]);
        }

        /*
        Simpen informasi login di session
        session ini biar sistem tau siapa yang lagi login
        */
        session([
            'customer_id'   => $user->id,
            'customer_name' => $user->nama_pengguna
        ]);

        // Kembali ke dashboard customer
        return redirect()->route('customer.dashboard');
    }

    //Logout customer
    public function logout()
    {
        // hapus data session customer
        session()->forget(['customer_id', 'customer_name']);

        // balik ke halaman login lagi
        return redirect()->route('customer.login');
    }
}
