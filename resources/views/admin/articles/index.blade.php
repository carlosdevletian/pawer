@extends('layouts.app')

@section('title')
    All products - Pawer
@endsection

@section('content')
<div class="container-fluid bg-light" style="min-height: 50vh">
    <div class="row">
        <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
        @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'models'
                    ]
                ])
            <h3>Select the model you would like to edit</h3>
        </div>
    </div>
    <div class="row">
        @foreach($categories as $category)
            <div class="col-12 col-md-4 p-3 rounded-0">
                <h3 class="text-uppercase text-center">{{ $category->name }}</h3>
                <hr>
                @foreach($category->products as $product)
                <div class="col-12 text-center mb-5">
                    <div class="card rounded-0 p-3 mt-4">
                        <h5 class="text-capitalize text-dark">{{ $product->name }}</h5>
                        @foreach($product->articles as $article)
                            <p class="text-capitalize m-0 p-0 d-flex">
                                <span class="mr-2 align-self-center" style="width: 10px; height: 10px; background-color: {{ $article->color }}"></span>
                                <a class="futura-medium" href="{{ route('articles.edit', $article->slug) }}">{{ $article->name }}</a>
                            </p>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection
