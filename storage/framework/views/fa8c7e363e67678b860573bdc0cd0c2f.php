<?php $__env->startSection('content'); ?>
<div class="bg-pink-50">
<h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Operator</h2>

<!-- Tanggal / Jadwal -->
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">
            Jadwal Hari Ini: 
            <span class="text-pink-400 font-bold"><?php echo e(\Carbon\Carbon::now()->format('l, d F Y')); ?></span>
        </h2>
    </div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-blue-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">Reservasi Hari Ini</h3>
        <p class="text-3xl font-bold mt-2 text-white">12</p>
    </div>

    <div class="bg-yellow-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">Dalam Proses</h3>
        <p class="text-3xl font-bold mt-2 text-white">7</p>
    </div>

    <div class="bg-green-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">Selesai</h3>
        <p class="text-3xl font-bold mt-2 text-white">20</p>
    </div>

    <div class="bg-red-400 p-6 rounded-xl shadow-sm text-center">
        <h3 class="font-bold text-white">Pembatalan</h3>
        <p class="text-3xl font-bold mt-2 text-white">10</p>
    </div>
</div>
<!-- Container flex untuk diagram & booth -->
<div class="flex flex-col md:flex-row gap-4 mb-8">

    <!-- Diagram Lingkaran (Kiri) -->
    <div class="bg-white p-3 rounded-xl shadow-sm w-full md:w-1/2">
        <h3 class="text-lg font-semibold mb-2">Distribusi Reservasi</h3>
        <canvas id="pieChart" width="200" height="200"></canvas>
    </div>

    <!-- Booth Selector & Customer List (Kanan) -->
    <div class="bg-white p-4 rounded-xl shadow-sm w-full md:w-1/2">
        <label for="boothSelect" class="block text-gray-700 font-semibold mb-2">Pilih Booth</label>
        <select id="boothSelect" class="border border-gray-300 rounded p-2 w-full mb-4">
            <option value="1">Booth 1</option>
            <option value="2">Booth 2</option>
            <option value="3">Booth 3</option>
            <option value="4">Booth 4</option>
            <option value="5">Booth 5</option>
        </select>

        <!-- Daftar Customer -->
        <div id="customerList" class="space-y-2">
            <!-- Contoh Card Customer -->
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = {
        1: [12, 7, 20, 10],
        2: [5, 3, 15, 2],
        3: [8, 4, 10, 5],
        4: [6, 2, 18, 4],
        5: [10, 5, 12, 3]
    };

    const customerData = {
        1: [{name:"Ghina", time:"10:00"}, {name:"Amanda", time:"10:30"}],
        2: [{name:"Putri", time:"11:00"}, {name:"Alaysa", time:"11:30"}],
        3: [{name:"Budi", time:"12:00"}, {name:"Dewi", time:"12:30"}],
        4: [{name:"Rizky", time:"13:00"}, {name:"Sari", time:"13:30"}],
        5: [{name:"Tono", time:"14:00"}, {name:"Nina", time:"14:30"}]
    };

    const ctx = document.getElementById('pieChart').getContext('2d');
    let pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Reservasi Hari Ini', 'Dalam Proses', 'Selesai', 'Pembatalan'],
            datasets: [{
                label: 'Jumlah',
                data: chartData[1],
                backgroundColor: [
                    'rgba(59,130,246,0.8)',
                    'rgba(253,224,71,0.8)',
                    'rgba(34,197,94,0.8)',
                    'rgba(239,68,68,0.8)'
                ],
                borderColor: [
                    'rgba(59,130,246,1)',
                    'rgba(253,224,71,1)',
                    'rgba(34,197,94,1)',
                    'rgba(239,68,68,1)'
                ],
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });

    const customerList = document.getElementById('customerList');
    const boothSelect = document.getElementById('boothSelect');

    function renderCustomers(booth) {
        customerList.innerHTML = '';
        customerData[booth].forEach(c => {
            const div = document.createElement('div');
            div.className = 'bg-pink-50 p-2 rounded shadow flex justify-between items-center';
            div.innerHTML = `<span>${c.name}</span><span class="text-gray-500 text-sm">${c.time}</span>`;
            customerList.appendChild(div);
        });
    }

    // Default booth 1
    renderCustomers(1);

    boothSelect.addEventListener('change', function() {
        const booth = this.value;
        pieChart.data.datasets[0].data = chartData[booth];
        pieChart.update();
        renderCustomers(booth);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/dashboard.blade.php ENDPATH**/ ?>