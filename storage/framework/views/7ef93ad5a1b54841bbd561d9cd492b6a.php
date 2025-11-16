
<?php $__env->startSection('title', 'Paket'); ?>

<?php $__env->startSection('content'); ?>
<h2>Data Paket Foto</h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Paket</th>
            <th>Durasi</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>1</td><td>Paket Silver</td><td>30 Menit</td><td>Rp 50.000</td><td><button>Edit</button></td></tr>
        <tr><td>2</td><td>Paket Gold</td><td>1 Jam</td><td>Rp 100.000</td><td><button>Edit</button></td></tr>
        <tr><td>3</td><td>Paket Diamond</td><td>2 Jam</td><td>Rp 180.000</td><td><button>Edit</button></td></tr>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>