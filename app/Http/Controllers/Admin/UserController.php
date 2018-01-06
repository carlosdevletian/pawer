<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Pawer\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::get()
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);
    }
}
