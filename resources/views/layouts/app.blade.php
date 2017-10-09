<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pawer') }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
