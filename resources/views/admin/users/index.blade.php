@extends('layouts.app')

@section('title')
    User accounts - Pawer
@endsection

@section('content')
<div class="container-fluid bg-light" style="min-height: 65vh">
    <div class="row">
        <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
        @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'User accounts'
                    ]
                ])
            <h3>User accounts</h3>
            <div class="col-12 rounded-0 text-center d-flex flex-column justify-content-center align-items-center">
                <p class="futura-medium mb-0 w-75 w-md-50">Below is a list of all users who have an account on this site. Every user account can act as an administrator, which includes creating, modifying and deleting categories, products and models. There are currently <strong class="bg-yellow p-2">{{ $users->count() }}</strong> user accounts</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 rounded-0 d-flex justify-content-center">
            <table>
                <tr class="text-center">
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            @foreach($users as $user)
                <tr class="even:bg-grey-light">
                    <th class="p-2 font-weight-light">{{ $user->name }}</th>
                    <th class="p-2 font-weight-light">{{ $user->email }}</th>
                </tr>
            @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
