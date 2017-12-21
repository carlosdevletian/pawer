@extends('layouts.app')

@section('title')
    Pawer
@endsection

@section('content')
<div class="container-fluid" style="overflow-x:hidden">
    <div class="row">
        @include('home.carousel')
    </div>

    <product-carousel :data-products="{{ $featuredArticles }}">
        <div slot="arrow-left">@icon('arrow-left', 'icon-h-3 font-weight-bold')</div>
        <div slot="arrow-right">@icon('arrow-right', 'icon-h-3 font-weight-bold')</div>
    </product-carousel>

    <div class="row">
        <a href="#" class="col-md-6 p-0 background-image d-flex align-items-start flex-column" style="background-image: url('/images/headwear.png'); height: 55vh">
            <h1 class="display-3 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4">HEAD</h1>
            <h1 class="display-3 text-brand-primary font-italic pr-5 mt-0 ml-4">_WEAR</h1>
        </a>
        <a href="#" class="col-md-6 p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('/images/sportswear.png'); height: 55vh">
            <h1 class="display-3 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-sm-4">SPORTS</h1>
            <h1 class="display-3 mt-0 text-brand-primary font-italic pr-5 ml-sm-4">_WEAR</h1>
        </a>
    </div>

    <a href="#" class="row d-none d-md-block">
        <div class="col-xs-12 p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('/images/underwear.png'); height: 33vh">
            <h1 class="display-3 mt-auto text-brand-primary font-italic pr-5 ml-sm-4">_UNDERWEAR</h1>
        </div>
    </a>

    <a href="#" class="row d-md-none">
        <div class="col-xs-12 p-0 background-image d-flex align-items-md-end flex-column" style="background-image: url('/images/underwear.png'); height: 55vh">
            <h1 class="display-3 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-sm-4">UNDER</h1>
            <h1 class="display-3 mt-0 text-brand-primary font-italic pr-5 ml-sm-4">_WEAR</h1>
        </div>
    </a>
</div>
@endsection
