@extends('layouts.app')

@section('title')
    Admin - Pawer
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 col-md-4 p-3 rounded-0">
            <h3>Categories</h3>
            <hr>
            <p class="m-0"><a class="futura-medium" href="{{ route('categories.create') }}">Create a new category</a></p>
            <p class="m-0"><a class="futura-medium" href="{{ route('admin.categories.index') }}">View all categories</a></p>
        </div>
        <div class="col-12 col-md-4 p-3 rounded-0">
            <h3>Products</h3>
            <hr>
            <p class="m-0"><a class="futura-medium" href="{{ route('products.create') }}">Create a new product</a></p>
            <p class="m-0"><a class="futura-medium" href="{{ route('admin.products.index') }}">View all products</a></p>
        </div>
        <div class="col-12 col-md-4 p-3 rounded-0">
            <h3>Models</h3>
            <hr>
            <p class="m-0"><a class="futura-medium" href="{{ route('admin.products.index') }}">Create a new model</a></p>
            <p class="m-0"><a class="futura-medium" href="{{ route('admin.articles.index') }}">View all models</a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-4 p-3 rounded-0">
            <h3>Users</h3>
            <hr>
            <p class="m-0"><a class="futura-medium" href="{{ route('categories.create') }}">Create a new user</a></p>
            <!-- <p class="m-0"><a class="futura-medium" href="#">Update an existing category</a></p> -->
        </div>
    </div>
</div>
@endsection
