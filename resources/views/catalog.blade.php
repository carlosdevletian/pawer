@extends('layouts.product-menu')

@section('title')
    Catalog - Pawer
@endsection

@section('main-content')
    @include('layouts.breadcrumbs', [
        'links' => [
            'active' => 'Catalog'
        ]
    ])
    <div class="row">
    @foreach($categories as $category)
        <a href="{{ route('products.index', $category->slug) }}" class="col-12 col-lg-6  p-0 background-image d-flex align-items-start flex-column" style="background-image: url('{{ asset($category->image_path) }}'); height: 55vh">
            <h1 class="display-5 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase">{{ ($category->name) }}</h1>
        </a>
    @endforeach
    </div>
@endsection
