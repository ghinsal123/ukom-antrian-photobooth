<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showLogin()
    {
        return view('customer.login');
    }

   public function login(Request $request)
{
    session(['customer_name' => $request->full_name]);
    return redirect()->route('customer.dashboard');
}

    public function dashboard()
{
    $nama = session('customer_name', 'Pengunjung'); 
   return view('customer.dashboard', compact('nama'));
}

}
