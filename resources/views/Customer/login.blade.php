<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FlashFrame</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo" 
                     class="w-20 h-20 mx-auto mb-3">
                <h1 class="text-xl font-bold text-pink-500">Masuk ke Akun</h1>
                <p class="text-gray-500 text-sm mt-1">Masukkan email dan password Anda</p>
            </div>

            <!-- Alert Success -->
            @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <!-- Alert Error Email Not Found -->
            @if ($errors->has('email') && session('error_type') == 'email_not_found')
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                <p class="mb-2">Email belum terdaftar. Silakan daftar terlebih dahulu.</p>
                <p class="text-sm">
                    <a href="{{ route('customer.daftar') }}" 
                       class="text-pink-500 hover:text-pink-600 font-medium underline transition">
                        Daftar di sini
                    </a>
                </p>
            </div>
            @endif

            <!-- Alert Error Wrong Password -->
            @if ($errors->has('password') && session('error_type') == 'wrong_password')
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                Password salah. Silakan coba lagi.
            </div>
            @endif

            <!-- Alert Error Lainnya -->
            @if ($errors->any() && !session('error_type'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                @foreach($errors->all() as $error)
                {{ $error }}
                @endforeach
            </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('customer.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="Email yang didaftarkan"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition placeholder-gray-400
                                  {{ $errors->has('email') && session('error_type') == 'email_not_found' ? 'border-red-300' : '' }}">
                    @if($errors->has('email') && session('error_type') == 'email_not_found')
                    <p class="text-xs text-gray-500 mt-1">Email ini belum terdaftar di sistem kami</p>
                    @endif
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="passwordInput"
                               required 
                               placeholder="Masukkan password Anda"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition placeholder-gray-400
                                      {{ $errors->has('password') && session('error_type') == 'wrong_password' ? 'border-red-300' : '' }}">
                        
                        <!-- Icon Mata (SVG) -->
                        <button type="button" 
                                id="togglePassword" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition focus:outline-none">
                            <!-- Eye Icon (Show Password) -->
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            
                            <!-- Eye Slash Icon (Hide Password) - Hidden by default -->
                            <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 015 12c-1.274 4.057-5.064 7-9.542 7 4.477 0 8.268-2.943 9.542-7 0-.195-.002-.39-.008-.584"></path>
                            </svg>
                        </button>
                    </div>
                    
                    @if($errors->has('password') && session('error_type') == 'wrong_password')
                    <p class="text-xs text-gray-500 mt-1">Password yang dimasukkan salah</p>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2.5 rounded-lg transition">
                    Masuk ke Akun
                </button>
            </form>

            <!-- Link ke Daftar -->
            <div class="text-center mt-6 pt-4 border-t">
                <p class="text-gray-600 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('customer.daftar') }}" class="text-pink-500 hover:text-pink-600 font-medium transition">
                         Daftar disini 
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
    // Toggle show/hide password
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        
        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icons
                if (type === 'text') {
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            });
        }
        
        // Auto focus ke input yang error - FIX TANPA ERROR
        <?php if($errors->has('email')): ?>
            document.querySelector('input[name="email"]').focus();
        <?php elseif($errors->has('password')): ?>
            document.querySelector('input[name="password"]').focus();
        <?php endif; ?>
    });
</script>
</body>
</html>