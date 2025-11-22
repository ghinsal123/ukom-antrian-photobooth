@extends('Operator.layout')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Tambah Antrian</h2>

    <form action="{{ route('operator.antrian.store') }}" method="POST" class="bg-white p-8 shadow-lg rounded-xl space-y-6">
        @csrf

        {{-- Nama Customer --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nama Customer <span class="text-red-500">*</span></label>
            <input type="text" name="nama_pengguna" placeholder="Ketik nama customer..." 
                   class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400" required>
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
            <input type="text" name="no_telp" placeholder="Contoh: 08123456789"
                   class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400">
        </div>

        {{-- Pilih Booth --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Booth <span class="text-red-500">*</span></label>
            <select name="booth_id" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400" required>
                @foreach ($booth as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_booth }}</option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Paket --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Paket <span class="text-red-500">*</span></label>
            <select name="paket_id" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400" required>
                @foreach ($paket as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_paket }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Tanggal & Waktu</label>
            <p class="text-gray-600 text-lg italic">
                {{ now('Asia/Jakarta')->format('d M Y H:i') }}
            </p>

            <input type="hidden" name="tanggal" value="{{ now('Asia/Jakarta')->format('Y-m-d H:i:s') }}">
        </div>

        {{-- Catatan --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Catatan</label>
           <textarea 
                name="catatan"
                class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 resize-none"
                placeholder="Opsional"
                rows="4"
            ></textarea>
        </div>

        {{-- Tombol Simpan & Batal --}}
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-lg transition duration-300">
                Tambah Antrian
            </button>
            <a href="{{ route('operator.antrian.index') }}" 
               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center transition duration-300">
               Batal
            </a>
        </div>
    </form>
</div>
@endsection
