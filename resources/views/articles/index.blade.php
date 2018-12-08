@extends('layouts.product-menu')

@section('title')
    {{ ucfirst($product->name)  }} - Pawer
@endsection

@section('main-content')
    <div class="row h-35vh position-relative">
        <div class="col-12 background-image" style="background-image: url('{{ $product->getImage() }}');" alt="{{ $product->name }}">
        </div>
        <h4 class="display-4 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase position-absolute bottom-0">{{ $product->name }}</h4>
    </div>

    @include('layouts.breadcrumbs', [
        'links' => [
            'Catalog' => route('catalog'),
            $product->category->name => route('products.index', $product->category->slug),
            'active' => $product->name
        ]
    ])

    <div class="row">
    @foreach($articles as $name => $article)
        @component('articles.thumbnail')
            <product :data-product="{{ $article }}"
                    :data-active="true"
                    :with-link="true"></product>
        @endcomponent
    @endforeach
    </div>
@endsection