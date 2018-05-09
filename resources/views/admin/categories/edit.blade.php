@extends('layouts.app')

@section('title')
    Edit {{ ucfirst($category->name) }} - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                 @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'categories' => route('admin.categories.index'),
                        'active' => $category->name
                    ]
                ])
                <h3>Edit the "{{ ucfirst($category->name) }}" Category</h3>
            </div>
            @if($errors->any())
                <div class="col-12 d-flex justify-content-center">
                    <div class="image-upload-banner-w alert alert-danger" role="alert">
                        <strong class="futura-medium m-0 p-0">Oops!</strong>
                        <p class="futura-medium m-0 p-0">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
            <div class="col-12 col-md-8 offset-md-2 d-flex flex-column align-items-center justify-content-center">
                <div class="card mb-4">
                    <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <h5>Category Name</h5>
                                    Select a name for the category
                                </div>
                                <div class="col-12 col-sm-8  d-flex flex-column justify-content-center">
                                    <input class="mr-2 form-control bg-light rounded-0 text-center" type="text" value="{{ $category->name }}" name="name" placeholder="Category name">
                                </div>
                            </div>
                        </div>

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <h5>Home image</h5>
                                    This image will show up on the home page when this category is displayed.
                                </div>
                                <div class="col-12 col-sm-8">
                                    <!-- Placeholder hasta que Vue carge -->
                                    <div class="position-relative v-cloak-block">
                                        <div class="background-image image-upload-banner bg-overlay m-0 p-0"></div>
                                    </div>
                                    <image-upload :image-styles="{'width':'100%'}" file-name="category_home_image" default-image="{{ $category->getHomeImage() }}"></image-upload>
                                </div>
                            </div>
                        </div>

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12 col-sm-4">
                                    <h5>Catalog image</h5>
                                    This is the catalog image. Whenever the category is displayed (except for the home page), this will be the associated image.
                                </div>
                                <div class="col-12 col-sm-8">
                                    <!-- Placeholder hasta que Vue carge -->
                                    <div class="position-relative v-cloak-block">
                                        <div class="background-image image-upload-banner bg-overlay m-0 p-0"></div>
                                    </div>
                                    <image-upload :image-styles="{'width':'100%'}" file-name="category_image" default-image="{{ $category->getImage() }}"></image-upload>
                                </div>
                            </div>
                        </div>

                        <div class="card-section pb-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <button type="submit" class="btn rounded-0 clickable btn-brand w-100">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="pr-4 pb-2 align-self-end">
                        <delete-button>
                            <form class="v-cloak-invisible" method="POST" action="{{ route('categories.destroy', $category) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn btn-brand clickable" type="submit">Delete this category</button>
                            </form>
                        </delete-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
