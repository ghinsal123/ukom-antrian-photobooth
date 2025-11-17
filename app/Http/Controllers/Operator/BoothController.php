<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Operator\Booth;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    public function index()
    {
        $booths = Booth::all();
        return view('Operator.booth.index', compact('booths'));
    }

    public function show($id)
    {
        $booth = Booth::findOrFail($id);
        return view('Operator.booth.show', compact('booth'));
    }
}
