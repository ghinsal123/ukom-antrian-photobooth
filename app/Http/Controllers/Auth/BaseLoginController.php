<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseLoginController extends Controller
{
    protected function doLogin(Request $request, string $role, bool $requirePassword = true): bool
    {
        $credentials = [
            'nama_pengguna' => $request->username,
            'role' => $role
        ];

        if ($requirePassword) {
            $credentials['password'] = $request->password;
        }

        return Auth::attempt($credentials);
    }
}
