<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller; // <- wajib import Controller
use App\Models\Operator\Antrian;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // Tampilkan semua jadwal hari ini (atau bisa semua tanggal)
    public function index()
    {
        $jadwals = Antrian::with(['pengguna','booth','paket'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('booth_id')
            ->orderBy('nomor_antrian')
            ->get();

        return view('Operator.jadwal.index', compact('jadwals'));
    }

    // Tampilkan detail satu jadwal
    public function show($id)
    {
        $jadwal = Antrian::with(['pengguna','booth','paket'])->findOrFail($id);
        return view('Operator.jadwal.show', compact('jadwal'));
    }
}
