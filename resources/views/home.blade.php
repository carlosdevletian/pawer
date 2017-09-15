@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('home.carousel')
    </div>
    <div class="row bg-warning">
        <div class="col-xs-12" style="height: 35vh">

        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-0 background-image d-flex align-items-end flex-column" style="background-image: url('/images/headwear.png'); height: 55vh">
            <p class="mt-auto text-danger pr-5">HEADWEAR</p>
        </div>
        <div class="col-md-6 p-0 background-image d-flex align-items-end flex-column" style="background-image: url('/images/sportswear.png'); height: 55vh">
            <p class="mt-auto text-danger pr-5">SPORTSWEAR</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 p-0 background-image d-flex align-items-end flex-column" style="background-image: url('/images/underwear.png'); height: 33vh">
            <p class="mt-auto text-danger pr-5">UNDERWEAR</p>
        </div>
    </div>
</div>
@endsection
