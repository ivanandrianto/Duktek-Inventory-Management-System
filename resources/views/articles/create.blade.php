<!-- app/views/users/create.blade.php -->

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
        <a class="navbar-brand" href="{{ URL::to('articles') }}">User Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('articles') }}">View All Articles</a></li>
        <li><a href="{{ URL::to('articles/create') }}">Create an Article</a>
    </ul>
</nav>

<h1>Register</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::open(array('url' => 'articles')) !!}

    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', Input::old('title'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content', 'Content') !!}
        {!! Form::textarea('content', Input::old('content'), array('class' => 'form-control','cols' => 4,'rows' => 20)) !!}
    </div>

    <div class="form-group">
        {!! Form::label('excerpt', 'Excerpt') !!}
        {!! Form::textarea('excerpt', Input::old('address'), array('class' => 'form-control','cols' => 4,'rows' => 5)) !!}
    </div>
    

    {!! Form::submit('Publish!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>