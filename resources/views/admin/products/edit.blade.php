@extends('layouts.app')

@section('title')
    Edit {{ ucfirst($product->name) }} - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'products' => route('admin.products.index'),
                        'active' => $product->name
                    ]
                ])
                <h3>Edit the "{{ ucfirst($product->name) }}" Product</h3>
                <ul class="m-0">
                    <li class="no-list-style">
                        <a class="futura-medium text-dark" href="{{ route('articles.create', $product->slug) }}">Add a new model for this product</a>
                    </li>
                    <li class="no-list-style">
                        <a class="futura-medium text-dark" href="{{ route('admin.articles.index') }}">View all models</a>
                    </li>
                </ul>
            </div>
            @if($errors->any())
                <div class="col-12 d-flex justify-content-center">
                    <div class="image-upload-banner-w alert alert-danger" role="alert">
                        <strong class="futura-medium m-0 p-0">Oops!</strong>
                        <p class="futura-medium m-0 p-0">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
            <div class="col-12 d-flex justify-content-center">
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="card mb-4">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                        <!-- Placeholder hasta que Vue carge -->
                        <div class="position-relative v-cloak-block">
                            <div class="background-image image-upload-banner bg-overlay m-0 p-0"></div>
                        </div>
                        <!--  -->
                        <image-upload file-name="product_image" default-image="{{ $product->getImage() }}"></image-upload>

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Category</label>
                                        <select name="category_id" class="mr-2 form-control bg-light rounded-0 text-center">
                                            <option class="text-center" selected disabled>Select a category</option>
                                            @foreach($categories as $category)
                                            <option class="text-center" name="category_id" value="{{ $category->id }}"
                                                @if($category->id === $product->category_id) selected @endif
                                                >{{ ucfirst($category->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="text" value="{{ ucfirst($product->name) }}" name="name" placeholder="Product name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <button type="submit" class="btn rounded-0 clickable btn-brand w-100">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
