@extends('admin.layouts.app')
@section('title', 'Akun')

@section('content')
<h2>Daftar Akun</h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>1</td><td>Super Admin</td><td>super@studio.com</td><td>Super Admin</td><td><button>Edit</button></td></tr>
        <tr><td>2</td><td>Admin 1</td><td>admin1@studio.com</td><td>Admin</td><td><button>Edit</button></td></tr>
        <tr><td>3</td><td>Operator 1</td><td>operator@studio.com</td><td>Operator</td><td><button>Edit</button></td></tr>
    </tbody>
</table>
@endsection
