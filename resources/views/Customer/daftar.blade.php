<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | FlashFrame</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Card Utama -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo" 
                     class="w-20 h-20 mx-auto mb-3">
                <h1 class="text-xl font-bold text-pink-500">Daftar Akun</h1>
                <p class="text-gray-500 text-sm mt-1">Buat akun untuk mulai</p>
            </div>

            <!-- Error/Success Messages -->
            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            
            @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('customer.daftar.submit') }}" method="POST" class="space-y-4" id="registerForm">
                @csrf
                
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" 
                           name="nama_pengguna" 
                           value="{{ old('nama_pengguna') }}" 
                           required 
                           placeholder="Masukkan nama lengkap"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none placeholder-gray-400">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="Masukkan email anda"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none placeholder-gray-400">
                </div>

                <!-- No. Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">
                            +62
                        </span>
                        <input type="text" 
                               name="no_telepon_raw" 
                               id="no_telepon_raw"
                               value="{{ old('no_telepon') ? str_replace('+62', '', old('no_telepon')) : '' }}"
                               placeholder="08xxxxxx" 
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none placeholder-gray-400">
                    </div>
                    
                    <input type="hidden" 
                           name="no_telepon" 
                           id="no_telepon_formatted"
                           value="{{ old('no_telepon') }}">
                    <p class="text-xs text-red-500 mt-1 hidden" id="phoneError">Nomor telepon harus 9-13 digit</p>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="password"
                               required 
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none placeholder-gray-400">
                        
                        <!-- Icon Mata (SVG) -->
                        <button type="button" 
                                id="togglePassword" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition focus:outline-none">
                            <!-- Eye Icon (Show Password - Mata Terbuka) -->
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            
                            <!-- Eye Slash Icon (Hide Password - Mata Tertutup) - Hidden by default -->
                            <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 015 12c-1.274 4.057-5.064 7-9.542 7 4.477 0 8.268-2.943 9.542-7 0-.195-.002-.39-.008-.584"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-red-500 mt-1 hidden" id="passwordError">Password harus minimal 8 karakter</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2.5 rounded-lg transition mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Link ke Login -->
            <div class="text-center mt-6 pt-4 border-t">
                <p class="text-gray-600 text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('customer.login') }}" class="text-pink-500 hover:text-pink-600 font-medium">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Format nomor telepon
        function formatPhoneNumber() {
            const rawInput = document.getElementById('no_telepon_raw');
            const formattedInput = document.getElementById('no_telepon_formatted');
            const errorElement = document.getElementById('phoneError');
            
            // Bersihkan angka
            let cleanNumber = rawInput.value.replace(/[^0-9]/g, '');
            
            // Hapus angka 0 di depan
            if (cleanNumber.startsWith('0')) {
                cleanNumber = cleanNumber.substring(1);
            }
            
            // Update input display
            rawInput.value = cleanNumber;
            
            // Update input hidden 
            formattedInput.value = '+62' + cleanNumber;
            
            // Validasi panjang
            if (cleanNumber.length > 0 && (cleanNumber.length < 9 || cleanNumber.length > 13)) {
                errorElement.classList.remove('hidden');
                return false;
            } else {
                errorElement.classList.add('hidden');
                return true;
            }
        }
        
        // Toggle show/hide password - YANG SUDAH DIPERBAIKI
        function setupPasswordToggle() {
            const toggleButton = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');
            
            if (toggleButton && passwordInput && eyeIcon && eyeSlashIcon) {
                toggleButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // LOGIKA YANG BENAR:
                    // Password terlihat (type="text") -> Tampilkan icon mata tertutup (eye-slash)
                    // Password tersembunyi (type="password") -> Tampilkan icon mata terbuka (eye)
                    if (type === 'text') {
                        // Password terlihat, user mau sembunyikan -> icon mata tertutup
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                    } else {
                        // Password tersembunyi, user mau lihat -> icon mata terbuka
                        eyeIcon.classList.remove('hidden');
                        eyeSlashIcon.classList.add('hidden');
                    }
                });
                
                // Pastikan state awal benar
                if (passwordInput.getAttribute('type') === 'password') {
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            }
        }
        
        // Validasi sebelum submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const passwordError = document.getElementById('passwordError');
            let isValid = true;
            
            // Validasi password
            if (password.value.length < 8) {
                passwordError.classList.remove('hidden');
                isValid = false;
            } else {
                passwordError.classList.add('hidden');
            }
            
            // Validasi nomor telepon
            if (!formatPhoneNumber()) {
                isValid = false;
            }
            
            // Cek semua valid
            if (!isValid) {
                e.preventDefault();
                
                // Fokus ke field yang error
                if (password.value.length < 8) {
                    password.focus();
                    setTimeout(() => {
                        alert('Password harus minimal 8 karakter!');
                    }, 100);
                } else {
                    document.getElementById('no_telepon_raw').focus();
                    setTimeout(() => {
                        alert('Nomor telepon harus 9-13 digit angka!');
                    }, 100);
                }
            }
        });
        
        // Format nomor telepon saat input berubah
        document.getElementById('no_telepon_raw').addEventListener('input', formatPhoneNumber);
        
        // Initialize saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Format nomor telepon awal
            formatPhoneNumber();
            
            // Setup toggle password
            setupPasswordToggle();
            
            // Auto focus ke field yang error (tanpa Blade di JavaScript)
            const errorFields = {
                'nama_pengguna': document.querySelector('input[name="nama_pengguna"]'),
                'email': document.querySelector('input[name="email"]'),
                'no_telepon': document.getElementById('no_telepon_raw'),
                'password': document.getElementById('password')
            };
            
            // Cek error dari class border merah (jika ada)
            if (errorFields.nama_pengguna && errorFields.nama_pengguna.classList.contains('border-red-300')) {
                errorFields.nama_pengguna.focus();
            } else if (errorFields.email && errorFields.email.classList.contains('border-red-300')) {
                errorFields.email.focus();
            } else if (errorFields.no_telepon && (errorFields.no_telepon.classList.contains('border-red-300') || document.querySelector('.border-red-300'))) {
                errorFields.no_telepon.focus();
            } else if (errorFields.password && errorFields.password.classList.contains('border-red-300')) {
                errorFields.password.focus();
            }
        });
    </script>
</body>
</html>