<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\BaseLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk fitur login dan logout admin
 * Menggunakan BaseLoginController untuk proses autentikasi umum
 */
class LoginController extends BaseLoginController
{
    // Menampilkan halaman form login admin
    public function showLogin()
    {
        return view('admin.login.login');
    }

    // Memproses permintaan login admin
    public function login(Request $request)
    {
        // menggunakan method doLogin() dari BaseLoginController
        if ($this->doLogin($request, 'admin', true)) { // Guard yang digunakan: "admin"
            return redirect()->route('admin.dashboard');// Jika berhasil, berpindah ke dashboard
        }

        // Jika gagal, memunculkan pesan error
        return back()->withErrors([
            'login' => 'Username atau password salah'
        ])->withInput();
    }

    // Logout admin dari sistem
    public function logout()
    {
        Auth::guard('admin')->logout(); 
        return redirect()->route('admin.login');
    }
}