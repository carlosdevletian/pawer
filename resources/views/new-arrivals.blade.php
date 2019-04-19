@extends('layouts.product-menu')

@section('title')
    New Arrivals - Pawer
@endsection

@section('main-content')
    <div class="row h-35vh position-relative">
        <div class="col-12 bg-white">
        </div>
        <h4 class="display-4 mt-auto text-brand-primary font-italic pr-5 mb-0 ml-4 text-uppercase position-absolute bottom-0">
            New Arrivals
        </h4>
    </div>

    @include('layouts.breadcrumbs', [
        'links' => [
            'Home' => route('home'),
            'active' => 'New Arrivals'
        ]
    ])
    <div class="row">
    @foreach($articles as $name => $article)
        @component('articles.thumbnail')
            <product :data-product="{{ $article }}"
                    :data-active="true"
                    :with-link="true"></product>
        @endcomponent
    @endforeach
    </div>
@endsection