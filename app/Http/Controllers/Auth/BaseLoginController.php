<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseLoginController extends Controller
{
    /**
     * Melakukan proses login generik yang bisa digunakan
     * untuk berbagai role (admin / operator / customer)
     */
    protected function doLogin(Request $request, string $role, bool $requirePassword = true): bool
    {
        // Ambil username dan role yang diizinkan
        $credentials = [
            'nama_pengguna' => $request->username,
            'role' => $role
        ];

        // Cek password jika diaktifkan
        if ($requirePassword) {
            $credentials['password'] = $request->password;
        }

        // Attempt login menggunakan guard default (bisa admin/operator/customer)
        return Auth::attempt($credentials);
    }
}
