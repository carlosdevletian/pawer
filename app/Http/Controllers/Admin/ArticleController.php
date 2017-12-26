<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Article;
use Pawer\Models\Product;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Illuminate\Validation\Rule;
use Pawer\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function create($productSlug)
    {
        return view('admin.articles.create', [
            'product' => Product::whereSlug($productSlug)->firstOrFail()
        ]);
    }

    public function store()
    {
        request()->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required'],
            'description' => ['required'],
            'color' => ['required'],
            'code' => ['nullable'],
            'sizes' => ['required', 'array'],
            'main_image' => ['required', 'image', Rule::dimensions()->minWidth(600)],
            'secondary_images' => ['nullable', 'array'],
            'secondary_images.*' => ['image', Rule::dimensions()->minWidth(600)]
        ]);

        $article = Article::create([
            'product_id' => request('product_id'),
            'name' => request('name'),
            'description' => request('description'),
            'color' => request('color'),
            'code' => request('code'),
            'sizes' => request('sizes'),
            'main_image_path' => $mainImage = request('main_image')->store('articles', 'public'),
            'secondary_images' => $secondaryImages = collect(request('secondary_images'))->map(function($image) {
                return $image->store('articles', 'public');
            }),
            'featured' => request('featured')
        ]);

        ImageAdded::dispatch($article->getImagePaths());

        return redirect()->route('articles.show', $article->slug);
    }
}
