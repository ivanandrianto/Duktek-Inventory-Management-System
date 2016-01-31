<!-- app/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Transaksi Baru</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::model($transaksi, array('route' => array('transaksi.update', $transaksi->id), 'method' => 'PUT')) !!}

    <?php
        $waktu_pinjam = new DateTime($transaksi->waktu_pinjam);
        $waktu_rencana_kembali = new DateTime($transaksi->waktu_rencana_kembali);
        $waktu_kembali = new DateTime($transaksi->waktu_kembali);
        $waktu_pinjam_date = Input::old('waktu_pinjam_date')?Input::old('waktu_pinjam_date'):$waktu_pinjam->format('Y-m-d');
        $waktu_pinjam_time = Input::old('waktu_pinjam_time')?Input::old('waktu_pinjam_time'):$waktu_pinjam->format('H:i');
        $waktu_rencana_kembali_date = Input::old('waktu_rencana_kembali_date')?Input::old('waktu_rencana_kembali_date'):$waktu_rencana_kembali->format('Y-m-d');
        $waktu_rencana_kembali_time = Input::old('waktu_rencana_kembali_time')?Input::old('waktu_rencana_kembali_time'):$waktu_rencana_kembali->format('H:i');
        $waktu_kembali_date = Input::old('waktu_kembali_date')?Input::old('waktu_kembali_date'):$waktu_kembali->format('Y-m-d');
        $waktu_kembali_time = Input::old('waktu_kembali_time')?Input::old('waktu_kembali_time'):$waktu_kembali->format('H:i');
    ?>

    <div class="form-group">
        {!! Form::label('id_barang', 'Barang') !!}
        {!! Form::text('id_barang', Input::old('id_barang'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_pinjam', 'Waktu Pinjam Mulai') !!}
        {!! Form::input('date', 'waktu_pinjam_date', $waktu_pinjam_date, array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_pinjam_time', $waktu_pinjam_time, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_rencana_kembali', 'Waktu Rencana Kembali') !!}
        {!! Form::input('date', 'waktu_rencana_kembali_date', $waktu_rencana_kembali_date, array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_rencana_kembali_time', $waktu_rencana_kembali_time, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_kembali', 'Waktu Kembali') !!}
        {!! Form::input('date', 'waktu_kembali_date', $waktu_kembali_date, array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_kembali_time', $waktu_kembali_time, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('id_peminjam', 'Peminjam') !!}
        {!! Form::text('id_peminjam', Input::old('id_peminjam'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Update Transaksi!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>