@extends('Operator.layout')

@section('content')
<div class="bg-pink-50">

{{-- set locale tanggal & format hari ini --}}
@php
    \Carbon\Carbon::setLocale('id');
    $hariIni = \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y');
@endphp

{{-- header info tanggal & total antrian --}}
<div class="flex items-center justify-between py-2">
    <h2 class="text-xl font-semibold text-gray-700">
        jadwal hari ini: 
        <span class="text-pink-400 font-bold">{{ $hariIni }}</span>
    </h2>

    <div class="text-center bg-blue-400 text-white font-bold rounded-xl px-4 py-2 shadow">
        total antrian: {{ $antrianHariIni }}
    </div>
</div>

{{-- kartu statistik status antrian --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-yellow-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">menunggu</h3>
        <p class="text-3xl font-bold mt-2 text-white">{{ $menunggu }}</p>
    </div>

    <div class="bg-blue-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">dalam proses</h3>
        <p class="text-3xl font-bold mt-2 text-white">{{ $dalamProses }}</p>
    </div>

    <div class="bg-green-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">selesai</h3>
        <p class="text-3xl font-bold mt-2 text-white">{{ $selesai }}</p>
    </div>

    <div class="bg-red-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">pembatalan</h3>
        <p class="text-3xl font-bold mt-2 text-white">{{ $batal }}</p>
    </div>

</div>

{{-- grafik & daftar customer per booth --}}
<div class="flex flex-col md:flex-row gap-4 mb-8">

    {{-- diagram pie booth populer --}}
    <div class="bg-white p-3 rounded-xl shadow-sm w-full md:w-1/2">
        <h3 class="text-lg font-semibold mb-2">distribusi booth populer</h3>
        <canvas id="pieChart" width="200" height="200"></canvas>
    </div>

    {{-- data customer berdasarkan booth --}}
    <div class="bg-white p-4 rounded-xl shadow-sm w-full md:w-1/2">

        {{-- dropdown pilih booth --}}
        <label for="boothSelect" class="block text-gray-700 font-semibold mb-2">pilih booth</label>

        <select id="boothSelect"
            class="border rounded-xl p-3 w-full mb-4 bg-white shadow-sm
                   focus:ring-2 focus:ring-pink-300 focus:border-pink-400
                   transition-all cursor-pointer">

            @foreach($booths as $booth)
                <option value="{{ $booth->id }}">
                    {{ $booth->nama_booth }}
                </option>
            @endforeach
        </select>

        {{-- daftar customer --}}
        <div id="customerList" class="space-y-2"></div>
    </div>

</div>

{{-- script chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // data dari controller
    const chartData = @json($chartPerBooth);
    const labelBooth = @json($labelBooth);
    const customerData = @json($customerData);

    // render chart pie
    const ctx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labelBooth,
            datasets: [{
                label: 'jumlah antrian',
                data: chartData,
                backgroundColor: [
                    'rgba(59,130,246,0.8)',
                    'rgba(253,224,71,0.8)',
                    'rgba(34,197,94,0.8)',
                    'rgba(239,68,68,0.8)',
                    'rgba(168,85,247,0.8)',
                    'rgba(16,185,129,0.8)'
                ],
                borderColor: [
                    'rgba(59,130,246,1)',
                    'rgba(253,224,71,1)',
                    'rgba(34,197,94,1)',
                    'rgba(239,68,68,1)',
                    'rgba(168,85,247,1)',
                    'rgba(16,185,129,1)'
                ],
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });

    // elemen daftar customer
    const customerList = document.getElementById('customerList');
    const boothSelect = document.getElementById('boothSelect');

    // render daftar customer berdasarkan booth
    function renderCustomers(booth) {
        customerList.innerHTML = '';
        if (!customerData[booth]) return;

        customerData[booth].forEach(c => {

            // badge warna status
            let badgeColor = '';
            if (c.status === 'menunggu') badgeColor = 'bg-yellow-500';
            else if (c.status === 'proses') badgeColor = 'bg-blue-500';
            else if (c.status === 'selesai') badgeColor = 'bg-green-500';
            else badgeColor = 'bg-red-500';

            // item customer
            const a = document.createElement('a');
            a.href = `{{ url('operator/antrian/detail') }}/${c.id}`;
            a.className =
                'block bg-pink-50 hover:bg-pink-100 p-3 rounded-xl shadow flex justify-between items-center transition';

            a.innerHTML = `
                <div class="flex flex-col">
                    <span class="text-pink-600 font-semibold">${c.name}</span>
                    <span class="text-gray-500 text-sm">${c.time}</span>
                </div>
                <span class="px-2 py-1 text-xs text-white rounded-full ${badgeColor}">
                    ${c.status.charAt(0).toUpperCase() + c.status.slice(1)}
                </span>
            `;

            customerList.appendChild(a);
        });
    }

    // default tampil booth pertama
    renderCustomers(Object.keys(customerData)[0]);

    // update daftar saat booth diubah
    boothSelect.addEventListener('change', function () {
        renderCustomers(this.value);
    });

</script>

@endsection
