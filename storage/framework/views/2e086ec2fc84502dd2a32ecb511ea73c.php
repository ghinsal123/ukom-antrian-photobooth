
<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="cards">
    <div class="card">
        <h3>Total Booth</h3>
        <p>5 Booth</p>
    </div>
    <div class="card">
        <h3>Total Paket</h3>
        <p>8 Paket</p>
    </div>
    <div class="card">
        <h3>Total Akun</h3>
        <p>12 Akun</p>
    </div>
    <div class="card">
        <h3>Laporan Bulan Ini</h3>
        <p>32 Transaksi</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>