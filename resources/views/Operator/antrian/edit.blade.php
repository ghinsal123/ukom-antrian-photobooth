@extends('Operator.layout')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Edit Antrian</h2>

    @php
        $isCanceled = $data->status === 'dibatalkan';
        $grayClass = $isCanceled ? 'bg-gray-200 text-gray-600 cursor-not-allowed' : '';
    @endphp

    <form action="{{ route('operator.antrian.update', $data->id) }}" method="POST" class="bg-white p-8 shadow-lg rounded-xl space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Pengguna --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Pengguna</label>
            <input type="text" 
                   value="{{ $data->pengguna->nama_pengguna }}" 
                   class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed"
                   readonly>
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
            <input type="text" 
                   value="{{ $data->pengguna->no_telp ?? '-' }}"
                   class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed"
                   readonly>
        </div>

        {{-- Booth --}}
        <select name="booth_id" 
            class="w-full border border-gray-300 p-3 rounded-lg {{ $grayClass }}"
            @disabled($isCanceled)>
            @foreach ($booth as $b)
                <option value="{{ $b->id }}" @selected($b->id == $data->booth_id)>
                    {{ $b->nama_booth }}
                </option>
            @endforeach
        </select>

        {{-- Paket --}}
        <select name="paket_id"
            class="w-full border border-gray-300 p-3 rounded-lg {{ $grayClass }}"
            @disabled($isCanceled)>
            @foreach ($paket as $p)
                <option value="{{ $p->id }}" @selected($p->id == $data->paket_id)>
                    {{ $p->nama_paket }}
                </option>
            @endforeach
        </select>

        {{-- Nomor Antrian --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nomor Antrian</label>
            <input type="text" value="{{ $data->nomor_antrian }}" 
                   class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed"
                   readonly>
        </div>

        {{-- Tanggal & Waktu--}}
        <div class="py-3 hover:bg-gray-50 transition">
            <span class="font-medium text-gray-700 block">Tanggal & Waktu</span>
            <span class="text-gray-900 text-lg italic mt-1 block">
                {{ \Carbon\Carbon::parse($data->tanggal)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
            </span>
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400"
                    @disabled($isCanceled)>
                <option value="menunggu" @selected($data->status == 'menunggu')>Menunggu</option>
                <option value="proses" @selected($data->status == 'proses')>Proses</option>
                <option value="selesai" @selected($data->status == 'selesai')>Selesai</option>
                <option value="dibatalkan" @selected($data->status == 'dibatalkan')>Dibatalkan</option>
            </select>

            @if ($isCanceled)
                <p class="text-red-500 text-sm mt-1 italic">
                    Status tidak bisa diubah karena antrian sudah dibatalkan.
                </p>
            @endif
        </div>

        {{-- Catatan --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Catatan</label>
            <textarea name="catatan" rows="4"
                class="w-full border border-gray-300 p-3 rounded-lg {{ $grayClass }} resize-none"
                @disabled($isCanceled)
            >{{ $data->catatan }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex gap-4">
            <button type="submit" 
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-lg transition duration-300">
                Edit Antrian
            </button>
            <a href="{{ route('operator.antrian.index') }}" 
               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center transition duration-300">
               Batal
            </a>
        </div>
    </form>
</div>
@endsection
