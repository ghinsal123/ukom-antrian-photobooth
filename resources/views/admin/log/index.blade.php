@extends('admin.layouts.app')

@section('title', 'Log')

@section('content')

<div class="print-area">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="container mx-auto px-4 py-6">
            <h2 class="text-2xl font-semibold text-gray-700">Laporan Aktivitas Harian</h2>
            <div class="mb-4 hidden print:block">
                <p class="text-sm">
                    laporan dari: {{ request('start_date') ?? '-' }} 
                    sampai: {{ request('end_date') ?? '-' }}
                </p>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 no-print">
                <div class="w-full md:w-1/3 p-4 md:pt-10 rounded-2xl">
                    <form action="{{ route('admin.log.index') }}" method="GET" class="w-full">
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                <i class="fas fa-search text-sm"></i>
                            </span>
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="cari nama, booth, paket, status..."
                                value="{{ request('search') }}"
                                class="border rounded-xl px-9 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-500"
                            >
                        </div>
                    </form>
                </div>
                <form 
                    action="{{ route('admin.log.index') }}" 
                    method="GET"
                    class="flex flex-row flex-wrap gap-3 p-4 md:pt-4 pt-0 rounded-2xl w-full md:w-auto"
                >
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-600 mb-1">tanggal mulai</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            value="{{ request('start_date') }}"
                            class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 md:w-34 w-40"
                        >
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-600 mb-1">tanggal selesai</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            value="{{ request('end_date') }}"
                            class="border rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 md:w-34 w-40"
                        >
                    </div>
                    <button 
                        type="submit"
                        class="bg-pink-500 text-white px-3 py-10px rounded-xl hover:bg-pink-600 shadow-md transition transform hover:scale-105 text-sm flex items-center justify-center h-40px mt-4"
                    >
                        cari
                    </button>
                    <button 
                        type="button" 
                        onclick="window.print()"
                        class="bg-gray-500 text-white px-3 py-2 rounded-xl hover:bg-gray-600 shadow-md transition transform hover:scale-105 text-sm"
                    >
                        cetak
                    </button>
                </form>
            </div>

            {{-- tabel log --}}
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse shadow-xl text-xs sm:text-sm md:text-base">
                    <thead class="border bg-pink-100 text-gray-800">
                        <tr>
                            <th class="px-3 py-2 border">no</th>
                            <th class="px-3 py-2 border">waktu</th>
                            <th class="px-3 py-2 border">operator</th>
                            <th class="px-3 py-2 border">customer</th>
                            <th class="px-3 py-2 border">booth</th>
                            <th class="px-3 py-2 border">paket</th>
                            <th class="px-3 py-2 border">status</th>
                            <th class="px-3 py-2 border">catatan</th>
                            <th class="px-3 py-2 border no-print">aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($log as $log)
                        <tr class="text-center bg-white hover:bg-pink-50">

                            <td class="px-2 py-1 border">{{ $loop->iteration }}</td>
                            <td class="px-2 py-1 border">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-2 py-1 border">{{ $log->pengguna->nama_pengguna ?? '-' }}</td>
                            <td class="px-2 py-1 border">{{ $log->antrian->pengguna->nama_pengguna ?? '-' }}</td>
                            <td class="px-2 py-1 border">{{ $log->antrian->booth->nama_booth ?? '-' }}</td>
                            <td class="px-2 py-1 border">{{ $log->antrian->paket->nama_paket ?? '-' }}</td>

                            <td class="px-2 py-1 border">
                                @if($log->antrian)
                                    <span class="px-2 py-1 rounded-xl text-gray-800">
                                        {{ ucfirst($log->antrian->status) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-2 py-1 border">{{ $log->antrian->catatan ?? '-' }}</td>

                            <td class="px-2 py-1 border no-print">
                                {{ str_replace('_', ' ', strtolower($log->aksi)) }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-2 py-2 text-center border">tidak ada log</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {

    /* Hilangkan SEMUA elemen di luar area print */
    body * {
        visibility: hidden !important;
    }

    /* Tampilkan area print saja */
    .print-area, 
    .print-area * {
        visibility: visible !important;
    }

    /* Atur posisi biar rapi */
    .print-area {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
    }

    /* Hilangkan semua search, filter, tanggal, tombol */
    .no-print {
        display: none !important;
    }

    /* Hilangkan kolom aksi */
    th.no-print,
    td.no-print {
        display: none !important;
    }

    /* Hilangkan background gelap */
    body {
        background: white !important;
    }
}
</style>

@endsection
