<?php

namespace App\Http\Controllers\Operator;

use App\Models\Operator\Reservasi;
use App\Models\Operator\Paket;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::with('paket')->get();
        return view('Operator.reservasi.index', compact('reservasi'));
    }

    public function create()
    {
        $paket = Paket::all();
        return view('Operator.reservasi.create', compact('paket'));
    }

    public function store(Request $request)
    {
        Reservasi::create($request->all());
        return redirect()->route('reservasi.index');
    }

    public function show($id)
    {
        $data = Reservasi::with('paket')->findOrFail($id);
        return view('Operator.reservasi.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Reservasi::findOrFail($id);
        $paket = Paket::all();
        return view('Operator.reservasi.edit', compact('data','paket'));
    }

    public function update(Request $request, $id)
    {
        Reservasi::findOrFail($id)->update($request->all());
        return redirect()->route('reservasi.index');
    }

    public function destroy($id)
    {
        Reservasi::findOrFail($id)->delete();
        return redirect()->route('reservasi.index');
    }
}
