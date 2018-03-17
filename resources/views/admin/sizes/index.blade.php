@extends('layouts.app')

@section('title')
    Sizes - Pawer
@endsection

@section('content')
<div class="container-fluid bg-light" style="min-height: 50vh">
    <div class="row">
        <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
        @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'Sizes'
                    ]
                ])
            <h3>Sizes</h3>
            <div class="col-12 rounded-0 text-center">
                <p class="futura-medium mb-0">Below is a list of all sizes that can be assigned to existing models</p>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($sizes as $size)
        <div class="col-12 rounded-0 d-flex justify-content-center">
            <a href="{{ route('admin.sizes.edit', $size) }}" class="text-capitalize">{{ $size->name }}</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
