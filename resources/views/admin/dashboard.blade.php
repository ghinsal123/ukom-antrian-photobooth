@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-5">

    <div class="bg-white p-6 rounded-3xl shadow-md border border-pink-100">
        <h3 class="text-gray-500 font-medium">Total Booth</h3>
        <p class="text-3xl font-bold text-pink-500">{{ $totalBooth }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-md border border-pink-100">
        <h3 class="text-gray-500 font-medium">Total Paket</h3>
        <p class="text-3xl font-bold text-pink-500">{{ $totalPaket }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-md border border-pink-100">
        <h3 class="text-gray-500 font-medium">Total Pengguna</h3>
        <p class="text-3xl font-bold text-pink-500">{{ $totalAkun }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-md border border-pink-100">
        <h3 class="text-gray-500 font-medium">Laporan Bulan Ini</h3>
        <p class="text-3xl font-bold text-pink-500">{{ $totalLaporan }}</p>
    </div>

</div>
@endsection
