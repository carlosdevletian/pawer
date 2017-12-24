<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Illuminate\Validation\Rule;

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

    public function create()
    {
        return view('products.create', [
            'categories' => Category::select('id', 'name')->get()
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'product_image' => ['required', 'image', Rule::dimensions()->minWidth(600)],
            'category_id' => ['required']
        ]);

        $category = Product::create([
            'name' => request('name'),
            'image_path' => $image = request('product_image')->store('products', 'public'),
            'category_id' => request('category_id')
        ]);

        ImageAdded::dispatch($image);

        return back();
        // return redirect()->route('categories.edit', $category->slug);
    }
}
