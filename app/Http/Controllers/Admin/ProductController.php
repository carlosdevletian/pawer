<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Product;
use Illuminate\Http\Request;
use Pawer\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category:id,name')->get()->groupBy('category.name')
        ]);
    }
}
