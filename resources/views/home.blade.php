@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('home.carousel')
    </div>
    <div class="row">
        <div class="col-xs-12" style="height: 35vh">

        </div>
    </div>
    <div class="row">
        <div class="col-md-6 p-0 background-image d-flex align-items-end flex-column" style="background-image: url('/images/headwear.png'); height: 55vh">
            <h1 class="mt-auto text-brand-primary font-italic pr-5 mb-0">HEAD</h1>
            <h1 class="text-brand-primary font-italic pr-5 mt-0">_WEAR</h1>
        </div>
        <div class="col-md-6 p-0 background-image d-flex align-items-end flex-column" style="background-image: url('/images/sportswear.png'); height: 55vh">
            <h1 class="mt-auto text-brand-primary font-italic pr-5 mb-0">SPORTS</h1>
            <h1 class="mt-0 text-brand-primary font-italic pr-5">_WEAR</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 p-0 background-image d-flex align-items-end flex-column" style="background-image: url('/images/underwear.png'); height: 33vh">
            <h1 class="mt-auto text-brand-primary font-italic pr-5">_UNDERWEAR</h1>
        </div>
    </div>
</div>
@endsection
