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
            'category_id' => ['required', 'exists:categories,id'],
            'product_image' => ['required', 'image', Rule::dimensions()->minWidth(600)],
        ]);

        $category = Product::create([
            'name' => request('name'),
            'category_id' => request('category_id'),
            'image_path' => $image = request('product_image')->store('products', 'public'),
        ]);

        ImageAdded::dispatch($image);

        return redirect()->route('products.edit', $category->slug);
    }

    public function edit($productSlug)
    {
        return view('products.edit', [
            'product' => Product::whereSlug($productSlug)->firstOrFail(),
            'categories' => Category::select('id', 'name')->get()
        ]);
    }

    public function update($productId)
    {
        $product = Product::findOrFail($productId);

        request()->validate([
            'name' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'product_image' => ['nullable', 'image', Rule::dimensions()->minWidth(600)]
        ]);

        $product->update([
            'name' => request('name'),
            'category_id' => request('category_id'),
            'image_path' => $product->updateImage(request('product_image')),
        ]);

        return redirect()->route('products.edit', $product->slug);
    }
}
