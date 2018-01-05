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
                        'active' => 'Products'
                    ]
                ])
            <h3>Select a product</h3>
        </div>
    </div>
    <div class="row pb-5">
        @foreach($products as $category => $product)
        <div class="col-12 col-lg-4 text-center">
            <div class="card rounded-0 p-3 mt-4">
                <h4 class="text-capitalize">{{ $category }}</h4>
                @foreach($product as $p)
                    <p class="text-capitalize m-0 p-0"><a class="futura-medium" href="{{ route('products.edit', $p->slug) }}">{{ $p->name }}</a></p>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
