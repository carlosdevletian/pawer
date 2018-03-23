@extends('layouts.product-menu')

@section('title')
    {{ ucfirst($category->name)  }} - Pawer
@endsection

@section('main-content')
    <!-- Category image header -->
    <div class="row h-35vh position-relative">
        <div class="col-12 background-image" style="background-image: url('{{$category->getImage()}}');" alt="{{ $category->name }}"></div>

        <!-- Names divided by subNames -->
        <div class="position-absolute bottom-0">
            @foreach($category->sub_names as $subName)
                @if($loop->first)
                    <h4 class="display-4 mt-auto text-white font-italic pr-5 mb-0 ml-4 text-uppercase">{{ $subName }}</h4>
                    @else
                    <h4 class="display-4 mt-0 text-white font-italic pr-5 ml-4 text-uppercase">{{ $loop->last ? "_{$subName}" : $subName }}</h4>
                    @endif
            @endforeach
        </div>
    </div>

    <!-- Breadcrumbs -->
    @include('layouts.breadcrumbs', [
        'links' => [
            'Catalog' => route('catalog'),
            'active' => $category->name
        ]
    ])

    <!-- Main section -->
    <div class="row">
    @foreach($products as $product)
    <div class="col-12 pl-5">
        <p class="text-uppercase">{{ $product->name }} [{{ $product->articles()->count() }}]</p>
        <div class="row">
        @foreach($product->articles()->byFamily() as $article)
            @component('articles.thumbnail')
                <product :data-product="{{ $article }}"
                        :data-active="true"
                        link-to="{{ route('articles.show', $article->first()->slug) }}"></product>
            @endcomponent
        @endforeach
        </div>
    </div>
    @endforeach
    </div>
@endsection