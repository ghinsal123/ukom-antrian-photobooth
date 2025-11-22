<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booth;

class BoothController extends Controller
{
    public function index(Request $request)
    {
        $query = Booth::query();

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where('nama_booth', 'like', "%$keyword%");
        }

        $booths = $query->get();
        return view('Operator.booth.index', compact('booths'));
    }

    public function show($id)
    {
        $booth = Booth::findOrFail($id);
        return view('Operator.booth.show', compact('booth'));
    }
}
