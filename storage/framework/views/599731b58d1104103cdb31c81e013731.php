<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-4">Tambah Antrian</h2>

<form action="<?php echo e(route('operator.antrian.store')); ?>" method="POST" class="bg-white p-5 shadow rounded">
    <?php echo csrf_field(); ?>

    
    <div class="mb-3">
        <label class="font-semibold">Pengguna</label>
        <select name="pengguna_id" class="w-full border p-2 rounded">
            <?php $__currentLoopData = $pengguna; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>"><?php echo e($p->nama); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="mb-3">
        <label class="font-semibold">Booth</label>
        <select name="booth_id" class="w-full border p-2 rounded">
            <?php $__currentLoopData = $booth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($b->id); ?>"><?php echo e($b->nama_booth); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="mb-3">
        <label class="font-semibold">Paket</label>
        <select name="paket_id" class="w-full border p-2 rounded">
            <?php $__currentLoopData = $paket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>"><?php echo e($p->nama_paket); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    
    <div class="mb-3">
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded">
    </div>

    
    <div class="mb-3">
        <label class="font-semibold">Catatan</label>
        <textarea name="catatan" class="w-full border p-2 rounded"></textarea>
    </div>

    <button class="bg-pink-500 text-white px-4 py-2 rounded">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/antrian/create.blade.php ENDPATH**/ ?>