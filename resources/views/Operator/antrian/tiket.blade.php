@extends('Operator.layout')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 shadow-lg rounded-xl text-center">

    <h2 class="text-3xl font-bold mb-4 text-pink-500">Tiket Antrian</h2>

    <div class="mb-4 text-left">
        <div class="flex justify-between pb-4">
            <span class="text-gray-900">{{ $data->tanggal . ' ' . $data->jam }}</span>
            <span class="font-bold text-yellow-600">{{ ucfirst($data->status) }}</span>
        </div>
        <p><strong>Customer:</strong> {{ $data->pengguna->nama_pengguna ?? '-' }}</p>
        <p><strong>Telepon:</strong> {{ $data->pengguna->no_telp ?? '-' }}</p>
        <p><strong>Booth:</strong> {{ $data->booth->nama_booth }}</p>
        <p><strong>Paket:</strong> {{ $data->paket->nama_paket }}</p>
        <p class="text-center text-8xl font-bold text-pink-500"> {{ $data->nomor_antrian }}</p>
    </div>

    @if($barcodeImageBase64)
        <div class="my-6">
            <img src="{{ $barcodeImageBase64 }}" alt="Barcode" class="mx-auto">
        </div>
    @else
        <p class="text-red-500">Barcode belum tersedia.</p>
    @endif

    <p class="text-sm text-gray-500">Silakan cetak barcode ini.</p>

    {{-- Tombol untuk web --}}
    @if(!isset($isPdf))
        <div class="mt-4 flex flex-col gap-2">
            <a href="{{ route('operator.antrian.show', $data->id) }}"
               class="inline-block px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
               Lihat Detail Antrian
            </a>

            <a href="{{ route('operator.antrian.index') }}"
               class="inline-block px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
               Kembali ke Daftar Antrian
            </a>

            {{-- Tombol Cetak PDF --}}
            <a href="{{ route('operator.antrian.cetakPdf', $data->id) }}"
               target="_blank"
               class="inline-block px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
               Cetak PDF
            </a>
            {{-- Tombol Batalkan --}}
            @if(!isset($isPdf) && $data->status === 'menunggu')
                <form action="{{ route('operator.antrian.cancel', $data->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan antrian ini?');"
                            class="w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Batalkan Antrian
                    </button>
                </form>
            @endif
        </div>
    @endif

</div>
@endsection
