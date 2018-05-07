@extends('layouts.app')

@section('title')
    Create an Article - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">@include('layouts.admin.breadcrumbs', [
                        'links' => [
                            'dashboard' => route('dashboard'),
                            'products' => route('admin.products.index'),
                            $product->name => route('products.edit', $product->slug),
                            'active' => 'Create a model'
                        ],
                    ])
                <h3>Create a new model for the product "{{ $product->name }}"</h3>
            </div>
            @if($errors->any())
                <div class="col-12 d-flex justify-content-center">
                    <div class="alert alert-danger w-75" role="alert">
                        <strong class="futura-medium m-0 p-0">Oops!</strong>
                        <p class="futura-medium m-0 p-0">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
        </div>
        <form class="container pb-5" method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="featured" value="1">
            <div class="row">
                <div class="col-sm-3 col-lg-2">
                    <article-secondary-images-upload class="d-flex flex-sm-column justify-content-center align-items-center"></article-secondary-images-upload>
                </div>
                <div class="col-sm-9 col-md-8 col-lg-6 col-xl-5 pl-0 pr-0 mb-5">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center mb-2 position-relative mw-100">
                            <image-upload file-name="main_image"
                                        :is-banner="false"
                                        style="width: 400px; height: 400px"
                                        :image-styles="{minWidth: '100%', minHeight: '100%'}"
                                        hover-text="Upload the main image"></image-upload>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-5 p-0 px-1">
                    <div class="pr-2 pt-2 d-flex flex-column justify-content-center align-items-center mb-2">
                        <h4 class="futura-medium p-0">
                            <label for="name" class="sr-only">Name</label>
                            <input class="mr-2 form-control bg-light rounded-0 text-center" type="string" name="name" placeholder="Model name">
                        </h4>
                        <div class="w-100 mt-2 d-flex flex-column">
                            <label for="sizes[]">Select the sizes</label>
                            @foreach($sizes as $size)
                                <p class="m-0 p-0"><input class="mr-2" type="checkbox" name="sizes[]" value="{{ $size->id }}">{{ $size->name }}</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <div>
                            <label class="futura-medium" for="color">Color</label>
                            <input type="color" name="color">
                        </div>
                        <div>
                            <label class="futura-medium" for="color_name">Color Name</label>
                            <input type="string" name="color_name">
                        </div>
                    </div>
                    <label for="description" class="futura-medium m-0">Product Detail</label>
                    <textarea name="description" class="p-2 mt-0 mb-2 form-control futura-light rounded-0 border-0" rows="4" cols="50" placeholder="Give the model a description" style="background-color: rgb(230,230,230)">
                    </textarea>
                    <button type="submit" class="btn rounded-0 clickable btn-brand w-100 mb-2">Create</button>
                </div>
            </div>
        </form>
    </div>
@endsection
