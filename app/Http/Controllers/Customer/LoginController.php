<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // ========== HALAMAN ==========
    
    // Halaman Login (Email+Password)
    public function showLogin()
    {
        if (session('customer_id')) {
            return redirect()->route('customer.landingpage');
        }
        return view('customer.login');
    }

    // Halaman Daftar
    public function showDaftar()
    {
        if (session('customer_id')) {
            return redirect()->route('customer.landingpage');
        }
        return view('customer.daftar');
    }

    // Halaman Ambil Antrian (tanpa login)
    public function showAntrian()
    {
        return view('customer.antrian');
    }

    // ========== PROSES ==========
    
    // 1. PROSES LOGIN (Email+Password) - DIPERBAIKI
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Cari user berdasarkan email
        $user = Pengguna::where('email', $request->email)->first();

        // ✅ PESAN ERROR SPESIFIK
        if (!$user) {
            return back()->withErrors([
                'email' => ' Email belum terdaftar. Silakan daftar terlebih dahulu.',
            ])->withInput()->with('error_type', 'email_not_found');
        }

        // ✅ PESAN ERROR SPESIFIK
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah. Silakan coba lagi.',
            ])->withInput()->with('error_type', 'wrong_password');
        }

        // Login berhasil
        session([
            'customer_id'   => $user->id,
            'customer_name' => $user->nama_pengguna,
            'customer_email' => $user->email
        ]);

        return redirect()->route('customer.landingpage')
            ->with('success', ' Login berhasil! Selamat datang ' . $user->nama_pengguna);
    }

    // 2. PROSES DAFTAR/REGISTER - DIPERBAIKI
    public function daftar(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'no_telepon' => [
                'required',
                'string',
                'regex:/^\+62[0-9]{9,13}$/',
                'unique:pengguna,no_telp'
            ],
            'password' => 'required|min:8',
        ], [
            'email.unique' => ' Email sudah digunakan. Silakan login!',
            'no_telepon.unique' => ' Nomor telepon sudah digunakan. Silakan login!',
            'no_telepon.regex' => 'Format nomor telepon tidak valid. Contoh: +628123456789',
            'password.min' => ' Password harus minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        $user = Pengguna::create([
            'nama_pengguna' => $request->nama_pengguna,
            'email'         => $request->email,
            'no_telp'       => $request->no_telepon,
            'password'      => Hash::make($request->password),
            'role'          => 'customer'
        ]);

        // ✅ REDIRECT KE LOGIN (TIDAK AUTO LOGIN)
        return redirect()->route('customer.login')
            ->with('success', 'Pendaftaran berhasil! Silakan login dengan email: ' . $request->email);
    }

    // 3. PROSES AMBIL ANTRIAN (tanpa daftar akun)
    public function ambilAntrian(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'no_telp' => [
                'required',
                'string',
                'regex:/^\+62[0-9]{9,13}$/'
            ],
        ], [
            'no_telp.regex' => ' Format nomor telepon tidak valid. Gunakan format +62xxxxxxxxxx',
        ]);

        // Cek apakah pengguna sudah ada
        $user = Pengguna::where('nama_pengguna', $request->full_name)
                       ->orWhere('no_telp', $request->no_telp)
                       ->first();

        if (!$user) {
            $user = Pengguna::create([
                'nama_pengguna' => $request->full_name,
                'no_telp'       => $request->no_telp,
                'password'      => bcrypt(rand(100000, 999999)),
                'role'          => 'customer_temp'
            ]);
        }

        // Generate nomor antrian
        $lastAntrian = Antrian::latest()->first();
        $nomorAntrian = $lastAntrian ? $lastAntrian->nomor_antrian + 1 : 1;

        // Simpan ke tabel antrian
        $antrian = Antrian::create([
            'pengguna_id' => $user->id,
            'nomor_antrian' => $nomorAntrian,
            'status' => 'menunggu',
            'tanggal' => now()->format('Y-m-d')
        ]);

        // Simpan session
        session([
            'customer_id' => $user->id,
            'customer_name' => $user->nama_pengguna,
            'nomor_antrian' => $nomorAntrian,
            'antrian_id' => $antrian->id
        ]);

        return redirect()->route('customer.antrian.detail')
            ->with('success', ' Nomor antrian berhasil diambil!')
            ->with('nomor_antrian', $nomorAntrian);
    }

    // 4. LOGOUT
    public function logout()
    {
        session()->forget([
            'customer_id', 
            'customer_name', 
            'customer_email',
            'nomor_antrian',
            'antrian_id'
        ]);

        return redirect()->route('customer.landingpage')
            ->with('success', ' Logout berhasil!');
    }
}