@extends('admin.layouts.app')

@section('title', 'Daftar Staff')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Staff (Admin & Operator)</h2>

        <a href="{{ route('admin.pengguna.create') }}" 
            class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow">
            + Tambah Staff
        </a>
    </div>

    @include('admin.pengguna.table', ['pengguna' => $pengguna])

</div>
@endsection
