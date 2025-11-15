

<?php $__env->startSection('title', 'Dashboard Operator'); ?>

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Ringkasan Hari Ini</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <div class="bg-white p-6 shadow rounded-xl text-center">
        <h3 class="font-semibold text-pink-600">Reservasi Hari Ini</h3>
        <p class="text-3xl font-bold mt-2"><?php echo e($reservasiHariIni); ?></p>
    </div>

    <div class="bg-white p-6 shadow rounded-xl text-center">
        <h3 class="font-semibold text-pink-600">Dalam Proses</h3>
        <p class="text-3xl font-bold mt-2"><?php echo e($proses); ?></p>
    </div>

    <div class="bg-white p-6 shadow rounded-xl text-center">
        <h3 class="font-semibold text-pink-600">Selesai</h3>
        <p class="text-3xl font-bold mt-2"><?php echo e($selesai); ?></p>
    </div>

</div>

<h2 class="text-xl font-bold mt-8 mb-3">Daftar Reservasi</h2>

<?php echo $__env->make('operator.reservasi.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/operator/dashboard.blade.php ENDPATH**/ ?>