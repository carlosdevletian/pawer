@extends('layouts.app')

@section('title')
    Pawer
@endsection

@section('content')
<div class="container-fluid" style="overflow-x:hidden">
    <div class="row bg-grey-light">
        @auth
            @include('admin.home.edit-carousel', ['images' => 'carouselImages'])
        @else
            @include('home.carousel', ['images' => 'carouselImages'])
        @endauth
    </div>

    <product-carousel :data-products="{{ $featuredArticles }}">
        <div slot="arrow-left">@icon('arrow-left', 'icon-h-3 font-weight-bold')</div>
        <div slot="arrow-right">@icon('arrow-right', 'icon-h-3 font-weight-bold')</div>
    </product-carousel>

    @foreach($categoryChunks as $categories)
    <div class="row">
    @switch($categories->count())
        @case(1)
            @include('home.full-width-category', ['category' => $categories->first()])
        @break
        @case(2)
            @include('home.even-categories', ['categories' => $categories])
        @break
        @case(3)
            @include('home.odd-categories', ['categories' => $categories])
        @break
    @endswitch
    </div>
    @endforeach
</div>
@endsection
