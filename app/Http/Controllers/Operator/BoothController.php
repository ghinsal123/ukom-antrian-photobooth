<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booth;

class BoothController extends Controller
{
    public function index()
    {
        $booths = Booth::all(); // data dari admin
        return view('Operator.booth.index', compact('booths'));
    }

    public function show($id)
    {
        $booth = Booth::findOrFail($id);
        return view('Operator.booth.show', compact('booth'));
    }
}
