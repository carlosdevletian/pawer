<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('catalog', [
            'categories' => Category::all()
        ]);
    }
}
