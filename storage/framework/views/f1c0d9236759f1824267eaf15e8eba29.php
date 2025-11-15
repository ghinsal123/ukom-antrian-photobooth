
<?php $__env->startSection('title', 'Booth'); ?>

<?php $__env->startSection('content'); ?>
<h2>Data Booth</h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Booth</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>1</td><td>Booth 1</td><td>Tersedia</td><td><button>Edit</button></td></tr>
        <tr><td>2</td><td>Booth 2</td><td>Dipakai</td><td><button>Edit</button></td></tr>
        <tr><td>3</td><td>Booth 3</td><td>Tersedia</td><td><button>Edit</button></td></tr>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/admin/booths/index.blade.php ENDPATH**/ ?>