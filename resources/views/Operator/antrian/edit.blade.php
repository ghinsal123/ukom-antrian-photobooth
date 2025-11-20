@extends('Operator.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Antrian</h2>

<form action="{{ route('operator.antrian.update', $data->id) }}" method="POST" class="bg-white p-6 shadow-lg rounded-xl space-y-4">
    @csrf
    @method('PUT')

    <!-- Pengguna (input text) -->
    <div>
        <label class="font-medium text-gray-700">Pengguna</label>
        <input type="text" name="pengguna_id" 
               value="{{ $data->pengguna->nama_pengguna ?? '' }}" 
               class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
               placeholder="Ketik nama pengguna...">
    </div>

    <!-- Booth -->
    <div>
        <label class="font-medium text-gray-700">Booth</label>
        <select name="booth_id" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            @foreach ($booth as $b)
                <option value="{{ $b->id }}" @selected($b->id == $data->booth_id)>
                    {{ $b->nama_booth }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Paket -->
    <div>
        <label class="font-medium text-gray-700">Paket</label>
        <select name="paket_id" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            @foreach ($paket as $p)
                <option value="{{ $p->id }}" @selected($p->id == $data->paket_id)>
                    {{ $p->nama_paket }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Nomor Antrian -->
    <div>
        <label class="font-medium text-gray-700">Nomor Antrian</label>
        <input type="text" name="nomor_antrian" 
            value="{{ $data->nomor_antrian }}" 
            class="w-full border border-gray-300 p-2 rounded-lg bg-gray-100 cursor-not-allowed"
            readonly>
    </div>

    <!-- Tanggal -->
    <div>
        <label class="font-medium text-gray-700">Tanggal</label>
        <input type="date" name="tanggal" 
               value="{{ $data->tanggal }}" 
               class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
    </div>

    <!-- Status -->
    <div>
        <label class="font-medium text-gray-700">Status</label>
        <select name="status" class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <option value="menunggu" @selected($data->status == 'menunggu')>Menunggu</option>
            <option value="proses" @selected($data->status == 'proses')>Proses</option>
            <option value="selesai" @selected($data->status == 'selesai')>Selesai</option>
            <option value="batal" @selected($data->status == 'batal')>Dibatalkan</option>
        </select>
    </div>

    <!-- Catatan -->
    <div>
        <label class="font-medium text-gray-700">Catatan</label>
        <textarea name="catatan" rows="3" 
                  class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                  placeholder="Tambahkan catatan...">{{ $data->catatan }}</textarea>
    </div>

    <!-- Tombol Update -->
    <div class="pt-2">
        <button type="submit" 
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg transition">
            Update
        </button>
        <a href="{{ route('operator.antrian.index') }}" 
           class="ml-3 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
            Kembali
        </a>
    </div>
</form>
@endsection
