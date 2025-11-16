<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Auth\BaseLoginController;
use Illuminate\Http\Request;

class LoginController extends BaseLoginController
{
    public function showLogin()
    {
        return view('operator.auth.login');
    }

    public function login(Request $request)
    {
        if ($this->doLogin($request, 'operator', true)) {
            return redirect()->route('operator.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('operator.login');
    }
}
