<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Panel</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="bg-pink-50">

<div class="flex">

    <!-- SIDEBAR FIXED -->
    <nav class="w-60 h-screen bg-white text-gray-900 p-6 shadow-md fixed top-0 left-0">
        <h1 class="font-bold text-2xl mb-6 text-pink-400">Photobooth FlashFrame</h1>
    <ul class="space-y-4 font-medium">
        <li>
            <a href="<?php echo e(url('/operator/dashboard')); ?>" 
            class="mt-12 block <?php echo e(request()->is('operator/dashboard') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400'); ?>">
            Dashboard
            </a>
        </li>
        <li>
            <a href="<?php echo e(url('/operator/jadwal')); ?>" 
            class="block <?php echo e(request()->is('operator/jadwal') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400'); ?>">
            Jadwal
            </a>
        </li>
        <li>
            <a href="<?php echo e(url('/operator/paket')); ?>" 
            class="block <?php echo e(request()->is('operator/paket') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400'); ?>">
            Paket
            </a>
        </li>
                <li>
            <a href="<?php echo e(url('/operator/booth')); ?>" 
            class="block <?php echo e(request()->is('operator/booth') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400'); ?>">
            Booth
            </a>
        </li>
        <li>
            <hr class="my-2 border-gray-800">
            <a href="<?php echo e(url('/operator/antrian')); ?>" 
            class="block <?php echo e(request()->is('operator/antrian') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400'); ?>">
            Antrian
            </a>
        </li>
        <li>
            <a href="<?php echo e(url('/operator/laporan')); ?>" 
            class="block <?php echo e(request()->is('operator/laporan') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400'); ?>">
            Laporan
            </a>
        </li>
        <li>
           <!-- Link / Button Logout -->
            <hr class=" border-gray-800">
            <a href="<?php echo e(route('operator.logout')); ?>"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="w-full text-red-500 hover:text-red-700 py-3 rounded-xl font-semibold block text-left">
                Logout 
            </a>

            <!-- Form POST tersembunyi -->
            <form id="logout-form" action="<?php echo e(route('operator.logout')); ?>" method="POST" class="hidden">
                <?php echo csrf_field(); ?>
            </form>
        </li>
    </ul>
    </nav>

    <!-- CONTENT -->
    <div class="flex-1 p-6 ml-60"> 
        <?php echo $__env->yieldContent('content'); ?>
    </div>

</div>

</body>
<?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/layout.blade.php ENDPATH**/ ?>