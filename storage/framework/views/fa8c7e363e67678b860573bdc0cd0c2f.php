

<?php $__env->startSection('content'); ?>
<h2 class="text-2xl font-bold mb-4">Dashboard Operator</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-6 shadow rounded-xl text-center">
        <h3 class="font-semibold text-pink-600">Reservasi Hari Ini</h3>
        <p class="text-3xl font-bold mt-2">12</p>
    </div>

    <div class="bg-white p-6 shadow rounded-xl text-center">
        <h3 class="font-semibold text-pink-600">Dalam Proses</h3>
        <p class="text-3xl font-bold mt-2">7</p>
    </div>

    <div class="bg-white p-6 shadow rounded-xl text-center">
        <h3 class="font-semibold text-pink-600">Selesai</h3>
        <p class="text-3xl font-bold mt-2">20</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/dashboard.blade.php ENDPATH**/ ?>