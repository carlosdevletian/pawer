<nav class="navbar navbar-dark navbar-expand-md" style="background-color: black">
    <button class="navbar-toggler border-0 clickable" type="button" data-toggle="collapse" data-target="#main-header" aria-controls="main-header" aria-expanded="false" aria-label="Toggle navigation">
        @svg('navbar-toggler')
    </button>
    <a class="navbar-brand" href="#">@svg('logo', 'icon-w-3')</a>

    <div class="collapse navbar-collapse justify-content-end" id="main-header">
        <ul class="navbar-nav">
            <li class="nav-item active mr-5">
                <a class="nav-link ls-1 font-weight-bold text-light" href="#">ABOUT</a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link ls-1 font-weight-bold text-light" href="#">NEW ARRIVALS</a>
            </li>
            <li class="nav-item mr-5">
                <a class="nav-link ls-1 font-weight-bold text-light" href="#">CATALOG</a>
            </li>
            <li class="nav-item">
                <a class="nav-link ls-1 font-weight-bold text-light" href="{{ route('lookbook') }}">LOOKBOOKS</a>
            </li>
        </ul>
    </div>

    {{-- Authentication Links
    @guest
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
    @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @endguest
        --}}
</nav>