@extends('layouts.product-menu')

@section('main-content')
    <div class="container-fluid">
        <div class="row pt-4 pb-5 pl-5">
            <div class="col-12 pl-0">
                <small class="futura-medium" style="color: rgb(179,179,179)">SHOP > HEADWEAR > SNAPBACKS</small>
            </div>
        </div>
        <form method="POST" action="{{ route('test') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-3 col-lg-2">
                    <article-secondary-images-upload class="d-flex flex-sm-column justify-content-center align-items-center"></article-secondary-images-upload>
                </div>
                <div class="col-sm-9 col-md-8 col-lg-6 col-xl-5 pl-0 pr-0">
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
                        <div class="w-100 mt-2">
                            <select name="sizes" class="mr-2 form-control bg-light rounded-0 text-center mb-2">
                                <option selected disabled>Select a size</option>
                                <option class="text-center" name="sizes[]">SM</option>
                                <option class="text-center" name="sizes[]">MD</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="futura-medium" for="color">Color</label>
                        <input type="color" name="color">
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
