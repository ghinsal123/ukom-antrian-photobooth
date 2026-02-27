<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Antrian - PhotoBooth FlashFrame</title>
    @vite('resources/css/app.css')
    <style>
        .form-header {
            background: white;
            border-bottom: 1px solid #f3f4f6;
            padding: 16px 20px;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .header-content {
            max-width: 6xl;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .back-button:hover {
            background: #f9fafb;
            color: #ec4899;
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }
        
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ec4899;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 0;
            width: 90%;
            max-width: 900px;
            border-radius: 16px;
            animation: slideIn 0.3s;
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
            line-height: 1;
        }

        .close-modal:hover {
            color: #ec4899;
        }

        .gallery-main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
        }

        .gallery-thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .gallery-thumbnail {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s;
        }

        .gallery-thumbnail:hover {
            border-color: #ec4899;
            transform: scale(1.05);
        }

        .gallery-thumbnail.active {
            border-color: #ec4899;
        }

        .booth-close-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(239, 68, 68, 0.9);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .gallery-main-image { height: 250px; }
            .gallery-thumbnails { grid-template-columns: repeat(auto-fill, minmax(70px, 1fr)); }
            .gallery-thumbnail { height: 60px; }
        }
    </style>
</head>
<body class="bg-pink-50 min-h-screen">

    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Modal Gallery Booth -->
    <div id="boothModal" class="modal">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 id="modalBoothTitle" class="text-2xl font-bold text-gray-800"></h2>
                        <p id="modalBoothType" class="text-gray-600 mt-1"></p>
                    </div>
                    <span class="close-modal" onclick="closeBoothModal()">&times;</span>
                </div>
                
                <div class="gallery-container">
                    <img id="mainGalleryImage" class="gallery-main-image" src="" alt="Booth Image">
                    <div id="galleryThumbnails" class="gallery-thumbnails"></div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button onclick="closeBoothModal()" 
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                        Tutup
                    </button>
                    <button onclick="selectBoothFromModal()" 
                            class="px-6 py-3 bg-pink-500 text-white rounded-xl font-semibold hover:bg-pink-600 transition-all">
                        Pilih Booth Ini
                    </button>
                </div>
            </div>
        </div>
    </div>

    <header class="form-header">
        <div class="header-content">
            <a href="{{ route('customer.landingpage') }}" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali 
            </a>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Buat Antrian Baru</h1>
            <p class="text-gray-600">Isi form di bawah untuk membuat antrian PhotoBooth</p>
        </div>

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <form action="{{ route('customer.antrian.store') }}" method="POST" id="antrianForm" class="space-y-6">
            @csrf
            
            <!-- INFORMASI PENGUNJUNG -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12a5 5 0 110-10 5 5 0 010 10zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Informasi Pengunjung
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-3">Nama Lengkap</label>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-medium">
                            {{ $pengguna->nama_pengguna ?? 'Nama tidak ditemukan' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-3">Nomor Telepon</label>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-medium">
                            {{ $pengguna->no_telp ?? 'Telepon tidak ditemukan' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- PILIH PAKET -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                    </svg>
                    Pilih Paket Foto
                </h3>
                <p class="text-gray-600 mb-6">Setiap paket sudah termasuk jumlah strip foto tertentu</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($paket as $p)
                    <div class="border-2 border-gray-200 rounded-xl p-5 hover:border-pink-300 transition-all duration-300 cursor-pointer paket-card group"
                         data-id="{{ $p->id }}"
                         data-name="{{ $p->nama_paket }}"
                         data-harga="{{ $p->harga }}"
                         data-strip="{{ $p->jumlah_strip }}"
                         data-deskripsi="{{ $p->deskripsi }}">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-800 text-lg group-hover:text-pink-500">{{ $p->nama_paket }}</h4>
                                <p class="text-sm text-pink-500 font-medium">{{ $p->jumlah_strip }} strip foto</p>
                            </div>
                            <div class="w-7 h-7 rounded-full border-2 border-gray-300 flex items-center justify-center group-hover:border-pink-500 transition-colors">
                                <div class="w-3.5 h-3.5 rounded-full bg-pink-500 hidden"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            @if($p->gambar && file_exists(public_path('storage/' . $p->gambar)))
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_paket }}" 
                                     class="w-full h-40 object-cover rounded-lg group-hover:scale-[1.02] transition-transform duration-300">
                            @else
                                <div class="w-full h-40 bg-gradient-to-r from-pink-50 to-purple-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm5 12a4 4 0 100-8 4 4 0 000 8zm7-8h3v2h-3V8zm0 4h3v2h-3v-2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <p class="text-xl font-bold text-pink-500">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $p->deskripsi }}</p>
                    </div>
                    @endforeach
                </div>
                
                <div class="error-message" id="paketError">Pilih paket terlebih dahulu</div>
                <input type="hidden" name="paket_id" id="selectedPaketId" value="{{ old('paket_id') }}">
            </div>

            <!-- TAMBAH STRIP OPSIONAL -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hidden" id="tambahStripSection">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Strip Foto (Opsional)
                </h3>
                
                <div class="mb-6">
                    <p class="text-gray-600 mb-4">Ingin menambah strip foto? Harga tambahan: 
                        <span class="font-semibold text-pink-500">Rp 10.000</span> per strip
                    </p>
                    <p class="text-sm text-gray-500">Strip paket: <span id="paketStripCount" class="font-semibold">0</span> strip</p>
                </div>
                
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <button type="button" onclick="decreaseStrip()" 
                                class="w-12 h-12 flex items-center justify-center border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-pink-300 text-gray-700 text-2xl font-light transition-colors">
                            −
                        </button>
                        <div class="text-center">
                            <input type="number" name="tambah_strip" id="tambahStripInput" min="0" max="10" value="0" 
                                   class="w-24 h-12 text-center text-2xl font-bold border-0 bg-transparent" readonly>
                            <p class="text-sm text-gray-500 mt-1">strip tambahan</p>
                        </div>
                        <button type="button" onclick="increaseStrip()" 
                                class="w-12 h-12 flex items-center justify-center border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:border-pink-300 text-gray-700 text-2xl font-light transition-colors">
                            +
                        </button>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600">Biaya tambahan: 
                            <span id="biayaTambahan" class="text-xl font-bold text-pink-500">Rp 0</span>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Total strip: <span id="totalStripCount" class="font-semibold">0</span> strip</p>
                    </div>
                </div>
            </div>

            <!-- PILIH BOOTH -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/>
                    </svg>
                    Pilih Booth Foto
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($booth as $b)
                    <div class="border-2 border-gray-200 rounded-xl p-5 hover:border-pink-300 transition-all duration-300 cursor-pointer booth-card group relative"
                         data-id="{{ $b->id }}"
                         data-name="{{ $b->nama_booth }}"
                         data-images='@json($b->gambar)'
                         data-kapasitas="{{ $b->kapasitas }}">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-800 text-lg group-hover:text-pink-500">{{ $b->nama_booth }}</h4>
                                <p class="text-sm text-gray-500">Kapasitas: {{ $b->kapasitas }} orang</p>
                            </div>
                            <div class="w-7 h-7 rounded-full border-2 border-gray-300 flex items-center justify-center group-hover:border-pink-500 transition-colors">
                                <div class="w-3.5 h-3.5 rounded-full bg-pink-500 hidden"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            @php
                                $gambarArray = [];
                                if (is_string($b->gambar)) {
                                    $decoded = @json_decode($b->gambar, true);
                                    $gambarArray = is_array($decoded) ? $decoded : [];
                                } elseif (is_array($b->gambar)) {
                                    $gambarArray = $b->gambar;
                                }
                                
                                $gambarPertama = count($gambarArray) > 0 ? $gambarArray[0] : null;
                                $gambarPath = $gambarPertama ? 'storage/' . $gambarPertama : null;
                                $gambarExists = $gambarPath && file_exists(public_path($gambarPath));
                            @endphp
                            
                            @if($gambarExists)
                                <img src="{{ asset($gambarPath) }}" alt="{{ $b->nama_booth }}" 
                                     class="w-full h-40 object-cover rounded-lg group-hover:scale-[1.02] transition-transform duration-300">
                            @else
                                <div class="w-full h-40 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="button" 
                                    onclick="event.stopPropagation(); openBoothModal(this.closest('.booth-card'))"
                                    class="flex-1 px-4 py-2 border-2 border-pink-500 text-pink-500 rounded-lg font-medium hover:bg-pink-50 transition-colors">
                                Detail
                            </button>
                            <button type="button"
                                    onclick="selectBooth(this.closest('.booth-card'))"
                                    class="flex-1 px-4 py-2 bg-pink-500 text-white rounded-lg font-medium hover:bg-pink-600 transition-colors">
                                Pilih
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="error-message" id="boothError">Pilih booth terlebih dahulu</div>
                <input type="hidden" name="booth_id" id="selectedBoothId" value="{{ old('booth_id') }}">
            </div>

            <!-- TANGGAL & WAKTU -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z"/>
                    </svg>
                    Pilih Waktu Reservasi
                </h3>
                
                <div class="mb-8">
                    <label class="block text-gray-700 font-medium mb-3">Tanggal Reservasi</label>
                    <div class="relative w-full md:w-1/2">
                        <input type="date" name="tanggal" id="tanggalInput" value="{{ date('Y-m-d') }}" 
                               min="{{ date('Y-m-d') }}" 
                               class="w-full p-4 border-2 border-gray-200 rounded-xl bg-white text-gray-700 font-medium">
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-3">* Reservasi hanya untuk hari ini dan seterusnya</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Pilih Jam (Sesi 10 menit)</label>
                    <p class="text-sm text-gray-500 mb-4">Jam operasional: 09:00 - 21:30</p>
                    
                    <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2 max-h-80 overflow-y-auto p-3 bg-gray-50 rounded-xl" id="timeSlotsContainer">
                        @php
                            $timeSlots = [];
                            $start = strtotime('09:00');
                            $end = strtotime('21:30');
                            
                            while ($start <= $end) {
                                $timeSlots[] = date('H:i', $start);
                                $start = strtotime('+10 minutes', $start);
                            }
                        @endphp
                        
                        @foreach($timeSlots as $time)
                        <button type="button" 
                                class="time-slot p-3 border-2 border-gray-200 rounded-lg text-sm font-medium hover:border-pink-300 hover:bg-pink-50 transition-all duration-200"
                                data-time="{{ $time }}"
                                onclick="selectTimeSlot(this, '{{ $time }}')">
                            {{ $time }}
                        </button>
                        @endforeach
                    </div>
                    
                    <div id="allBookedMessage" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 hidden">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Booth Close</p>
                                <p class="text-sm mt-1">Semua slot waktu untuk booth ini sudah penuh pada tanggal yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="error-message" id="timeError">Pilih waktu terlebih dahulu</div>
                    
                    <div class="flex items-center gap-6 mt-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-pink-500 rounded-full"></span>
                            <span>Terpilih</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-white border-2 border-gray-300 rounded-full"></span>
                            <span>Tersedia</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-gray-300 rounded-full"></span>
                            <span>Tidak Tersedia</span>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="jam" id="selectedTime" value="{{ old('jam') }}">
            </div>

            <!-- RINGKASAN PEMESANAN -->
            <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl shadow-sm p-6 border border-pink-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Ringkasan Pemesanan</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Paket Foto</span>
                        <span class="font-semibold text-gray-800" id="ringkasanPaket">Belum dipilih</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Jumlah Strip</span>
                        <span class="font-semibold text-gray-800" id="ringkasanStrip">-</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Booth</span>
                        <span class="font-semibold text-gray-800" id="ringkasanBooth">Belum dipilih</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200">
                        <span class="text-gray-600">Tanggal & Waktu</span>
                        <span class="font-semibold text-gray-800" id="ringkasanWaktu">-</span>
                    </div>
                </div>
                
                <div class="space-y-3 pt-4 border-t border-gray-200">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga Paket</span>
                        <span class="font-medium text-gray-800" id="hargaPaket">Rp 0</span>
                    </div>
                    <div class="flex justify-between" id="tambahStripRow" style="display: none;">
                        <span class="text-gray-600">Tambah Strip</span>
                        <span class="font-medium text-gray-800" id="hargaTambahan">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold pt-4 border-t border-gray-300">
                        <span class="text-gray-800">Total Pembayaran</span>
                        <span class="text-pink-500" id="totalHarga">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SUBMIT -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-gray-600 text-sm md:text-base text-center md:text-left">
                        Pastikan semua data sudah benar sebelum melanjutkan. 
                        <span class="font-medium text-pink-500">Setelah dikonfirmasi tidak dapat diubah.</span>
                    </p>
                    <button type="submit" id="submitBtn" 
                            class="px-10 py-4 bg-pink-500 text-white rounded-xl font-bold hover:bg-pink-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            disabled>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Antrian Sekarang
                        </span>
                    </button>
                </div>
                <div class="error-message mt-4 text-center" id="formError"></div>
            </div>
        </form>
    </div>

    <script>
        // 🔥 DATA STATE
        let selectedPaket = null;
        let selectedBooth = null;
        let selectedTime = null;
        let tambahStrip = 0;
        const hargaPerStrip = 10000;
        let bookedTimeSlots = [];
        let currentBoothCard = null;
        
        // 🔥 INITIALIZE
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggalInput').value = today;
            
            updateRingkasanWaktu();
            checkFormValidity();
            
            // Event listener untuk perubahan tanggal
            document.getElementById('tanggalInput').addEventListener('change', function() {
                selectedTime = null;
                document.getElementById('selectedTime').value = '';
                
                updateRingkasanWaktu();
                if (selectedBooth) {
                    loadBookedTimeSlots();
                }
                checkFormValidity();
            });
            
            // Form submit handler
            document.getElementById('antrianForm').addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return;
                }
                
                document.getElementById('loadingOverlay').style.display = 'flex';
                
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Memproses...
                    </span>
                `;
            });
        });

        // 🔥 LOAD BOOKED TIME SLOTS (AJAX KE SERVER)
        function loadBookedTimeSlots() {
            const selectedDate = document.getElementById('tanggalInput').value;
            const selectedBoothId = document.getElementById('selectedBoothId').value;
            
            if (!selectedDate || !selectedBoothId) {
                bookedTimeSlots = [];
                initializeTimeSlots();
                return;
            }
            
            fetch(`/customer/antrian/check-availability?tanggal=${selectedDate}&booth_id=${selectedBoothId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                bookedTimeSlots = data.booked_times || [];
                initializeTimeSlots();
                
                // Cek apakah semua slot penuh
                const totalSlots = document.querySelectorAll('.time-slot').length;
                const unavailableSlots = document.querySelectorAll('.time-slot.bg-gray-300').length;
                
                if (totalSlots > 0 && unavailableSlots === totalSlots) {
                    document.getElementById('allBookedMessage').classList.remove('hidden');
                    document.getElementById('timeSlotsContainer').classList.add('opacity-50');
                    
                    // Tambah badge "Booth Close" pada booth card
                    document.querySelectorAll('.booth-card').forEach(card => {
                        if (card.dataset.id === selectedBoothId) {
                            if (!card.querySelector('.booth-close-badge')) {
                                const badge = document.createElement('div');
                                badge.className = 'booth-close-badge';
                                badge.textContent = 'Booth Close';
                                card.appendChild(badge);
                            }
                        }
                    });
                } else {
                    document.getElementById('allBookedMessage').classList.add('hidden');
                    document.getElementById('timeSlotsContainer').classList.remove('opacity-50');
                    
                    // Hapus badge "Booth Close"
                    document.querySelectorAll('.booth-close-badge').forEach(badge => {
                        badge.remove();
                    });
                }
            })
            .catch(error => {
                console.error('Error loading booked time slots:', error);
                bookedTimeSlots = [];
                initializeTimeSlots();
            });
        }

        // Paket Selection
        document.querySelectorAll('.paket-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.paket-card').forEach(c => {
                    c.classList.remove('border-pink-500', 'bg-pink-50');
                    c.querySelector('.w-3\\.5.h-3\\.5').classList.add('hidden');
                });
                
                this.classList.add('border-pink-500', 'bg-pink-50');
                this.querySelector('.w-3\\.5.h-3\\.5').classList.remove('hidden');
                
                selectedPaket = {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    harga: parseInt(this.dataset.harga),
                    strip: parseInt(this.dataset.strip),
                    deskripsi: this.dataset.deskripsi
                };
                
                document.getElementById('selectedPaketId').value = selectedPaket.id;
                document.getElementById('paketError').style.display = 'none';
                
                document.getElementById('tambahStripSection').classList.remove('hidden');
                document.getElementById('paketStripCount').textContent = selectedPaket.strip;
                
                tambahStrip = 0;
                document.getElementById('tambahStripInput').value = 0;
                
                updateRingkasan();
                checkFormValidity();
            });
        });

        // Booth Selection
        function selectBooth(cardElement) {
            document.querySelectorAll('.booth-card').forEach(c => {
                c.classList.remove('border-pink-500', 'bg-pink-50');
                c.querySelector('.w-3\\.5.h-3\\.5').classList.add('hidden');
            });
            
            cardElement.classList.add('border-pink-500', 'bg-pink-50');
            cardElement.querySelector('.w-3\\.5.h-3\\.5').classList.remove('hidden');
            
            selectedBooth = {
                id: cardElement.dataset.id,
                name: cardElement.dataset.name,
                kapasitas: cardElement.dataset.kapasitas
            };
            
            document.getElementById('selectedBoothId').value = selectedBooth.id;
            document.getElementById('boothError').style.display = 'none';
            
            // Reset selected time
            selectedTime = null;
            document.getElementById('selectedTime').value = '';
            
            // Reset badge "Booth Close"
            document.querySelectorAll('.booth-close-badge').forEach(badge => {
                badge.remove();
            });
            
            // 🔥 LOAD BOOKED TIME SLOTS UNTUK BOOTH YANG DIPILIH
            loadBookedTimeSlots();
            
            updateRingkasan();
            checkFormValidity();
        }

        // Modal Functions
        function openBoothModal(cardElement) {
            currentBoothCard = cardElement;
            const modal = document.getElementById('boothModal');
            const boothName = cardElement.dataset.name;
            const boothKapasitas = cardElement.dataset.kapasitas;
            let images = [];
            
            try {
                const imagesData = cardElement.dataset.images;
                if (imagesData) {
                    images = JSON.parse(imagesData);
                    if (typeof images === 'string') {
                        images = JSON.parse(images);
                    }
                }
            } catch (e) {
                console.error('Error parsing images:', e);
                images = [];
            }
            
            document.getElementById('modalBoothTitle').textContent = boothName;
            document.getElementById('modalBoothType').textContent = `Kapasitas: ${boothKapasitas} orang`;
            
            const mainImage = document.getElementById('mainGalleryImage');
            if (images.length > 0) {
                mainImage.src = `/storage/${images[0]}`;
                mainImage.alt = boothName;
            } else {
                mainImage.src = '';
            }
            
            const thumbnailsContainer = document.getElementById('galleryThumbnails');
            thumbnailsContainer.innerHTML = '';
            
            if (images.length > 0) {
                images.forEach((img, index) => {
                    const thumbnail = document.createElement('img');
                    thumbnail.src = `/storage/${img}`;
                    thumbnail.alt = `${boothName} ${index + 1}`;
                    thumbnail.className = `gallery-thumbnail ${index === 0 ? 'active' : ''}`;
                    thumbnail.onclick = function() {
                        mainImage.src = this.src;
                        document.querySelectorAll('.gallery-thumbnail').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                    };
                    thumbnailsContainer.appendChild(thumbnail);
                });
            }
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeBoothModal() {
            const modal = document.getElementById('boothModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            currentBoothCard = null;
        }

        function selectBoothFromModal() {
            if (currentBoothCard) {
                selectBooth(currentBoothCard);
                closeBoothModal();
            }
        }

        window.onclick = function(event) {
            const modal = document.getElementById('boothModal');
            if (event.target === modal) {
                closeBoothModal();
            }
        }

        // Strip controls
        function increaseStrip() {
            if (!selectedPaket) return;
            if (tambahStrip < 10) {
                tambahStrip++;
                document.getElementById('tambahStripInput').value = tambahStrip;
                updateRingkasan();
            }
        }

        function decreaseStrip() {
            if (tambahStrip > 0) {
                tambahStrip--;
                document.getElementById('tambahStripInput').value = tambahStrip;
                updateRingkasan();
            }
        }

        // Time Slot Selection
        function selectTimeSlot(button, time) {
            if (button.classList.contains('bg-gray-300') || button.disabled) {
                return;
            }
            
            document.querySelectorAll('.time-slot').forEach(btn => {
                if (!btn.classList.contains('bg-gray-300')) {
                    btn.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                    btn.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
                }
            });
            
            button.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
            button.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
            
            selectedTime = time;
            document.getElementById('selectedTime').value = selectedTime;
            document.getElementById('timeError').style.display = 'none';
            
            updateRingkasanWaktu();
            checkFormValidity();
        }

        // 🔥 INITIALIZE TIME SLOTS (CEK YANG BOOKED & YANG LEWAT)
        function initializeTimeSlots() {
            const selectedDate = document.getElementById('tanggalInput').value;
            const today = new Date();
            const selectedDateObj = new Date(selectedDate + 'T00:00:00');
            const isToday = selectedDate === today.toISOString().split('T')[0];
            
            const currentHour = today.getHours();
            const currentMinute = today.getMinutes();
            const currentTime = currentHour * 60 + currentMinute;
            
            const openingTime = 9 * 60;
            const closingTime = 21 * 60 + 30;
            
            document.querySelectorAll('.time-slot').forEach(button => {
                const time = button.dataset.time;
                const [hour, minute] = time.split(':').map(Number);
                const slotTime = hour * 60 + minute;
                
                button.disabled = false;
                button.classList.remove('bg-gray-300', 'cursor-not-allowed', 'text-gray-400', 'bg-pink-500', 'text-white', 'border-pink-500');
                button.classList.add('bg-white', 'border-gray-200', 'text-gray-700', 'hover:border-pink-300', 'hover:bg-pink-50');
                
                let shouldDisable = false;
                
                // Di luar jam operasional
                if (slotTime < openingTime || slotTime > closingTime) {
                    shouldDisable = true;
                }
                
                // Hari ini, waktu sudah lewat
                if (isToday && slotTime <= currentTime) {
                    shouldDisable = true;
                }
                
                // Sudah dibooking
                if (bookedTimeSlots.includes(time)) {
                    shouldDisable = true;
                }
                
                if (shouldDisable) {
                    button.disabled = true;
                    button.classList.add('bg-gray-300', 'cursor-not-allowed', 'text-gray-400');
                    button.classList.remove('bg-white', 'hover:border-pink-300', 'border-gray-200', 'hover:bg-pink-50', 'text-gray-700');
                }
                
                // Pertahankan pilihan
                if (selectedTime === time && !shouldDisable) {
                    button.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
                    button.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
                }
            });
            
            // Reset pesan booth close jika ada slot yang tersedia
            const availableSlots = document.querySelectorAll('.time-slot:not(.bg-gray-300):not([disabled])').length;
            if (availableSlots > 0) {
                document.getElementById('allBookedMessage').classList.add('hidden');
                document.getElementById('timeSlotsContainer').classList.remove('opacity-50');
            }
        }

        function updateRingkasanWaktu() {
            const dateInput = document.getElementById('tanggalInput');
            const selectedDate = dateInput.value;
            
            if (!selectedDate) return;
            
            const dateObj = new Date(selectedDate);
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = dateObj.toLocaleDateString('id-ID', options);
            
            let waktuText = formattedDate;
            if (selectedTime) {
                waktuText += `, ${selectedTime}`;
            } else {
                waktuText = 'Belum dipilih';
            }
            
            document.getElementById('ringkasanWaktu').textContent = waktuText;
        }

        function updateRingkasan() {
            if (selectedPaket) {
                document.getElementById('ringkasanPaket').textContent = selectedPaket.name;
                document.getElementById('hargaPaket').textContent = formatRupiah(selectedPaket.harga);
                
                const totalStrip = selectedPaket.strip + tambahStrip;
                document.getElementById('ringkasanStrip').textContent = `${totalStrip} strip`;
                document.getElementById('paketStripCount').textContent = selectedPaket.strip;
                document.getElementById('totalStripCount').textContent = totalStrip;
            }
            
            if (selectedBooth) {
                document.getElementById('ringkasanBooth').textContent = selectedBooth.name;
            }
            
            let biayaTambahan = tambahStrip * hargaPerStrip;
            document.getElementById('biayaTambahan').textContent = formatRupiah(biayaTambahan);
            
            const tambahStripRow = document.getElementById('tambahStripRow');
            if (biayaTambahan > 0) {
                tambahStripRow.style.display = 'flex';
                document.getElementById('hargaTambahan').textContent = formatRupiah(biayaTambahan);
            } else {
                tambahStripRow.style.display = 'none';
            }
            
            const totalHarga = (selectedPaket ? selectedPaket.harga : 0) + biayaTambahan;
            document.getElementById('totalHarga').textContent = formatRupiah(totalHarga);
            
            updateRingkasanWaktu();
        }

        function formatRupiah(angka) {
            if (!angka) angka = 0;
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function checkFormValidity() {
            const isValid = selectedPaket && selectedBooth && selectedTime;
            const submitBtn = document.getElementById('submitBtn');
            const formError = document.getElementById('formError');
            
            if (isValid) {
                submitBtn.disabled = false;
                formError.style.display = 'none';
                return true;
            } else {
                submitBtn.disabled = true;
                
                let errorMsg = 'Harap lengkapi: ';
                const errors = [];
                if (!selectedPaket) errors.push('Paket Foto');
                if (!selectedBooth) errors.push('Booth Foto');
                if (!selectedTime) errors.push('Waktu Reservasi');
                
                errorMsg += errors.join(', ');
                formError.textContent = errorMsg;
                formError.style.display = 'block';
                return false;
            }
        }

        function validateForm() {
            if (!checkFormValidity()) {
                return false;
            }
            
            const errors = [];
            if (!selectedPaket) errors.push('Paket Foto');
            if (!selectedBooth) errors.push('Booth Foto');
            if (!selectedTime) errors.push('Waktu Reservasi');
            
            if (errors.length > 0) {
                document.getElementById('formError').textContent = 'Harap lengkapi: ' + errors.join(', ');
                document.getElementById('formError').style.display = 'block';
                return false;
            }
            
            return true;
        }
    </script>

</body>
</html>