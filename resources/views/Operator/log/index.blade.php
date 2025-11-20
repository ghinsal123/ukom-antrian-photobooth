@extends('Operator.layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header + Form Pencarian & Cetak -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Aktivitas Antrian</h2>

        <!-- Form pencarian & tombol -->
        <form action="{{ route('operator.log.index') }}" method="GET" 
              class="flex flex-col sm:flex-row gap-2 w-full md:w-auto bg-white p-3 sm:p-4 rounded-2xl shadow-lg items-center">
            <div class="relative flex-1 w-full sm:w-auto">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" placeholder="Cari nama, booth, paket..." 
                       value="{{ request('search') }}"
                       class="border rounded-xl px-9 py-2 w-full sm:w-64 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            <button type="submit" 
                    class="bg-pink-500 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl hover:bg-pink-600 shadow-md transition transform hover:scale-105 text-sm sm:text-base w-full sm:w-auto">
                Cari
            </button>
            <button type="button" onclick="window.print()" 
                    class="bg-gray-500 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl hover:bg-gray-600 shadow-md transition transform hover:scale-105 text-sm sm:text-base w-full sm:w-auto">
                Cetak
            </button>
        </form>
    </div>

    <!-- Tabel responsif -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse rounded-2xl shadow-xl overflow-hidden text-xs sm:text-sm md:text-base">
            <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white text-xs sm:text-sm">
                <tr>
                    <th class="px-3 py-2">No</th>
                    <th class="px-3 py-2">Tanggal</th>
                    <th class="px-3 py-2">Role</th>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">Booth</th>
                    <th class="px-3 py-2">Paket</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="bg-white hover:bg-pink-50 shadow-sm sm:shadow-md hover:shadow-lg">
                    <td class="px-2 py-1 text-center border">{{ $loop->iteration }}</td>
                    <td class="px-2 py-1 border">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                    <td class="px-2 py-1 border">
                        @if($log->pengguna)
                            Customer
                        @else
                            Operator
                        @endif
                    </td>
                    <td class="px-2 py-1 border">{{ $log->pengguna->nama ?? 'Operator' }}</td>
                    <td class="px-2 py-1 border">{{ $log->antrian->booth->nama ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $log->antrian->paket->nama ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $log->antrian->status ?? '-' }}</td>
                    <td class="px-2 py-1 border">{{ $log->aksi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-2 py-2 text-center border">Tidak ada log</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- CSS print -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        form, button {
            display: none;
        }
    }
</style>
@endsection
