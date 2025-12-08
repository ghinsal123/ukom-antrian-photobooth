<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Antrian</title>
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
    </style>
</head>

<body class="bg-pink-50">

    <!-- NAVBAR DIUBAH SEPERTI DI HALAMAN ANTRIAN -->
    <header class="form-header">
        <div class="header-content">
            <a href="{{ route('customer.dashboard') }}" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 py-8">

        <!-- judul, nama, tanggal -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Arsip Antrian</h1>
            <p class="text-gray-600">
                {{ $pengguna->nama_pengguna }} — {{ now()->format('d M Y') }}
            </p>
        </div>

        <!-- untuk arsip kosong -->
        @if ($arsip->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                <div class="flex flex-col items-center justify-center gap-3">
                    <svg class="w-12 h-12 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                    <p class="text-yellow-700 font-medium">Belum ada antrian yang selesai atau dibatalkan.</p>
                </div>
            </div>

        @else

        <!-- TABEL ARSIP -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-pink-500 text-white">
                        <tr class="text-left">
                            <th class="py-4 px-6 font-semibold text-sm">No</th>
                            <th class="py-4 px-6 font-semibold text-sm">Nomor Antrian</th>
                            <th class="py-4 px-6 font-semibold text-sm">Paket</th>
                            <th class="py-4 px-6 font-semibold text-sm">Booth</th>
                            <th class="py-4 px-6 font-semibold text-sm">Status</th>
                            <th class="py-4 px-6 font-semibold text-sm">Catatan</th>
                            <th class="py-4 px-6 font-semibold text-sm">Total Harga</th>
                            <th class="py-4 px-6 font-semibold text-sm">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($arsip as $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6 text-gray-700">{{ $loop->iteration }}</td>

                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-800">
                                    {{ $item->nomor_antrian }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-gray-700">
                                {{ $item->paket->nama_paket }}
                            </td>

                            <td class="py-4 px-6 text-gray-700">
                                {{ $item->booth->nama_booth }}
                            </td>

                            <td class="py-4 px-6">
                                @if ($item->status === 'selesai')
                                    <!-- STATUS SELESAI -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white" style="background-color: #ec4899;">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Selesai
                                    </span>
                                @elseif ($item->status === 'dibatalkan')
                                    <!-- STATUS DIBATALKAN -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Dibatalkan
                                    </span>
                                @elseif ($item->status === 'kadaluarsa')
                                    <!-- STATUS KADALUARSA -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Kadaluarsa
                                    </span>
                                @endif
                            </td>

                            <!-- CATATAN -->
                            <td class="py-4 px-6 text-gray-600">
                                @if($item->catatan)
                                    @php
                                        // Cek apakah catatan berisi JSON
                                        $catatanData = null;
                                        if (is_string($item->catatan)) {
                                            $decoded = json_decode($item->catatan, true);
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                $catatanData = $decoded;
                                            }
                                        }
                                    @endphp
                                    
                                    @if($catatanData && isset($catatanData['catatan_operator']))
                                        <div class="max-w-xs truncate" title="{{ $catatanData['catatan_operator'] }}">
                                            {{ $catatanData['catatan_operator'] }}
                                        </div>
                                    @else
                                        <div class="max-w-xs truncate" title="{{ $item->catatan }}">
                                            {{ $item->catatan }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            
                            <!-- TOTAL HARGA -->
                            <td class="py-4 px-6">
                                @php
                                    // Cek apakah catatan berisi JSON dengan harga
                                    $catatanData = null;
                                    if ($item->catatan && is_string($item->catatan)) {
                                        try {
                                            $decoded = json_decode($item->catatan, true);
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                $catatanData = $decoded;
                                            }
                                        } catch (Exception $e) {
                                            $catatanData = null;
                                        }
                                    }
                                @endphp
                                
                                @if(isset($catatanData['total_harga']))
                                    <span class="font-semibold text-pink-500">
                                        Rp {{ number_format($catatanData['total_harga'], 0, ',', '.') }}
                                    </span>
                                @elseif($item->total_harga)
                                    <span class="font-semibold text-pink-500">
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-6 text-gray-700">
                                {{ date('d M Y', strtotime($item->tanggal)) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- INFO JUMLAH DATA -->
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold">{{ $arsip->count() }}</span> data arsip antrian
                </p>
            </div>
        </div>

        @endif

    </div>

</body>
</html>