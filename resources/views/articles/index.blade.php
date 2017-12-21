@extends('layouts.product-menu')

@section('title')
    {{ ucfirst($product->name)  }} - Pawer
@endsection

@section('main-content')
    <div class="row">
    @foreach($articles as $article)
        <a href="{{ route('articles.show', $article->slug) }}" class="col-12 col-lg-6  p-0 background-image d-flex align-items-start flex-column" style="background-image: url('/images/headwear.png'); height: 55vh">
            <h1 class="display-5 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase">{{ ($article->name) }}</h1>
        </a>
    @endforeach
    </div>
@endsection