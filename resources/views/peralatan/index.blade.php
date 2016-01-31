<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peralatan</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Daftar Peralatan</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Nama</td>
            <td>Status</td>
            <td>Ketersediaan</td>
            <td>Lokasi</td>
            <td>Jenis</td>
        </tr>
    </thead>
    <tbody>
        @foreach($peralatan as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->nama }}</td>
            <td>{{ $value->status }}</td>
            <td>{{ $value->ketersediaan }}</td>
            <td>{{ $value->lokasi }}</td>
            <td>{{ $value->jenis }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
</div>
</body>
</html>