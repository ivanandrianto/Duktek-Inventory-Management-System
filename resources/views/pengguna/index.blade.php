<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Daftar Pengguna</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Nama</td>
            <td>Alamat</td>
            <td>No Telp</td>
            <td>Jenis</td>
        </tr>
    </thead>
    <tbody>
        @foreach($pengguna as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->nama }}</td>
            <td>{{ $value->alamat }}</td>
            <td>{{ $value->jenis }}</td>
            <td>{{ $value->no_telp }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
</div>
</body>
</html>