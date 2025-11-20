<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\BaseLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseLoginController
{
    public function showLogin()
    {
        return view('admin.login.login');
    }

    public function login(Request $request)
    {
        if ($this->doLogin($request, 'admin', true)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah'
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('admin')->logout(); // FIX
        return redirect()->route('admin.login');
    }
}