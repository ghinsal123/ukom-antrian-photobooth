<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Paket; 

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();
        return view('Operator.paket.index', compact('pakets'));
    }

    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('Operator.paket.show', compact('paket'));
    }
}
