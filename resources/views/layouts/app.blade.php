<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('description')">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" v-cloak>
        <div v-if="pageIsLoading" class="w-100 h-100 pin position-fixed bg-overlay front d-flex justify-content-center align-items-center">
            <div class="loader"></div>
        </div>
        <div class="mb-footer">
            @include('layouts.header')

            @yield('content')

            <button @click="openOrderModal" type="button" class="btn btn-brand position-fixed cart-button shadow-lg rounded-circle text-center sq-60 m-auto " :class="{ 'bg-red-light cart-updated' : cartIsUpdating }">
                <svg height="100%" width="100%" class="text-white fill-current p-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4 2h16l-3 9H4a1 1 0 1 0 0 2h13v2H4a3 3 0 0 1 0-6h.33L3 5 2 2H0V0h3a1 1 0 0 1 1 1v1zm1 18a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm10 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
            </button>
        </div>

        @include('layouts.footer')

        <make-order-modal v-if="orderModalIsOpen" @close="closeOrderModal()"></make-order-modal>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
