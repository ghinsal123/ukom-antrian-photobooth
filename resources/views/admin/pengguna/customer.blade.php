@extends('admin.layouts.app')

@section('title', 'Daftar Customer')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <h2 class="text-2xl font-semibold text-gray-700 mb-5">Daftar Customer</h2>

    @include('admin.pengguna.table', ['pengguna' => $pengguna])

</div>
@endsection
