<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('gila') }}">DIMS</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ URL::to('auth/logout') }}">Logout</a>
    </ul>
</nav>