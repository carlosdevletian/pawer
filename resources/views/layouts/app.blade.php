<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pawer') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        @font-face {
            font-family: Koyu Italic;
            src: url('fonts/Futura-Koyu-Italic.ttf');
        }
        @font-face {
            font-family: FuturaLight;
            src: url('fonts/FuturaLight.ttf');
        }
        @font-face {
            font-family: Futura Condensed;
            src: url('fonts/FuturaStd-Condensed.otf');
        }
        @font-face {
            font-family: Futura Medium;
            src: url('fonts/FuturaStd-Medium.otf');
        }
        .fut-con-med {
            font-family: Futura Condensed;
        }
        .futura-medium {
            font-family: Futura Medium;
        }
        .futura-light {
            font-family: FuturaLight;
        }
        h1,h2,h3,h4,h5 {
            font-family: Koyu Italic;
        }
        p, a {
            font-family: FuturaLight;
        }
        a:hover {
            text-decoration: none;
        }
        .text-brand-primary {
            color: rgb(235, 51, 35)
        }
        .bg-brand {
            background-color: rgb(235, 51, 35)
        }
        .btn-brand {
            border-color: rgb(235, 51, 35);
            color: white;
            background-color: rgb(235, 51, 35);
        }
        .btn-brand:hover {
            background-color: rgb(260, 51, 35);
        }
        .btn-transparent {
            background-color: transparent;
        }
        .ls-1 {
            letter-spacing: 1px;
        }
        .clickable:hover {
            cursor: pointer;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 285px;
        }
        .background-image {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
            width: 100%;
        }
        .icon {
            display: inline-block;
            height: 1.25em;
            width: 1.25em;
            fill: currentColor;
            color: white;
            vertical-align: text-bottom;
        }
        .icon-w-1 {
            width: 1em;
        }
        .icon-w-2 {
            width: 4em;
        }
        .icon-w-3 {
            width: 8em;
        }
        .icon-h-1 {
            height: 1em;
        }
        .icon-h-2 {
            height: 4em;
        }
        .icon-h-3 {
            height: 8em;
        }
        .opacity-1 {
            opacity: .3;
        }
        .opacity-2 {
            opacity: .5;
        }
        .opacity-3 {
            opacity: .7;
        }
        .mb-footer {
            margin-bottom: 285px;
        }
        .fit-to-parent {
            max-width: 100%;
            max-height: 100%
        }
        html {
            position: relative;
            min-height: 100%;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="mb-footer">
            @include('layouts.header')

            @yield('content')
        </div>

        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
