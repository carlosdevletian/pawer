<?php

namespace Pawer\Http\Controllers;

use Pawer\Cart;
use Illuminate\Http\Request;
use Pawer\Mail\SendOrderMail;
use Illuminate\Support\Facades\Mail;

class EmailOrderController extends Controller
{
    public function handle()
    {
        Mail::to('orders@paw3r.com')->queue(new SendOrderMail(
            request('email'),
            Cart::items()
        ));
    }
}
