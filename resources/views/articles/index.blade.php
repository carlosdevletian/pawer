@extends('layouts.product-menu')

@section('title')
    {{ ucfirst($product->name)  }} - Pawer
@endsection

@section('main-content')
    <div class="row">
    @foreach($articles as $name => $article)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :data-product="{{ $article }}"
            :data-active="true"
            link-to="{{ route('articles.show', $article->first()->slug) }}"></product>
        </div>
    @endforeach
    </div>
@endsection