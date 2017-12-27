@extends('layouts.app')

@section('title')
    All categories - Pawer
@endsection

@section('content')
<div class="container-fluid bg-light" style="min-height: 50vh">
    <div class="row">
        <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
        @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'Categories'
                    ]
                ])
            <h3>Select the category you would like to edit</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 rounded-0 text-center">
            @foreach($categories as $category)
            <h4 class="text-capitalize p-0"><a class="koyu-italic" href="{{ route('categories.edit', $category->slug) }}">{{ $category->name }}</a></h4>
            @endforeach
        </div>
    </div>
</div>
@endsection
