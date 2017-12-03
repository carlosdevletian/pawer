@extends('layouts.app')

@section('content')
<div class="container-fluid p-5 bg-light">
    <div class="row align-items-center">
        <div class="d-none d-md-block col-5">
            @svg('mono', ['style' => "background-color: transparent; filter: invert(100%); height: 100%; width: 100%"])
        </div>
        <div class="col-12 col-md-7 text-center mt-4 mt-md-0">
            <form class="pt-4 card d-flex flex-column align-items-center" method="POST" action="{{ route('login') }}" >
                {{ csrf_field() }}
                @svg('logo', ['style' => "background-color: transparent; filter: invert(100%); height: 50%; width: 50%;", 'class' => 'mb-2'])

                @if($errors->any())
                    <p class="futura-medium text-brand-primary">{{  $errors->first() }}</p>
                @endif

                <div class="d-flex form-group w-50">
                    <input class="mr-2 form-control bg-light rounded-0 text-center" type="email" name="email" placeholder="Email address">
                </div>
                <div class="d-flex form-group w-50">
                    <input class="mr-2 form-control bg-light rounded-0 text-center" type="password" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn rounded-0 clickable btn-brand mb-4 w-50">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
