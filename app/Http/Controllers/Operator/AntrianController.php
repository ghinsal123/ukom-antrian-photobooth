<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Operator\Antrian;
use App\Models\Pengguna;
use App\Models\Operator\Paket;
use App\Models\Operator\Booth;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = Antrian::with(['pengguna', 'paket', 'booth'])->get();
        return view('Operator.antrian.index', compact('antrian'));
    }

    public function create()
    {
        $pengguna = Pengguna::all();
        $paket = Paket::all();
        $booth = Booth::all();
        return view('Operator.antrian.create', compact('pengguna', 'paket', 'booth'));
    }

    public function store(Request $request)
    {
        // Ambil nomor terakhir di tanggal hari ini
        $last = Antrian::whereDate('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian', 'desc')
            ->first();

        // Jika belum ada → mulai dari 1
        $nextNumber = $last ? $last->nomor_antrian + 1 : 1;

        // Simpan data
        Antrian::create([
            'pengguna_id'   => $request->pengguna_id,
            'booth_id'      => $request->booth_id,
            'paket_id'      => $request->paket_id,
            'nomor_antrian' => $nextNumber,
            'tanggal'       => $request->tanggal,
            'status'        => 'menunggu', // otomatis default
            'catatan'       => $request->catatan,
        ]);

        return redirect()->route('operator.antrian.index');
    }

    public function show($id)
    {
        $data = Antrian::with(['pengguna','booth','paket'])->findOrFail($id);
        return view('Operator.antrian.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Antrian::findOrFail($id);
        $pengguna = Pengguna::all();
        $paket = Paket::all();
        $booth = Booth::all();

        return view('Operator.antrian.edit', compact('data','pengguna','paket','booth'));
    }

    public function update(Request $request, $id)
    {
        Antrian::findOrFail($id)->update($request->all());
        return redirect()->route('antrian.index');
    }

    public function destroy($id)
    {
        Antrian::findOrFail($id)->delete();
        return redirect()->route('antrian.index');
    }
}
