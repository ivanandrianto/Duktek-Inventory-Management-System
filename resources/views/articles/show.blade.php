<!-- app/views/nerds/show.blade.php -->

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
        <a class="navbar-brand" href="{{ URL::to('articles') }}">Article Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('articles') }}">View All Articles</a></li>
        <li><a href="{{ URL::to('articles/create') }}">Create an Article</a>
    </ul>
</nav>

<h1>Showing {{ $article->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $article->name }}</h2>
        <p>
            <h1> {{ $article->title }}</h1>
            <strong>Content:</strong> {{ $article->content }}<br>
            <strong>Excerpt:</strong> {{ $article->excerpt }}<br>
        </p>
    </div>

</div>
</body>
</html>