@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row" style="min-height: 95vh">
            <div class="d-none d-lg-block col-lg-2 p-0">
                <nav class="nav flex-column p-4 align-items-center" style="background-color: rgb(230,230,230); height:100% ">
                    <div class="p-2">
                        <ul class="p-0">
                            <a class="nav-link text-dark" href="#"><h6 class="futura-medium">TOPS</h6></a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">T-Shirts</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Sweatshirts</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Button-Ups</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Tanks</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Jackets</a>
                        </ul>
                        <ul class="p-0">
                            <a class="nav-link text-dark" href="#"><h6 class="futura-medium">HEADWEAR</h6></a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Snapbacks</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">5 panels</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Beanies</a>
                        </ul>
                        <ul class="p-0">
                            <a class="nav-link text-dark" href="#"><h6 class="futura-medium">UNDERWEAR</h6></a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Boxers</a>
                            <a class="nav-link p-0 pl-4 text-dark" href="#">Socks</a>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="col-12 col-lg-10">
                @yield('main-content')
            </div>
        </div>
    </div>
@endsection