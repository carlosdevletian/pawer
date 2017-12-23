<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('catalog', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store()
    {
        request()->validate([
            'category_image' => ['required', 'image', Rule::dimensions()->minWidth(600)],
            'name' => ['required'],
        ], ['category_image*' => "Make sure you've selected an image that is at least 600px wide"]);

        Category::create([
            'name' => request('name'),
            'image_path' => $image = request('category_image')->store('categories')
        ]);

        ImageAdded::dispatch($image);

        return back();
    }

    public function edit($categorySlug)
    {
        return view('categories.edit', [
            'category' => Category::whereSlug($categorySlug)->firstOrFail()
        ]);
    }

    public function update($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        request()->validate([
            'name' => ['required'],
            'category_image' => ['nullable', 'image', Rule::dimensions()->minWidth(600)]
        ]);

        $category->update([
            'name' => request('name'),
            'image_path' => $category->updateImage(request('category_image'))
        ]);

        return redirect()->route('categories.edit', $category->slug);
    }
}
