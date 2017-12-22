<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Category;
use Illuminate\Http\Request;
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
            'category_image' => ['required', 'image', Rule::dimensions()->minWidth(400)->ratio(11/8.5)]
        ]);

        Category::create([
            'name' => request('name'),
            'image_path' => request('category_image')->store('categories', 'public')
        ]);
    }
}
