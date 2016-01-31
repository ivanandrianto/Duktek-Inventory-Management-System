<!-- app/views/admin/edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('users') }}">User Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('users') }}">View All Nerds</a></li>
        <li><a href="{{ URL::to('users/create') }}">Create a User</a>
    </ul>
</nav>

<h1>Edit {{ $user->name }}</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('address', 'Address') !!}
        {!! Form::text('address', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('mobile_phone', 'Mobile Phone') !!}
        {!! Form::text('mobile_phone', null, array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Edit the User!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>