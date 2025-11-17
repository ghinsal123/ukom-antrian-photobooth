<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');

        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $user = Pengguna::find($customerId);

        if (!$user) {
            session()->forget(['customer_id', 'customer_name']);
            return redirect()->route('customer.login');
        }

        
       return view('customer.dashboard', [
        'nama' => $user->nama_pengguna,
        'antrianku' => []   
        ]);
    }
}
