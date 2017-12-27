@extends('layouts.app')

@section('title')
    Create a Product - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                <h3>Create a new product</h3>
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
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="card mb-4">
                    {{ csrf_field() }}

                        <!-- Placeholder hasta que Vue carge -->
                        <div class="position-relative v-cloak-block">
                            <div class="background-image image-upload-banner bg-overlay m-0 p-0"></div>
                        </div>
                        <!--  -->
                        <image-upload file-name="product_image"></image-upload>

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Category</label>
                                        <select name="category_id" class="mr-2 form-control bg-light rounded-0 text-center">
                                            <option selected disabled>Select a category</option>
                                            @foreach($categories as $category)
                                            <option name="category_id" value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="text" name="name" placeholder="Product name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <button type="submit" class="btn rounded-0 clickable btn-brand w-100">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
