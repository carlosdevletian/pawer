@extends('layouts.product-menu')

@section('title')
    Catalog - Pawer
@endsection

@section('main-content')
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"
                :data-active="true"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <product
            :product="{{ json_encode([
                            'id' => 1,
                            'code' => 'code1',
                            'name' => 'KOBI',
                            'images' => [
                                [
                                    'path' => '/images/product-thumbnail-2.png',
                                    'color' => 'green',
                                ],
                                [
                                    'path' => '/images/product-thumbnail.png',
                                    'color' => 'black',
                                ],
                            ]
                        ]) }}"></product>
        </div>
    </div>
@endsection
