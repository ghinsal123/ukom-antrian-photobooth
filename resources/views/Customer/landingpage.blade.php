<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FlashFrame Photobooth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- SWIPER (UNTUK SLIDER) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="bg-cover bg-center bg-no-repeat bg-fixed min-h-screen"
      style="background-image: url('/image/bg.jpg');">

    <!-- PINK OVERLAY -->
    <div class="absolute inset-0 bg-pink-50/60"></div>

    <!-- CONTENT WRAPPER -->
    <div class="relative z-10 flex flex-col min-h-screen">

        <!-- NAVBAR YANG DIPERBAIKI -->
        <nav class="bg-white shadow-md sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo dan Nama Merek -->
                    <div class="flex items-center">
                        <img src="/images/logo.png" alt="FlashFrame Logo" class="h-8 w-8 mr-2">
                        <span class="text-xl font-bold text-pink-600">FlashFrame</span>
                    </div>

                    <!-- Menu Tengah -->
                    <div class="hidden lg:flex items-center space-x-6 mx-auto">
                        <a href="{{ route('customer.landingpage') }}" 
                           class="text-gray-700 hover:text-pink-500 transition-colors {{ request()->routeIs('customer.landingpage') ? 'text-pink-500 font-medium' : '' }}">
                            Home
                        </a>
                        <a href="#booth" 
                           class="text-gray-700 hover:text-pink-500 transition-colors">
                            Booth
                        </a>
                        <a href="#paket" 
                           class="text-gray-700 hover:text-pink-500 transition-colors">
                            Paket
                        </a>
                        
                        <!-- PERUBAHAN: Menu Antrian mengarah ke section antrian di landing page -->
                        @if ($pengguna)
                            <a href="#antrian" 
                               class="text-gray-700 hover:text-pink-500 transition-colors">
                                Antrian
                            </a>
                        @endif
                        
                        <a href="#tentang" 
                           class="text-gray-700 hover:text-pink-500 transition-colors">
                            Tentang
                        </a>
                    </div>

                    <!-- Bagian Login/Register atau Foto Profil -->
                    <div class="flex items-center space-x-4">
                        @if (!$pengguna)
                            <!-- JIKA BELUM LOGIN -->
                            <a href="{{ route('customer.login') }}" 
                               class="text-gray-700 hover:text-pink-500">
                                Masuk
                            </a>
                            <a href="{{ route('customer.daftar') }}"
                               class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                                Daftar
                            </a>
                        @else
                            <!-- JIKA SUDAH LOGIN -->
                            <div class="flex items-center space-x-4">
                                <!-- TOMBOL +ANTRIAN HANYA SATU DI SINI -->
                                <a href="{{ route('customer.antrian') }}" 
                                   class="hidden md:flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    + Antrian
                                </a>
                                
                                <!-- FOTO PROFIL - LOGIKA DIPERBAIKI -->
                                <div class="relative group">
                                    <button class="flex items-center focus:outline-none">
                                        @if(!empty($pengguna->foto_profil))
                                            <!-- Coba berbagai cara untuk menampilkan foto -->
                                            @php
                                                // Logika untuk menentukan path foto
                                                $fotoPath = null;
                                                
                                                // Coba cek di storage Laravel
                                                if (strpos($pengguna->foto_profil, 'storage/') === 0) {
                                                    $relativePath = str_replace('storage/', '', $pengguna->foto_profil);
                                                    $fotoPath = Storage::exists($relativePath) ? asset('storage/' . $relativePath) : null;
                                                } 
                                                // Coba path langsung
                                                elseif (file_exists(public_path($pengguna->foto_profil))) {
                                                    $fotoPath = asset($pengguna->foto_profil);
                                                }
                                                // Coba path dari database langsung
                                                elseif (Storage::exists($pengguna->foto_profil)) {
                                                    $fotoPath = asset('storage/' . $pengguna->foto_profil);
                                                }
                                            @endphp
                                            
                                            @if($fotoPath)
                                                <img src="{{ $fotoPath }}" 
                                                     alt="Profil"
                                                     class="w-8 h-8 rounded-full object-cover border-2 border-pink-300 hover:border-pink-500 transition-colors"
                                                     onerror="this.onerror=null; this.src='/images/default-avatar.jpg';">
                                            @else
                                                <!-- Fallback ke avatar default jika foto tidak ditemukan -->
                                                <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center border-2 border-pink-300 hover:border-pink-500 transition-colors">
                                                    {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                                </div>
                                            @endif
                                        @else
                                            <!-- Tidak ada foto profil, tampilkan inisial -->
                                            <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center border-2 border-pink-300 hover:border-pink-500 transition-colors font-bold">
                                                {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-pink-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                        <div class="py-2">
                                            <!-- Info Pengguna -->
                                            <div class="px-4 py-3 border-b border-pink-50">
                                                <p class="text-sm font-medium text-gray-800 truncate">{{ $pengguna->nama_pengguna ?? 'User' }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $pengguna->email ?? '' }}</p>
                                            </div>
                                            
                                            <a href="{{ route('customer.profil.edit') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Profil Saya
                                            </a>
                                            <a href="{{ route('customer.antrian') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                Antrian Saya
                                            </a>
                                            <a href="{{ route('customer.arsip') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                                Arsip Foto
                                            </a>
                                            
                                            <!-- TOMBOL +ANTRIAN MOBILE - HANYA DI SINI UNTUK MOBILE -->
                                            <a href="{{ route('customer.antrian') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-pink-600 font-medium hover:bg-pink-50 hover:text-pink-700 md:hidden border-t border-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                + Buat Antrian
                                            </a>
                                            
                                            <!-- Logout -->
                                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                                                @csrf
                                            </form>
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 border-t border-gray-100">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Keluar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Menu Mobile -->
                    <button class="lg:hidden text-2xl text-pink-500 ml-4" onclick="toggleMenu()">
                        ☰
                    </button>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div id="mobileMenu" class="hidden lg:hidden bg-white border-t px-4 py-3">
                <div class="space-y-2">
                    <a href="{{ route('customer.landingpage') }}" class="block py-2 text-gray-700 hover:text-pink-500 {{ request()->routeIs('customer.landingpage') ? 'text-pink-500 font-medium' : '' }}">Home</a>
                    <a href="#booth" onclick="closeMobileMenu(); scrollToSection('booth');" class="block py-2 text-gray-700 hover:text-pink-500">Booth</a>
                    <a href="#paket" onclick="closeMobileMenu(); scrollToSection('paket');" class="block py-2 text-gray-700 hover:text-pink-500">Paket</a>
                    
                    @if ($pengguna)
                        <!-- Di mobile, "Antrian" juga mengarah ke section antrian -->
                        <a href="#antrian" onclick="closeMobileMenu(); scrollToSection('antrian');" class="block py-2 text-gray-700 hover:text-pink-500">Antrian</a>
                    @endif
                    
                    <a href="#tentang" onclick="closeMobileMenu(); scrollToSection('tentang');" class="block py-2 text-gray-700 hover:text-pink-500">Tentang</a>

                    @if (!$pengguna)
                        <div class="pt-3 border-t mt-3">
                            <a href="{{ route('customer.login') }}" class="block py-2 text-gray-700 hover:text-pink-500">Masuk</a>
                            <a href="{{ route('customer.daftar') }}" class="block py-2 text-pink-600 font-medium hover:text-pink-700">Daftar</a>
                        </div>
                    @else
                        <div class="pt-3 border-t mt-3">
                            <!-- Header Profil Mobile -->
                            <div class="flex items-center gap-3 mb-3 p-2 bg-pink-50 rounded-lg">
                                @if(!empty($pengguna->foto_profil))
                                    @php
                                        // Logika yang sama untuk mobile
                                        $fotoPathMobile = null;
                                        
                                        if (strpos($pengguna->foto_profil, 'storage/') === 0) {
                                            $relativePath = str_replace('storage/', '', $pengguna->foto_profil);
                                            $fotoPathMobile = Storage::exists($relativePath) ? asset('storage/' . $relativePath) : null;
                                        } 
                                        elseif (file_exists(public_path($pengguna->foto_profil))) {
                                            $fotoPathMobile = asset($pengguna->foto_profil);
                                        }
                                        elseif (Storage::exists($pengguna->foto_profil)) {
                                            $fotoPathMobile = asset('storage/' . $pengguna->foto_profil);
                                        }
                                    @endphp
                                    
                                    @if($fotoPathMobile)
                                        <img src="{{ $fotoPathMobile }}" 
                                             alt="Profil"
                                             class="w-10 h-10 rounded-full object-cover border border-pink-300"
                                             onerror="this.onerror=null; this.src='/images/default-avatar.jpg';">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold">
                                            {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                        </div>
                                    @endif
                                @else
                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold">
                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-sm">{{ $pengguna->nama_pengguna ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500">{{ $pengguna->email ?? '' }}</p>
                                </div>
                            </div>
                            
                            <!-- Menu Profil Mobile -->
                            <a href="{{ route('customer.profil.edit') }}" class="flex items-center py-2 text-gray-700 hover:text-pink-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('customer.antrian') }}" class="flex items-center py-2 text-gray-700 hover:text-pink-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Antrian Saya
                            </a>
                            <a href="{{ route('customer.arsip') }}" class="flex items-center py-2 text-gray-700 hover:text-pink-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Arsip Foto
                            </a>
                            
                            <!-- TOMBOL +ANTRIAN MOBILE - TIDAK DOUBLE -->
                            <a href="{{ route('customer.antrian') }}" class="flex items-center py-2 text-pink-600 font-medium hover:text-pink-700 mt-2 border-t pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                + Buat Antrian
                            </a>
                            
                            <!-- Logout -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center py-2 text-red-600 hover:text-red-700 mt-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <script>
            function toggleMenu() {
                document.getElementById('mobileMenu').classList.toggle('hidden');
            }
            
            function closeMobileMenu() {
                document.getElementById('mobileMenu').classList.add('hidden');
            }
            
            function scrollToSection(sectionId) {
                const section = document.getElementById(sectionId);
                if (section) {
                    setTimeout(() => {
                        section.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            }
        </script>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-grow w-full">

            <!-- ========================= -->
            <!--       MAIN POSTER        -->
            <!-- ========================= -->
            <div class="w-full">
                <div class="mx-auto">
                    <img src="/images/PHOTOBOOTH.png"
                         class="w-full h-auto max-h-[700px] object-cover rounded-xl">
                </div>
            </div>

            <!-- ========================= -->
            <!--       SLIDER BOOTH       -->
            <!-- ========================= -->
            <div id="booth" class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Booth Tersedia</h3>
                    <p class="text-gray-600 mb-6">Pilih booth favorit Anda untuk pengalaman fotografi terbaik</p>

                    <div class="swiper booth-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($booth as $b)
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-xl shadow-lg border border-pink-200 h-full flex flex-col overflow-hidden">
                                        <!-- Gambar Booth -->
                                        <div class="relative">
                                            <img src="{{ $b->gambar ? asset('storage/' . $b->gambar) : '/images/default-booth.jpg' }}" 
                                                 alt="{{ $b->nama_booth }}"
                                                 class="w-full h-48 object-cover rounded-t-xl">
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-block px-3 py-1 bg-pink-500 text-white rounded-full text-xs font-medium">
                                                    {{ $b->antrian->count() }} Antrian
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Konten Booth -->
                                        <div class="p-4 flex-1 flex flex-col">
                                            <h4 class="font-bold text-lg text-pink-600 mb-3">{{ $b->nama_booth }}</h4>
                                            
                                            <!-- Info Kapasitas -->
                                            <div class="flex items-center text-gray-600 mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span class="text-sm font-medium">Maksimal {{ $b->kapasitas ?? '4' }} orang</span>
                                            </div>
                                            
                                            <!-- Aksi -->
                                            <div class="mt-auto">
                                                @if ($pengguna)
                                                    <a href="{{ route('customer.antrian') }}?booth_id={{ $b->id }}"
                                                       class="w-full block text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                                                        Pesan Sekarang
                                                    </a>
                                                @else
                                                    <a href="{{ route('customer.daftar') }}" 
                                                       class="w-full block text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                                                        Order
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination mt-6"></div>
                    </div>
                </div>
            </div>

            <!-- ========================= -->
            <!--      SLIDER PAKET        -->
            <!-- ========================= -->
            <div id="paket" class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Paket Foto</h3>
                    <p class="text-gray-600 mb-6">Berbagai pilihan paket sesuai kebutuhan Anda</p>

                    <div class="swiper paket-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($paket as $p)
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-xl shadow-lg border border-pink-200 h-full flex flex-col overflow-hidden">
                                        <!-- Gambar Paket -->
                                        <div class="relative">
                                            <img src="{{ $p->gambar ? asset('storage/' . $p->gambar) : '/images/default-paket.jpg' }}" 
                                                 alt="{{ $p->nama_paket }}"
                                                 class="w-full h-48 object-cover rounded-t-xl">
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                    Popular
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Konten Paket -->
                                        <div class="p-4 flex-1 flex flex-col">
                                            <h4 class="font-bold text-lg text-pink-600 mb-2">{{ $p->nama_paket }}</h4>
                                            
                                            <!-- Info Durasi -->
                                            <div class="flex items-center text-gray-600 mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-sm">10 menit</span>
                                            </div>
                                            
                                            <!-- Deskripsi Singkat -->
                                            <p class="text-gray-600 text-sm mb-4 flex-grow">
                                                {{ $p->deskripsi ?? 'Paket foto berkualitas tinggi dengan hasil terbaik untuk moment spesial Anda.' }}
                                            </p>
                                            
                                            <!-- Harga -->
                                            <div class="mb-4">
                                                <p class="text-lg font-bold text-pink-700">Rp{{ number_format($p->harga, 0, ',', '.') }}</p>
                                            </div>
                                            
                                            <!-- Aksi -->
                                            <div class="mt-auto">
                                                @if ($pengguna)
                                                    <a href="{{ route('customer.antrian') }}?paket_id={{ $p->id }}"
                                                       class="w-full block text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                                                        Pilih Paket
                                                    </a>
                                                @else
                                                    <a href="{{ route('customer.daftar') }}" 
                                                       class="w-full block text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                                                        Order
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination mt-6"></div>
                    </div>
                </div>
            </div>

            <!-- ========================= -->
            <!--    DAFTAR ANTRIAN UMUM   -->
            <!-- ========================= -->
            <div id="antrian" class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Antrian Saat Ini</h3>
                    <p class="text-gray-600 mb-6">Lihat antrian yang sedang berlangsung</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($booth as $b)
                            @if($b->antrian->where('status', 'proses')->count() > 0)
                                <div class="bg-white border border-pink-200 rounded-xl shadow-lg p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-bold text-lg text-pink-600">{{ $b->nama_booth }}</h4>
                                        <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-medium">
                                            {{ $b->antrian->where('status', 'proses')->count() }} Sedang Antri
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        @foreach($b->antrian->where('status', 'proses')->take(5) as $antrian)
                                            <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center">
                                                        <span class="text-white text-sm font-bold">#{{ $antrian->nomor_antrian }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="font-medium text-gray-800">{{ $antrian->pengguna->nama_pengguna ?? 'Customer' }}</p>
                                                        <p class="text-xs text-gray-600">{{ $antrian->paket->nama_paket }}</p>
                                                    </div>
                                                </div>
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">
                                                    Menunggu
                                                </span>
                                            </div>
                                        @endforeach
                                        
                                        @if($b->antrian->where('status', 'proses')->count() > 5)
                                            <div class="text-center text-pink-600 text-sm font-medium">
                                                +{{ $b->antrian->where('status', 'proses')->count() - 5 }} antrian lainnya...
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($booth->sum(function($b) { return $b->antrian->where('status', 'proses')->count(); }) == 0)
                        <div class="bg-white border border-pink-200 p-8 rounded-xl shadow-lg text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 text-lg mb-2">Tidak ada antrian saat ini</p>
                            <p class="text-gray-500 text-sm">
                                Silakan ambil nomor antrian untuk menjadi yang pertama!
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ========================= -->
            <!--    DAFTAR ANTRIAN SAYA   -->
            <!-- ========================= -->
            @if ($pengguna)
                <div class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                    <div class="max-w-7xl mx-auto">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6">Antrian Saya</h3>

                        @if (count($antrianku) == 0)
                            <div class="bg-white border border-pink-200 p-8 rounded-xl shadow-lg text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-600 text-lg mb-2">Belum ada antrian</p>
                                <p class="text-gray-500 text-sm mb-6">
                                    Silakan hubungi admin untuk membuat pesanan antrian baru
                                </p>
                                <div class="bg-pink-50 border border-pink-200 rounded-lg p-4 text-left">
                                    <p class="text-sm text-pink-700 font-medium mb-2">📞 Hubungi Admin:</p>
                                    <p class="text-xs text-pink-600">WhatsApp: 08xx-xxxx-xxxx</p>
                                    <p class="text-xs text-pink-600">Instagram: @flashframe.photo</p>
                                </div>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($antrianku as $item)
                                    <div class="bg-white border border-pink-200 p-6 rounded-xl shadow hover:shadow-lg transition-shadow duration-300">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-3">
                                                    <span class="text-2xl font-bold text-pink-600">#{{ $item->nomor_antrian }}</span>
                                                    <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-medium">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </div>
                                                
                                                <!-- Informasi User -->
                                                <div class="mb-4">
                                                    <p class="text-lg font-semibold text-gray-800">
                                                        {{ $item->pengguna->nama_pengguna ?? 'User' }}
                                                    </p>
                                                </div>
                                                
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                                    <p class="text-gray-700">
                                                        <span class="font-medium">Booth:</span> {{ $item->booth->nama_booth }}
                                                    </p>
                                                    <p class="text-gray-700">
                                                        <span class="font-medium">Paket:</span> {{ $item->paket->nama_paket }}
                                                    </p>
                                                    <p class="text-gray-700">
                                                        <span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                                    </p>
                                                    <p class="text-gray-700">
                                                        <span class="font-medium">Waktu:</span> {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="sm:text-right">
                                                @if($item->status == 'proses')
                                                    <span class="inline-block px-3 py-2 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-medium">
                                                        Menunggu
                                                    </span>
                                                @elseif($item->status == 'selesai')
                                                    <span class="inline-block px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-medium">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="inline-block px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- ========================= -->
            <!--       TENTANG KAMI       -->
            <!-- ========================= -->
            <div id="tentang" class="w-full px-4 sm:px-6 lg:px-8 mt-16 mb-16">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg border border-pink-200 p-8">
                        <div class="text-center mb-8">
                            <h3 class="text-3xl font-bold text-pink-600 mb-4">Tentang FlashFrame Photobooth</h3>
                            <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                                Menghadirkan pengalaman fotografi yang menyenangkan dan mengelola antrian secara efesien.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800 mb-2">Kualitas Terbaik</h4>
                                <p class="text-gray-600 text-sm">
                                 Memiliki paket photo dan booth yang lucu dan menarik.
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800 mb-2">Cepat & Efisien</h4>
                                <p class="text-gray-600 text-sm">
                                    Proses pemotretan yang cepat dengan sistem antrian yang terorganisir
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800 mb-2">Ramah Keluarga</h4>
                                <p class="text-gray-600 text-sm">
                                    Cocok untuk semua usia, dari anak-anak hingga orang dewasa
                                </p>
                            </div>
                        </div>

                        <div class="bg-pink-50 border border-pink-200 rounded-xl p-6">
                            <h4 class="font-bold text-lg text-pink-700 mb-4">📞 Hubungi Kami</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-pink-600 font-medium mb-1">WhatsApp</p>
                                    <p class="text-gray-700">+62 812-3456-7890</p>
                                </div>
                                <div>
                                    <p class="text-sm text-pink-600 font-medium mb-1">Instagram</p>
                                    <p class="text-gray-700">@flashframe.photo</p>
                                </div>
                                <div>
                                    <p class="text-sm text-pink-600 font-medium mb-1">Email</p>
                                    <p class="text-gray-700">flashframe@gmail.com</p>
                                </div>
                                <div>
                                    <p class="text-sm text-pink-600 font-medium mb-1">Lokasi</p>
                                    <p class="text-gray-700">Jl. Photobooth No. 123, Bekasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </div>

    <!-- SWIPER SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Inisialisasi semua swiper
        document.addEventListener('DOMContentLoaded', function() {
            // Booth Swiper
            new Swiper('.booth-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { 
                        slidesPerView: 1.5,
                        spaceBetween: 20
                    },
                    768: { 
                        slidesPerView: 2.2,
                        spaceBetween: 25
                    },
                    1024: { 
                        slidesPerView: 2.8,
                        spaceBetween: 30
                    },
                    1280: { 
                        slidesPerView: 3.2,
                        spaceBetween: 30
                    }
                }
            });

            // Paket Swiper
            new Swiper('.paket-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { 
                        slidesPerView: 1.5,
                        spaceBetween: 20
                    },
                    768: { 
                        slidesPerView: 2.2,
                        spaceBetween: 25
                    },
                    1024: { 
                        slidesPerView: 2.8,
                        spaceBetween: 30
                    },
                    1280: { 
                        slidesPerView: 3.2,
                        spaceBetween: 30
                    }
                }
            });
        });

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

</body>
</html>