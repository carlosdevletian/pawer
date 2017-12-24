<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::select('name', 'slug')->get()
        ]);
    }
}
