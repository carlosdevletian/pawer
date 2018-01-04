<?php

namespace Pawer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Pawer\Models\EmailSubscription;
use Pawer\Http\Controllers\Controller;

class EmailSubscriptionController extends Controller
{
    public function index()
    {
        if(request()->has('order') && request('order') === 'alphabetical') {
            $subscriptions = EmailSubscription::orderBy('email')->paginate(50);
        } else {
            $subscriptions = EmailSubscription::paginate(50);
        }

        return view('admin.email-subscriptions.index', [
            'subscriptions' => $subscriptions,
        ]);
    }

    public function destroy($subscriptionId)
    {
        $subscription = EmailSubscription::findOrFail($subscriptionId);

        $subscription->delete();

        return back();
    }
}
