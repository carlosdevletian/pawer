@extends('layouts.app')

@section('title')
    Create a Category - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                <h3>Create a category</h3>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data" class="card mb-4">
                    {{ csrf_field() }}

                        <div class="position-relative">
                            <div class="background-image image-upload-banner bg-overlay m-0 p-0" style="background-image: url('/images/placeholder-image.png')"></div>
                            <label class="position-absolute pin clickable d-flex justify-content-center align-items-center text-light bg-overlay md-hover-only m-0">
                                <input type="file" class="pseudo-hidden" name="category_image">
                                <div>
                                    <p class="futura-medium m-0 text-bold">Assign an image to the category</p>
                                    <div class="text-center" style="font-size: 2em">@svg('camera')</div>
                                </div>
                            </label>
                        </div>
                        <div class="card-section">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="text" name="name" placeholder="Category name">
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
