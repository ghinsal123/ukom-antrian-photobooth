<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // halaman login customer
    public function showLogin()
    {
        return view('customer.login');
    }

    // Proses login customer
    public function login(Request $request)
    {
        // Validasi input 
        $request->validate([
            'full_name' => 'required|string|max:255'
        ]);

       // mengecek customer
        $user = Pengguna::where('nama_pengguna', $request->full_name)->first();

        
        if (!$user) {
            $user = Pengguna::create([
                'nama_pengguna' => $request->full_name,
                'password'      => bcrypt('default123'), // password dummy
                'role'          => 'customer'
            ]);
        }

        /*
        Simpen informasi login di session
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
        // hapus data session 
        session()->forget(['customer_id', 'customer_name']);

        // balik ke halaman login 
        return redirect()->route('customer.login');
    }
}
