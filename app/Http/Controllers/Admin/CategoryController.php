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
            'category_image' => ['required', 'image'],
            'category_home_image' => ['required', 'image'],
            'name' => ['required'],
        ], ['category_image*' => "Make sure you've selected an image that is at least 600px wide"]);

        $category = Category::create([
            'name' => request('name'),
            'image_path' => $image = request('category_image')->storePublicly('categories', 'public'),
            'home_image_path' => $homeImage = request('category_home_image')->storePublicly('categories', 'public')
        ]);

        ImageAdded::dispatch($image);
        ImageAdded::dispatch($homeImage);

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
            'category_image' => ['nullable', 'image'],
            'category_home_image' => ['nullable', 'image'],
        ]);

        $category->update([
            'name' => request('name'),
            'image_path' => $category->updateImage(
                request('category_image'),
                $category->image_path
            ),
            'home_image_path' => $category->updateImage(
                request('category_home_image'),
                $category->home_image_path
            ),
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
