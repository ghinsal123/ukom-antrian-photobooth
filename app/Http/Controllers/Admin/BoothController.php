<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booth; // <-- WAJIB ADA
use Illuminate\Http\Request;

class BoothController extends Controller
{
    public function index()
    {
        $booth = Booth::all();
        return view('admin.booth.index', compact('booth'));
    }
}
