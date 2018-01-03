@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row" style="min-height: 95vh">
            <div class="d-none d-lg-block col-lg-2 p-0">
                <nav class="nav flex-column p-4 align-items-center" style="background-color: rgb(230,230,230); height:100% ">
                    <div class="p-2">
                        @foreach($categories as $category)
                            <ul class="p-0">
                                <li class="no-list-style">
                                    <a class="nav-link text-dark"
                                        href="{{ route('products.index', $category->slug) }}"
                                        title="{{ ucfirst($category->name) }}"><h6 class="futura-medium text-uppercase">{{ $category->name }}</h6></a>
                                </li>
                                @foreach($category->products as $product)
                                    <li class="no-list-style">
                                        <a class="nav-link p-0 pl-4 text-dark text-capitalize"
                                            href="{{ route('articles.index', $product->slug) }}"
                                            title="{{ ucfirst($product->name) }}">{{ $product->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-12 col-lg-10">
                @yield('main-content')
            </div>
        </div>
    </div>
@endsection