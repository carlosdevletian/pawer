<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        return view('catalog', [
            'categories' => Category::all()
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'category_image' => ['required', 'image', Rule::dimensions()->minWidth(600)->ratio(11/8.5)]
        ]);

        Category::create([
            'name' => request('name'),
            'image_path' => $image = request('category_image')->store('categories', 'public')
        ]);

        ImageAdded::dispatch($image);
    }
}
