<?php

namespace Pawer\Http\Controllers;

use Illuminate\Http\Request;
use Pawer\Models\EmailSuscription;

class EmailSuscriptionController extends Controller
{
    public function store()
    {
        request()->validate([
            'email' => ['required', 'email']
        ]);

        EmailSuscription::create([
            'email' => request('email')
        ]);
    }
}
