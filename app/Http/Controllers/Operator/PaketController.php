<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $query = Paket::query();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where('nama_paket', 'like', "%$keyword%");
        }

        $pakets = $query->get(); 

        return view('Operator.paket.index', compact('pakets'));
    }

    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('Operator.paket.show', compact('paket'));
    }
}
