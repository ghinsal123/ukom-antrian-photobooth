@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- WRAPPER --}}
<div class="space-y-8">

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

        <div class="bg-gradient-to-br from-pink-400 to-pink-600 p-6 rounded-3xl shadow-lg text-white transform hover:scale-105 transition">
            <h3 class="text-sm opacity-90">Total Booth</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalBooth }}</p>
        </div>

        <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-6 rounded-3xl shadow-lg text-white transform hover:scale-105 transition">
            <h3 class="text-sm opacity-90">Total Paket</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalPaket }}</p>
        </div>

        <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-6 rounded-3xl shadow-lg text-white transform hover:scale-105 transition">
            <h3 class="text-sm opacity-90">Total Pengguna</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalAkun }}</p>
        </div>

        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 p-6 rounded-3xl shadow-lg text-white transform hover:scale-105 transition">
            <h3 class="text-sm opacity-90">Total Aktivitas</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalLaporan }}</p>
        </div>

    </div>


    {{-- CHART & TABLE SECTION --}}
    <div class="grid md:grid-cols-2 gap-8">

        {{-- BOOTH TERPOPULER --}}
        <div class="bg-white rounded-3xl shadow-xl p-6 border border-pink-100">
            <h2 class="text-xl font-bold text-gray-700 mb-4">📊 Booth Terpopuler</h2>

            <div class="flex flex-col md:flex-row gap-6">

                {{-- Pie Chart --}}
                <div class="w-full md:w-1/2">
                    <canvas id="popularBoothChart"></canvas>
                </div>

                {{-- Table --}}
                <div class="w-full md:w-1/2">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2">Booth</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($boothTerpopuler as $b)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-2">{{ $b->nama_booth }}</td>
                                <td class="text-pink-500 font-semibold">{{ $b->antrian_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- AKTIVITAS --}}
        <div class="bg-white rounded-3xl shadow-xl p-6 border border-pink-100">
            <h2 class="text-xl font-bold text-gray-700 mb-3">📝 Aktivitas Terbaru</h2>

            <ul class="space-y-3">
                @foreach ($aktivitas as $log)
                <li class="border-b pb-2 hover:bg-gray-50 rounded transition px-1">
                    <strong class="text-pink-600">{{ $log->pengguna->nama_pengguna ?? 'Unknown' }}</strong>
                    <span class="text-gray-700">melakukan</span>
                    <span class="font-semibold">{{ $log->aksi }}</span>
                    <div class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</div>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const boothLabels = @json($boothTerpopuler->pluck('nama_booth'));
    const boothCounts = @json($boothTerpopuler->pluck('antrian_count'));

    const ctx = document.getElementById('popularBoothChart').getContext('2d');

    const popularBoothChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: boothLabels,
            datasets: [{
                data: boothCounts,
                backgroundColor: [
                    '#ec4899',
                    '#3b82f6',
                    '#22c55e',
                    '#f59e0b',
                    '#a855f7',
                    '#ef4444'
                ],
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection
