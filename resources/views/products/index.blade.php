@extends('layouts.product-menu')

@section('title')
    {{ ucfirst($category->name)  }} - Pawer
@endsection

@section('main-content')
    <div class="row">
    @foreach($products as $product)
        <a href="{{ route('articles.index', $product->slug) }}" class="col-12 col-lg-6  p-0 background-image d-flex align-items-start flex-column" style="background-image: url('/images/headwear.png'); height: 55vh">
            <h1 class="display-5 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase">{{ ($product->name) }}</h1>
        </a>
    @endforeach
    </div>
@endsection