@extends('layouts.app')

@section('title')
    All products - Pawer
@endsection

@section('content')
<div class="container pb-5">
    <div class="row">
        <div class="col-12 text-center bg-white pt-4 mb-4 pb-3">
            <h3>Select the product you would like to edit</h3>
        </div>
    </div>
    <div class="row">
        @foreach($products as $category => $product)
        <div class="col-12 col-lg-4 rounded-0 text-center">
            <div class="card p-3 mt-4">
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
