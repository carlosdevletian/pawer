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
        <div class="container pb-5">
            <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="sold_out" value=1 {{ $article->isSoldOut() ? 'checked' : '' }}>
                                <label class="form-check-label" for="inlineRadio1">Sold Out</label>
                            </div>
                            <div class="w-100 mt-2 d-flex flex-column">
                                <label for="sizes[]">Select the sizes</label>
                                @foreach($sizes as $size)
                                    <p class="m-0 p-0">
                                        <input class="mr-2"
                                            type="checkbox"
                                            name="sizes[]"
                                            value="{{ $size->id }}"
                                            {{ $article->sizes->contains($size) ? 'checked' : '' }}>{{ $size->name }}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <div>
                                <label class="futura-medium" for="color">Color</label>
                            <input type="color" name="color" value="{{ $article->color }}">
                            </div>
                            <div>
                                <label class="futura-medium" for="color_name">Color Name</label>
                                <input type="string" name="color_name" value="{{ $article->color_name }}">
                            </div>
                        </div>
                        <div class="futura-medium mb-2">
                            <label for="price">Price</label>
                            <input class="mr-2 form-control bg-light rounded-0" type="number" step=0.01 name="price" placeholder="Example: 13.99" value="{{ $article->price }}">
                        </div>
                        <div class="futura-medium mb-2">
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="checkbox" name="on_sale" value=1 {{ $article->isOnSale() ? 'checked' : '' }}>
                                    <label class="form-check-label">On Sale</label>
                                </div>
                                <div class="d-flex">
                                    <label class="futura-medium" for="sale_price">Sale price</label>
                                    <input class="form-control bg-light rounded-0"
                                        type="number"
                                        step=0.01
                                        name="sale_price"
                                        placeholder="Example: 13.99"
                                        value="{{ $article->sale_price >= 0.01 ? $article->sale_price : null }}">
                                </div>
                            </div>
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
            <div class="row">
                <div class="col-sm-3 col-lg-2"></div>
                <div class="col-sm-9 col-md-8 col-lg-6 col-xl-5"></div>
                <delete-button class="col-lg-4 col-xl-5 d-flex flex-column align-items-end">
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
