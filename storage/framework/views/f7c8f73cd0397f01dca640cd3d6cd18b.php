<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Photo Studio</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/Customer/style.css')); ?>"> 
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            
            <div class="login-header">
                <div class="login-logo-wrapper">
                <img src="<?php echo e(asset('images/logocamera.png')); ?>" alt="Logo" class="login-logo-img"> </div>
                <h1 class="login-title">Login</h1>
                <p class="login-subtitle">Customer Panel - FlashFrame</p> 
            </div>
            
            <form action="<?php echo e(route('customer.login')); ?>" method="POST">
                <?php echo csrf_field(); ?> <div class="input-group">
                    <label for="username" class="input-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" id="username" name="username" class="input-field" 
                           placeholder="Masukkan Nama Lengkap" required 
                           value="<?php echo e(old('username')); ?>"> </div>
                
                
                <?php if($errors->has('loginError')): ?>
                    <p class="error-message"><?php echo e($errors->first('loginError')); ?></p>
                <?php endif; ?>
                
                <button type="submit" class="btn-login">Masuk</button>
            </form>
            
            
        </div>
    </div>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html><?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/Customer/auth/login.blade.php ENDPATH**/ ?>