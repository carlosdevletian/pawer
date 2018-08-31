<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Illuminate\Validation\Rule;
use Pawer\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category:id,name')->get()->groupBy('category.name')
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::select('id', 'name')->get()
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'product_image' => ['required', 'image'],
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
        return view('admin.products.edit', [
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
            'product_image' => ['nullable', 'image']
        ]);

        $product->update([
            'name' => request('name'),
            'category_id' => request('category_id'),
            'image_path' => $product->updateImage(request('product_image'), $product->image_path),
        ]);

        return redirect()->route('products.edit', $product->slug);
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
