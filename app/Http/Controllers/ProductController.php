<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Category;

class ProductController extends Controller
{
    public function index($categorySlug)
    {
        $category = Category::whereSlug($categorySlug)->firstOrFail();

        return view('products.index', [
            'category' => $category,
            'products' => $category->products
        ]);
    }
}
