@extends('layouts.app')

@section('title')
    Email subscriptions - Pawer
@endsection

@section('content')
<div class="container-fluid bg-light" style="min-height: 50vh">
    <div class="row">
        <div class="col-12 text-center bg-white pt-4 mb-4 border border-top-0 border-right-0 border-left-0 pb-3">
        @include('layouts.admin.breadcrumbs', [
                    'links' => [
                        'dashboard' => route('dashboard'),
                        'active' => 'Email subscriptions'
                    ]
                ])
            <h3>Email subscriptions</h3>
            <div class="col-12 rounded-0 text-center">
                <p class="futura-medium mb-0">Below is a list of all users who have submitted their emails for updates.</p>
                <p class="futura-medium mb-0">There are currently <strong class="bg-yellow p-2">{{ $subscriptions->total() }}</strong> suscribed emails</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex flex-column align-items-center justify-content-center mb-4">
            <div class="mb-2">Order by:</div>
            <div>
                <a class="futura-medium border p-2 btn btn-brand rounded-0" href="{{ route('email-subscriptions.index', ['order' => 'date']) }}">Date submitted</a>
                <a class="futura-medium border p-2 btn btn-brand rounded-0" href="{{ route('email-subscriptions.index', ['order' => 'alphabetical']) }}">Alphabetical order</a>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($subscriptions->chunk(25) as $subscriptionChunk)
        <div class="col-6 rounded-0 d-flex justify-content-center">
            <table>
                <tr class="text-center">
                    <th>Email</th>
                    <th>Date submitted</th>
                </tr>
                @foreach($subscriptionChunk as $subscription)
                <tr class="even:bg-grey-light">
                    <th class="p-2 font-weight-light">{{ $subscription->email }}</th>
                    <th class="p-2 font-weight-light">{{ $subscription->created_at->diffForHumans() }}</th>
                    <th class="p-2 font-weight-light">
                        <form method="POST" action="{{ route('email-subscriptions.destroy', $subscription) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="clickable border-0 bg-transparent text-brand-primary" title="Remove {{ $subscription->email }} from the list">x</button>
                        </form>
                    </th>
                </tr>
                @endforeach
            </table>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $subscriptions->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
