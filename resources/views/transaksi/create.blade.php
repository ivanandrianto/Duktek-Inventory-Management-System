<!-- app/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Buat Transaksi Baru</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Transaksi Baru</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::open(array('url' => 'transaksi')) !!}

    <div class="form-group">
        {!! Form::label('id_barang', 'Barang') !!}
        {!! Form::text('id_barang', Input::old('id_barang'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_pinjam', 'Waktu Mulai Pinjam') !!}
        {!! Form::input('date', 'waktu_pinjam_date', Input::old('waktu_pinjam_date'), array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_pinjam_time', Input::old('waktu_pinjam_time'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_rencana_kembali', 'Waktu Rencana Kembali') !!}
        {!! Form::input('date', 'waktu_rencana_kembali_date', Input::old('waktu_rencana_kembali_date'), array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_rencana_kembali_time', Input::old('waktu_rencana_kembali_time'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_kembali', 'Waktu Rencana Kembali') !!}
        {!! Form::input('date', 'waktu_kembali_date', Input::old('waktu_kembali_date'), array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_kembali_time', Input::old('waktu_kembali_time'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('id_peminjam', 'Peminjam') !!}
        {!! Form::text('id_peminjam', Input::old('id_peminjam'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Pinjam!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>