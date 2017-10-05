@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row" style="min-height: 95vh">
            <div class="d-none d-md-block col-md-3 col-lg-2 p-0">
                <nav class="nav flex-column p-4" style="background-color: rgb(230,230,230); height:100% ">
                    <ul class="p-0">
                        <a class="nav-link p-0 text-dark" href="#"><h6 class="futura-medium">TOPS</h6></a>
                        <a class="nav-link p-0 text-dark" href="#">T-Shirts</a>
                        <a class="nav-link p-0 text-dark" href="#">Sweatshirts</a>
                        <a class="nav-link p-0 text-dark" href="#">Button-Ups</a>
                        <a class="nav-link p-0 text-dark" href="#">Tanks</a>
                        <a class="nav-link p-0 text-dark" href="#">Jackets</a>
                    </ul>
                    <ul class="p-0">
                        <a class="nav-link p-0 text-dark" href="#"><h6 class="futura-medium">HEADWEAR</h6></a>
                        <a class="nav-link p-0 text-dark" href="#">Snapbacks</a>
                        <a class="nav-link p-0 text-dark" href="#">5 panels</a>
                        <a class="nav-link p-0 text-dark" href="#">Beanies</a>
                    </ul>
                    <ul class="p-0">
                        <a class="nav-link p-0 text-dark" href="#"><h6 class="futura-medium">UNDERWEAR</h6></a>
                        <a class="nav-link p-0 text-dark" href="#">Boxers</a>
                        <a class="nav-link p-0 text-dark" href="#">Socks</a>
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-lg-10">
                <div class="container-fluid">
                    <div class="row pt-4 pb-5 pl-5">
                        <div class="col-12 pl-0">
                            <small style="color: rgb(179,179,179)">SHOP > HEADWEAR > SNAPBACKS</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-lg-2 pl-sm-5 pr-0">
                            <div class="d-flex flex-sm-column justify-content-center">
                                <div class="background-image border border-dark mb-3 mr-2 mr-sm-0" style="background-image: url('images/gorra2.png'); width: 90px; height: 90px"></div>
                                <div class="background-image border border-dark mb-3 mr-2 mr-sm-0" style="background-image: url('images/gorra3.png'); width: 90px; height: 90px"></div>
                                <div class="background-image border border-dark mb-3 mr-2 mr-sm-0" style="background-image: url('images/gorra4.png'); width: 90px; height: 90px"></div>
                                <div class="background-image border border-dark mb-3 mr-2 mr-sm-0" style="background-image: url('images/gorra5.png'); width: 90px; height: 90px"></div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-md-8 col-lg-7 col-xl-5 pl-0 pr-0">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="#">@icon('arrow-left', 'icon-h-3 font-weight-bold')</a>
                                <div class="background-image" style="background-image: url('images/gorra1.png'); width: 400px; height: 400px"></div>
                                <a href="#">@icon('arrow-right', 'icon-h-3 font-weight-bold')</a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-5 p-0 px-4">
                            <div class="pr-2 pt-2 d-flex justify-content-between align-items-center border border-top-0 border-left-0 border-right-0 border-secondary mb-2">
                                <h4 class="futura-medium p-0">Ruca Snapsack</h4>
                                <small>ONE-SIZE</small>
                            </div>
                            <div class="d-flex justify-content-end mb-4">
                                <div class="bg-secondary mr-2" style="width: 25px; height: 25px"></div>
                                <div class="bg-warning mr-2" style="width: 25px; height: 25px"></div>
                                <div class="bg-danger" style="width: 25px; height: 25px"></div>
                            </div>
                            <p class="futura-medium m-0">Product Detail</p>
                            <p class="p-2 mt-0" style="background-color: rgb(230,230,230)">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
