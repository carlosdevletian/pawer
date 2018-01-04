<?php

namespace Pawer\Http\Controllers;

use Illuminate\Http\Request;
use Pawer\Models\EmailSubscription;

class EmailSubscriptionController extends Controller
{
    public function store()
    {
        request()->validate([
            'email' => ['required', 'email']
        ]);

        EmailSubscription::create([
            'email' => request('email')
        ]);
    }
}
