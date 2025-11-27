<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    // tampilkan semua paket
    public function index(Request $request)
    {
        $query = Paket::query();

        // jika ada keyword pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where('nama_paket', 'like', "%$keyword%");
        }
        
        $pakets = $query->get(); 

        // tampilkan view index paket dengan data paket
        return view('Operator.paket.index', compact('pakets'));
    }

    // tampilkan detail paket berdasarkan id
    public function show($id)
    {
        $paket = Paket::findOrFail($id);
        return view('Operator.paket.show', compact('paket'));
    }
}
