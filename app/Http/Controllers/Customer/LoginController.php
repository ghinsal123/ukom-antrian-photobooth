<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // login customer
    public function showLogin()
    {
        return view('customer.login');
    }

    // proses login 
    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'no_telp'   => 'required|min:10|max:15'
        ]);

        // cek customer udah ada / belum
        $user = Pengguna::where('nama_pengguna', $request->full_name)->first();

        if (!$user) {
            // jika belum ada, buat baru
            $user = Pengguna::create([
                'nama_pengguna' => $request->full_name,
                'no_telp'       => $request->no_telp,
                'password'      => bcrypt('default123'),
                'role'          => 'customer'
            ]);
        } else {
            // update nomor telepon
            $user->update([
                'no_telp' => $request->no_telp
            ]);
        }

        // simpan session
        session([
            'customer_id'   => $user->id,
            'customer_name' => $user->nama_pengguna
        ]);

        return redirect()->route('customer.dashboard');
    }

    // logout customer
    public function logout()
    {
        // hapus session
        session()->forget(['customer_id', 'customer_name']);

        return redirect()->route('customer.login');
    }
}
