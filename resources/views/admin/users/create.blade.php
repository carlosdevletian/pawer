@extends('layouts.app')

@section('title')
    Create a user account - Pawer
@endsection

@section('content')
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
                @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'Create a user account'
                    ]
                ])
                <h3>Create a new user account</h3>
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
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="card mb-4 w-75 w-md-50">
                    {{ csrf_field() }}

                        <div class="card-section">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">User Name</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="text" name="name" placeholder="User name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="email" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm the password</label>
                                        <input class="mr-2 form-control bg-light rounded-0 text-center" type="password" name="password_confirmation" placeholder="Confirm the password">
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
