@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav class="d-none d-md-block col-md-3 nav flex-column p-4" style="background-color: rgb(230,230,230)">
                <ul class="pt-4">
                    <a class="nav-link p-0 text-dark" href="#"><h4>TOPS</h4></a>
                    <a class="nav-link p-0 text-dark" href="#">T-Shirts</a>
                    <a class="nav-link p-0 text-dark" href="#">Sweatshirts</a>
                    <a class="nav-link p-0 text-dark" href="#">Button-Ups</a>
                    <a class="nav-link p-0 text-dark" href="#">Tanks</a>
                    <a class="nav-link p-0 text-dark" href="#">Jackets</a>
                </ul>
                <ul>
                    <a class="nav-link p-0 text-dark" href="#"><h4>HEADWEAR</h4></a>
                    <a class="nav-link p-0 text-dark" href="#">Snapbacks</a>
                    <a class="nav-link p-0 text-dark" href="#">5 panels</a>
                    <a class="nav-link p-0 text-dark" href="#">Beanies</a>
                </ul>
                <ul>
                    <a class="nav-link p-0 text-dark" href="#"><h4>UNDERWEAR</h4></a>
                    <a class="nav-link p-0 text-dark" href="#">Boxers</a>
                    <a class="nav-link p-0 text-dark" href="#">Socks</a>
                </ul>
            </nav>
            <div class="col-xs-12 col-md-8 d-flex flex-column justify-content-center">
                <small style="color: rgb(179,179,179)">SHOP > HEADWEAR > SNAPBACKS</small>
                <img src="/images/gorra5.png" width="350px" height="350px">
            </div>
        </div>
    </div>
@endsection
