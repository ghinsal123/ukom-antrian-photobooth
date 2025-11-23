<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Auth\BaseLoginController;
use Illuminate\Http\Request;

class LoginController extends BaseLoginController
{
    // tampilkan halaman login operator
    public function showLogin()
    {
        return view('operator.login.login');
    }

    // proses login operator
    public function login(Request $request)
    {
        // gunakan method login dari base controller
        if ($this->doLogin($request, 'operator', true)) {
            return redirect()->route('operator.dashboard');
        }

        // jika gagal login
        return back()->withErrors(['login' => 'Username atau password salah']);
    }

    // logout operator
    public function logout()
    {
        auth()->logout();
        return redirect()->route('operator.login');
    }
}
