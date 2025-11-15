<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Operator\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $data = Paket::all();
        return view('Operator.paket.index', compact('data'));
    }

    public function show($id)
    {
        $data = Paket::findOrFail($id);
        return view('Operator.paket.show', compact('data'));
    }
}
