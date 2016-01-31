<!-- app/views/nerds/edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit {{ $peralatan->nama }} - Peralatan</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Edit {{ $peralatan->nama }}</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::model($peralatan, array('route' => array('peralatan.update', $peralatan->id), 'method' => 'PUT')) !!}

    <?php $status = $ketersediaan = 0;
    if($peralatan->status == "Tidak Rusak"){
        $status = 1;
    }
    if($peralatan->ketersediaan ==  "Tersedia"){
        $ketersediaan = 1;
    }
    ?>

    <div class="form-group">
        {!! Form::label('nama', 'Nama') !!}
        {!! Form::text('nama', Input::old('nama'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', array(1 => 'Tidak rusak', 0 => 'Rusak'), $status) !!}
    </div>

   <div class="form-group">
        {!! Form::label('ketersediaan', 'Ketersediaan') !!}
        {!! Form::select('ketersediaan', array(1 => 'Tersedia', 0 => 'Tidak tersedia'), $ketersediaan) !!}
    </div>

    <div class="form-group">
        {!! Form::label('lokasi', 'Lokasi') !!}
        {!! Form::text('lokasi', Input::old('lokasi'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('jenis', 'Jenis') !!}
        {!! Form::text('jenis', Input::old('jenis'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Edit Peralatan!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>