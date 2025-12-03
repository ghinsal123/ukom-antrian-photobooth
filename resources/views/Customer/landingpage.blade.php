<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FlashFrame Photobooth</title>
    @vite('resources/css/app.css')
    
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
                        <img src="/images/logo.png" alt="FlashFrame Logo" class="h-10 w-10 mr-3">
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
                        
                        <!-- Menu Antrian mengarah ke section antrian di landing page -->
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
                                <!-- TOMBOL TAMBAH ANTRIAN (TANPA +) -->
                                <a href="{{ route('customer.antrian') }}" 
                                   class="hidden md:flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Antrian
                                </a>
                                
                                <!-- FOTO PROFIL ATAU AVATAR -->
                                <div class="relative group">
                                    <button class="flex items-center focus:outline-none">
                                        @if($pengguna->foto)
                                            <!-- Jika ada foto profil -->
                                            <img src="{{ asset('storage/' . $pengguna->foto) }}" 
                                                alt="Foto Profil {{ $pengguna->nama_pengguna }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-pink-300 hover:border-pink-500 transition-colors"
                                                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            
                                            <!-- Fallback avatar jika gambar error -->
                                            <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center border-2 border-pink-300 hover:border-pink-500 transition-colors font-bold hidden">
                                                {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                            </div>
                                        @else
                                            <!-- Jika tidak ada foto profil, tampilkan avatar -->
                                            <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center border-2 border-pink-300 hover:border-pink-500 transition-colors font-bold">
                                                {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-pink-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                        <div class="py-2">
                                            <!-- Info Pengguna dengan Foto -->
                                            <div class="px-4 py-3 border-b border-pink-50 flex items-center space-x-3">
                                                @if($pengguna->foto)
                                                    <img src="{{ asset('storage/' . $pengguna->foto) }}" 
                                                        alt="Foto Profil"
                                                        class="w-10 h-10 rounded-full object-cover border border-pink-300"
                                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    
                                                    <!-- Fallback avatar -->
                                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold hidden">
                                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold">
                                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $pengguna->nama_pengguna ?? 'User' }}</p>
                                                    <p class="text-xs text-gray-500 truncate">{{ $pengguna->email ?? '' }}</p>
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('customer.profil.edit') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Edit Profil
                                            </a>
                                            <a href="{{ route('customer.arsip') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                                Arsip 
                                            </a>
                                            
                                            <!-- TOMBOL TAMBAH ANTRIAN MOBILE -->
                                            <a href="{{ route('customer.antrian') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-pink-600 font-medium hover:bg-pink-50 hover:text-pink-700 md:hidden border-t border-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Antrian
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
                            <!-- Header Profil Mobile dengan Foto -->
                            <div class="flex items-center gap-3 mb-3 p-2 bg-pink-50 rounded-lg">
                                @if($pengguna->foto)
                                    <img src="{{ asset('storage/' . $pengguna->foto) }}" 
                                         alt="Foto Profil"
                                         class="w-10 h-10 rounded-full object-cover border border-pink-300"
                                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    
                                    <!-- Fallback avatar -->
                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold hidden">
                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                    </div>
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
                            
                            <!-- TOMBOL TAMBAH ANTRIAN MOBILE -->
                            <a href="{{ route('customer.antrian') }}" class="flex items-center py-2 text-pink-600 font-medium hover:text-pink-700 mt-2 border-t pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Antrian
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
            <div id="tentang" class="w-full px-4 sm:px-6 lg:px-8 mt-16 mb-8">
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
                    </div>
                </div>
            </div>

        </main>

        <!-- FOOTER YANG DIKECILKAN DAN WARNA #f9f0df -->
        <footer class="bg-[#f9f0df] text-gray-800 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- HUBUNGI KAMI SECTION - DIKECILKAN -->
                <div class="mb-6">
                    <h4 class="text-xl font-bold mb-6 text-center text-gray-800">Hubungi Kami</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- WhatsApp -->
                        <div class="text-center">
                            <div class="w-12 h-12 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.675-.236-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.436 9.884-9.884 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mb-1">WhatsApp</p>
                            <p class="text-gray-800 font-medium text-sm">+62 812-3456-7890</p>
                        </div>
                        
                        <!-- Instagram -->
                        <div class="text-center">
                            <div class="w-12 h-12 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Instagram</p>
                            <p class="text-gray-800 font-medium text-sm">@flashframe.photo</p>
                        </div>
                        
                        <!-- Email -->
                        <div class="text-center">
                            <div class="w-12 h-12 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Email</p>
                            <p class="text-gray-800 font-medium text-sm">flashframe@gmail.com</p>
                        </div>
                        
                        <!-- Lokasi -->
                        <div class="text-center">
                            <div class="w-12 h-12 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Lokasi</p>
                            <p class="text-gray-800 font-medium text-sm">Jl. Photobooth No. 123, Bekasi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Copyright - DIKECILKAN -->
                <div class="border-t border-[#e0d6c4] pt-6 mt-6 text-center">
                    <div class="flex items-center justify-center mb-3">
                        <img src="/images/logo.png" alt="FlashFrame Logo" class="h-12 w-12 mr-3">
                        <span class="text-lg font-bold text-gray-800">FlashFrame Photobooth</span>
                    </div>
                    <p class="text-gray-600 text-xs">© 2024 FlashFrame.</p>
                </div>
            </div>
        </footer>

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