@extends('admin.layouts.app')

@section('title', 'Log')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <!-- Header -->
    <div class="flex justify-between items-center mb-5 print:mb-2">
        <h2 class="text-2xl font-semibold text-gray-700">Laporan Aktivitas Antrian</h2>

        <button onclick="window.print()" 
            class="px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 shadow print:hidden">
            Cetak
        </button>
    </div>

    <!-- Info tanggal hanya muncul saat print -->
    <div class="mb-4 hidden print:block text-sm">
        Laporan dari: {{ request('start_date') ?? '-' }} 
        sampai: {{ request('end_date') ?? '-' }}
    </div>

    <!-- Search + Filter -->
    <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-4 print:hidden">

        {{-- Search --}}
        <form action="{{ route('admin.log.index') }}" method="GET" class="w-full md:w-1/3">
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </span>
                <input type="text" name="search" placeholder="Cari nama, booth, paket..."
                    value="{{ request('search') }}"
                    class="border rounded-xl px-9 py-2 w-full text-sm focus:ring-2 focus:ring-pink-500">
            </div>
        </form>

        {{-- Filter Tanggal --}}
        <form action="{{ route('admin.log.index') }}" method="GET"
            class="flex flex-row flex-wrap gap-3">

            <div class="flex flex-col">
                <label class="text-xs text-gray-600 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-pink-500">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-600 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-pink-500">
            </div>

            <button type="submit"
                class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow text-sm">
                Cari
            </button>

        </form>
    </div>

    <!-- Tabel -->
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-pink-100 text-left text-gray-800 print:bg-gray-200">
                <th class="p-3 border">No</th>
                <th class="p-3 border">Waktu</th>
                <th class="p-3 border">Operator</th>
                <th class="p-3 border">Customer</th>
                <th class="p-3 border">Booth</th>
                <th class="p-3 border">Paket</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Catatan</th>
                <th class="p-3 border print:hidden">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($logs as $log)
            <tr class="border-b hover:bg-pink-50 print:hover:bg-transparent">
                <td class="p-3 text-center">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                <td class="p-3">{{ $log->pengguna->nama_pengguna ?? '-' }}</td>
                <td class="p-3">{{ $log->antrian->pengguna->nama_pengguna ?? '-' }}</td>
                <td class="p-3">{{ $log->antrian->booth->nama_booth ?? '-' }}</td>
                <td class="p-3">{{ $log->antrian->paket->nama_paket ?? '-' }}</td>
                <td class="p-3 capitalize">{{ $log->antrian->status ?? '-' }}</td>
                <td class="p-3">{{ $log->antrian->catatan ?? '-' }}</td>

                <!-- Hidden saat print -->
                <td class="p-3 capitalize text-pink-600 font-semibold print:hidden">
                    {{ str_replace('_', ' ', $log->aksi) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="p-3 text-center text-gray-600">Tidak ada log</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

<!-- CSS Khusus Print -->
<style>
@media print {

    /* Sembunyikan semua elemen yang tidak mau dicetak */
    nav,
    #sidebar,
    #overlay,
    .print:hidden,
    .no-print {
        display: none !important;
    }

    /* Rapikan container */
    body {
        margin: 0;
        padding: 0;
        background: white !important;
    }

    .bg-white,
    .p-6,
    .container {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
    }
}
</style>

@endsection
