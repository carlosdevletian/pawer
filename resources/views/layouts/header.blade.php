<nav class="navbar navbar-dark navbar-expand-md" style="background-color: black">
    <button class="navbar-toggler border-0 clickable" type="button" data-toggle="collapse" data-target="#main-header" aria-controls="main-header" aria-expanded="false" aria-label="Toggle navigation">
        @svg('navbar-toggler')
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">@svg('logo', 'icon-w-3')</a>

    <div class="collapse navbar-collapse justify-content-end" id="main-header">
        <ul class="navbar-nav">
            <li class="nav-item active mr-5">
                <a class="nav-link ls-1 text-light fut-con-med" href="{{ route('about') }}">ABOUT</a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link ls-1 text-light fut-con-med" href="#">NEW ARRIVALS</a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link ls-1 text-light fut-con-med" href="{{ route('catalog') }}">CATALOG</a>
            </li>
            <li class="nav-item @auth mr-5 @endauth">
                <a class="nav-link ls-1 text-light fut-con-med" href="{{ route('lookbook') }}">LOOKBOOKS</a>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link ls-1 text-light fut-con-med" href="{{ route('dashboard') }}">DASHBOARD</a>
            </li>
            @endauth
        </ul>
    </div>
</nav>
@auth
<div class="container-fluid">
    <div class="row">
        <div class="col-12 d-flex justify-content-center p-0">
            <div class="w-100 alert alert-info text-center mb-0" role="alert">
                <p class="futura-medium m-0 p-0 d-inline">You are logged in as an administrator.
                    <a class="futura-medium d-inline text-orange-dark text-weight-bold" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                         Logout</a>
                </p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
            </div>
        </div>
    </div>
</div>
@endauth