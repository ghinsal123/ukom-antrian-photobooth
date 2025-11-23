@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- GRID STATISTIK --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">

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
        <h3 class="text-gray-500 font-medium">Total Aktivitas</h3>
        <p class="text-3xl font-bold text-pink-500">{{ $totalLaporan }}</p>
    </div>

</div>

{{-- GRID BAGIAN BAWAH --}}
<div class="grid md:grid-cols-2 gap-8">

    {{-- BOOTH TERPOPULER --}}
    <div class="bg-white rounded-3xl shadow-md p-6 border border-pink-100">
        <h2 class="text-xl font-bold mb-3 text-gray-700">Booth Terpopuler</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Booth</th>
                    <th>Total Antrian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($boothTerpopuler as $b)
                <tr class="border-b">
                    <td class="py-2">{{ $b->nama_booth }}</td>
                    <td class="text-pink-500 font-semibold">{{ $b->antrian_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- AKTIVITAS TERBARU --}}
    <div class="bg-white rounded-3xl shadow-md p-6 border border-pink-100">
        <h2 class="text-xl font-bold mb-3 text-gray-700">Aktivitas Terbaru</h2>

        <ul class="space-y-3">
            @foreach ($aktivitas as $log)
            <li class="border-b pb-2">
                <strong>{{ $log->pengguna->nama_pengguna ?? 'Unknown' }}</strong>
                melakukan <span class="font-medium">{{ $log->aksi }}</span>
                <div class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
            </li>
            @endforeach
        </ul>
    </div>

</div>

@endsection
