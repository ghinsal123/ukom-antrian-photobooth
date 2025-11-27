<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booth;

class BoothController extends Controller
{
    // menampilkan daftar booth & fitur pencarian
    public function index(Request $request)
    {
        $query = Booth::query();

        // filter pencarian 
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where('nama_booth', 'like', "%$keyword%");
        }

        $booths = $query->get();
        return view('Operator.booth.index', compact('booths'));
    }

    // menampilkan detail booth berdasarkan id
    public function show($id)
    {
        $booth = Booth::findOrFail($id);
        return view('Operator.booth.show', compact('booth'));
    }
}
