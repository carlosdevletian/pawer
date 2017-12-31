@extends('layouts.product-menu')

@section('title')
    {{ $article->name }} - Pawer
@endsection

@section('main-content')
    <div class="container-fluid">
        @include('layouts.breadcrumbs', [
                'links' => [
                    'Catalog' => route('catalog'),
                    $category->name => route('products.index', $category->slug),
                    $product->name => route('articles.index', $product->slug),
                    'active' => $article->name
                ]
            ])
        @include('skeletons.articles.show')
        <product-lookbook :data-product="{{ $article }}" :data-model="{{ $model }}">
            <div class="v-cloak-invisible" slot="arrow-left">@icon('arrow-left', 'icon-h-3 font-weight-bold')</div>
            <div class="v-cloak-invisible" slot="arrow-right">@icon('arrow-right', 'icon-h-3 font-weight-bold')</div>
        </product-lookbook>
    </div>
@endsection
