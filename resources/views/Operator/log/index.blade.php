@extends('Operator.layout')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
<div class="container mx-auto px-4 py-6">

    <!-- Header -->
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 text-center md:text-left mb-6">
        Laporan Aktivitas Antrian
    </h2>

    <!-- Tanggal Filter untuk Print -->
    <div class="mb-4 hidden print:block">
        <p class="text-sm">
            Laporan dari: {{ request('start_date') ?? '-' }} 
            sampai: {{ request('end_date') ?? '-' }}
        </p>
    </div>

    <!-- Search + Filter (tidak dicetak) -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 no-print">

        <!-- Search -->
        <div class="w-full md:w-1/3 p-4 md:pt-10 rounded-2xl">
            <form action="{{ route('operator.log.index') }}" method="GET" class="w-full">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" name="search" placeholder="Cari nama, booth, paket, status..."
                        value="{{ request('search') }}"
                        class="border rounded-xl px-9 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                </div>
            </form>
        </div>

        <!-- Filter & Tombol -->
        <form action="{{ route('operator.log.index') }}" method="GET"
            class="flex flex-row flex-wrap gap-3 p-4 md:pt-4 pt-0 rounded-2xl w-full md:w-auto">

            <div class="flex flex-col">
                <label class="text-xs text-gray-600 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 md:w-34 w-40">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-600 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 md:w-34 w-40">
            </div>

            <button type="submit"
                class="bg-pink-500 text-white md:px-3 px-4 py-2 rounded-xl hover:bg-pink-600 shadow-md transition transform hover:scale-105 text-sm">
                Cari
            </button>

            <button type="button" onclick="window.print()"
                class="bg-gray-500 text-white px-3 py-2 rounded-xl hover:bg-gray-600 shadow-md transition transform hover:scale-105 text-sm">
                Cetak
            </button>

        </form>

    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse shadow-xl text-xs sm:text-sm md:text-base">
 <thead class="border bg-pink-100 text-gray-800">
    <tr>
        <th class="px-3 py-2 border">No</th>
        <th class="px-3 py-2 border">Waktu</th>
        <th class="px-3 py-2 border">Operator</th>
        <th class="px-3 py-2 border">Customer</th>
        <th class="px-3 py-2 border">Booth</th>
        <th class="px-3 py-2 border">Paket</th>
        <th class="px-3 py-2 border">Status</th>
        <th class="px-3 py-2 border">Catatan</th> 
        <th class="px-3 py-2 border no-print">Aksi</th>
    </tr>
</thead>

<tbody>
    @forelse($logs as $log)
    <tr class="text-center bg-white hover:bg-pink-50">
        <td class="px-2 py-1 text-center border">{{ $loop->iteration }}</td>
        <td class="px-2 py-1 border">{{ $log->created_at->format('d-m-Y H:i') }}</td>
        <td class="px-2 py-1 border">{{ $log->pengguna->nama_pengguna ?? '-' }}</td>
        <td class="px-2 py-1 border">{{ $log->antrian->pengguna->nama_pengguna ?? '-' }}</td>
        <td class="px-2 py-1 border">{{ $log->antrian->booth->nama_booth ?? '-' }}</td>
        <td class="px-2 py-1 border">{{ $log->antrian->paket->nama_paket ?? '-' }}</td>
        <td class="px-2 py-1 border">
            @if($log->antrian)
                <span class="px-2 py-1 rounded-xl text-gray-800
                    @if($log->antrian->status == 'menunggu') 
                    @elseif($log->antrian->status == 'proses') 
                    @elseif($log->antrian->status == 'selesai')
                    @else @endif">
                    {{ ucfirst($log->antrian->status) }}
                </span>
            @else - @endif
        </td>
        <td class="px-2 py-1 border">{{ $log->antrian->catatan ?? '-' }}</td> 
        <td class="px-2 py-1 border capitalize no-print">{{ str_replace('_', ' ', $log->aksi) }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="px-2 py-2 text-center border">Tidak ada log</td>
    </tr>
    @endforelse
</tbody>

        </table>
    </div>

</div>

<!-- Fungsi CSS Khusus Print -->
<style>
@media print {
    nav,
    #sidebar,
    #overlay,
    .lg\:flex,
    .sticky,
    .no-print {
        display: none !important;
    }
    body {
        margin: 0;
        padding: 0;
        background: white !important;
    }

    .container, .p-6 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>
@endsection
