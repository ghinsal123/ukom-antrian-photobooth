@extends('Operator.layout')

@section('content')
<div class="max-w-lg mx-auto mt-5">
    {{-- Judul Halaman --}}
    <h2 class="text-4xl font-extrabold mb-8 text-gray-800 text-center">Edit Profile</h2>

    {{-- Card Form --}}
    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
        <form action="{{ route('operator.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT') 

            {{-- Nama Pengguna --}}
            <div>
                <label class="block mb-2 font-medium text-gray-700">Nama Pengguna</label>
                <input type="text" value="{{ $operator->nama_pengguna }}" disabled
                    class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-pink-300">
            </div>

            {{-- Role --}}
            <div>
                <label class="block mb-2 font-medium text-gray-700">Role</label>
                <input type="text" value="{{ ucfirst($operator->role) }}" disabled
                    class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-pink-300">
            </div>

            {{-- Foto Saat Ini --}}
            <div>
                <label class="block mb-2 font-medium text-gray-700">Foto Saat Ini</label>
                <img src="{{ $operator->foto ? asset('storage/'.$operator->foto) : 'https://ui-avatars.com/api/?name='.$operator->nama_pengguna }}" 
                    class="w-32 h-32 rounded-full object-cover border mx-auto">
            </div>

            {{-- Upload Foto Baru --}}
            <div>
                <label class="block mb-2 font-medium text-gray-700">Upload Foto Baru</label>
                <input type="file" name="foto" accept="image/*" 
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-300">
                @error('foto')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit & Kembali --}}
            <div class="text-center flex justify-center gap-4">
                <button type="submit" 
                    class="flex-1 bg-pink-500 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-pink-600 transition duration-200">
                    Simpan Foto
                </button>

                <a href="{{ url()->previous() }}" 
                    class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-400 transition duration-200 text-center">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
