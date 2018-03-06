<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Illuminate\Validation\Rule;
use Pawer\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::select('name', 'slug')->get()
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store()
    {
        request()->validate([
            'category_image' => ['required', 'image', Rule::dimensions()->minWidth(600)],
            'name' => ['required'],
        ], ['category_image*' => "Make sure you've selected an image that is at least 600px wide"]);

        $category = Category::create([
            'name' => request('name'),
            'image_path' => $image = request('category_image')->storePublicly('categories', 'public')
        ]);

        ImageAdded::dispatch($image);

        return redirect()->route('categories.edit', $category->slug);
    }

    public function edit($categorySlug)
    {
        return view('admin.categories.edit', [
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

    public function destroy($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
