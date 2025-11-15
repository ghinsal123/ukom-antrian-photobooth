@extends('admin.layouts.app')
@section('title', 'Booth')

@section('content')
<h2>Data Booth</h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Booth</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>1</td><td>Booth 1</td><td>Tersedia</td><td><button>Edit</button></td></tr>
        <tr><td>2</td><td>Booth 2</td><td>Dipakai</td><td><button>Edit</button></td></tr>
        <tr><td>3</td><td>Booth 3</td><td>Tersedia</td><td><button>Edit</button></td></tr>
    </tbody>
</table>
@endsection
