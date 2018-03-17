@extends('layouts.app')

@section('title')
    Create a new size - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'Create a new size'
                    ]
                ])
                <h3>Create a new size</h3>
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
                <div  class="card mb-4">
                    <form method="POST" action="{{ route('admin.sizes.store') }}">
                        {{ csrf_field() }}

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Size Name</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="text" name="name" placeholder="Size name">
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
    </div>
@endsection
