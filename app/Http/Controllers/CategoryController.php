<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return redirect()->route('products.index', [
            'category' => Category::get()->random()->slug
        ]);
    }
}
