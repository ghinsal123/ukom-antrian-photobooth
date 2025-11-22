<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
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

        // untuk cek customer
        $user = Pengguna::where('nama_pengguna', $request->full_name)->first();

        // JIKA BELUM ADA → BUAT USER BARU (DENGAN PASSWORD DUMMY AGAR TIDAK ERROR)
        if (!$user) {
            $user = Pengguna::create([
                'nama_pengguna' => $request->full_name,
                'password'      => bcrypt('default123'), // password dummy agar tidak error
                'role'          => 'customer'
            ]);
        }

        // simpan login 
        session([
            'customer_id'   => $user->id,
            'customer_name' => $user->nama_pengguna
        ]);

        return redirect()->route('customer.dashboard');
    }

    public function logout()
    {
        session()->forget(['customer_id', 'customer_name']);
        return redirect()->route('customer.login');
    }
}
