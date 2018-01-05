@extends('layouts.app')

@section('title')
    Edit {{ $article->name }} - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                <div class="d-flex justify-content-between mb-4">
                    @include('layouts.admin.breadcrumbs', [
                        'links' => [
                            'dashboard' => route('dashboard'),
                            'models' => route('admin.articles.index'),
                            'active' => $article->name
                        ],
                    ])
                    <a class="btn rounded-0 clickable btn-brand" style="max-height: 40px" href="{{ route('articles.show', $article->slug) }}">User's view</a>
                </div>
                <h3 class="d-inline-block mb-0">Edit the "{{ $article->name }}" Model</h3>
                @include('admin.articles.featured', ['article' => $article])
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
        <form class="container pb-5" method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{ $article->product->id }}">
            <input type="hidden" name="featured" value="1">
            <div class="row">
                <div class="col-sm-3 col-lg-2">
                    <edit-article-secondary-images
                        class="d-flex flex-sm-column justify-content-center align-items-center"
                        :data-secondary-images="{{ json_encode($article->getSecondaryWithRelative()) }}"
                    ></edit-article-secondary-images>
                </div>
                <div class="col-sm-9 col-md-8 col-lg-6 col-xl-5 pl-0 pr-0 mb-5">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center mb-2 position-relative mw-100">
                            <image-upload file-name="main_image"
                                        :is-banner="false"
                                        style="width: 400px; height: 400px"
                                        :image-styles="{minWidth: '100%', minHeight: '100%'}"
                                        default-image="{{ $article->getMainImage() }}"
                                        hover-text="Upload the main image"></image-upload>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-5 p-0 px-1">
                    <div class="pr-2 pt-2 d-flex flex-column justify-content-center align-items-center mb-2">
                        <h4 class="futura-medium p-0">
                            <label for="name" class="sr-only">Name</label>
                            <input class="mr-2 form-control bg-light rounded-0 text-center" type="string" value="{{ $article->name }}" name="name" placeholder="Model name">
                        </h4>
                        <div class="w-100 mt-2 d-flex flex-column">
                            <label for="sizes[]">Select the sizes</label>
                            <p class="m-0 p-0"><input class="mr-2" type="checkbox" name="sizes[]" value="SM">Small</p>
                            <p class="m-0 p-0"><input class="mr-2" type="checkbox" name="sizes[]" value="MD">Medium</p>
                            <p class="m-0 p-0"><input class="mr-2" type="checkbox" name="sizes[]" value="LG">Large</p>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="futura-medium" for="color">Color</label>
                        <input type="color" name="color" value="{{ $article->color }}">
                    </div>
                    <label for="description" class="futura-medium m-0">Product Detail</label>
                    <textarea name="description"
                            value="{{ $article->description }}"
                            class="p-2 mt-0 mb-2 form-control futura-light rounded-0 border-0"
                            rows="4"
                            cols="50"
                            placeholder="Give the model a description"
                            style="background-color: rgb(230,230,230)">{{ $article->description }}</textarea>
                    <button type="submit" class="btn rounded-0 clickable btn-brand w-100 mb-2">Save changes</button>
                </div>
            </div>
        </form>
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-lg-2"></div>
                <div class="col-sm-9 col-md-8 col-lg-6 col-xl-5"></div>
                <delete-button class="col-lg-4 col-xl-5 d-flex flex-column align-items-end mt-md-neg-50 mt-lg-neg-115">
                    <form class="v-cloak-invisible" method="POST" action="{{ route('articles.destroy', $article) }}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button class="btn btn-brand clickable" type="submit">Delete this article</button>
                    </form>
                </delete-button>
            </div>
        </div>
    </div>
@endsection
