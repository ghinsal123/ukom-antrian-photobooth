<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\BaseLoginController;
use Illuminate\Http\Request;

class LoginController extends BaseLoginController
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        if ($this->doLogin($request, 'admin', true)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
