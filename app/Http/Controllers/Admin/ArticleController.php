<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Article;
use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Http\Request;
use Pawer\Events\ImageAdded;
use Illuminate\Validation\Rule;
use Pawer\Rules\ImageFileOrUrl;
use Pawer\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products.articles' => function($query) {
            $query->select('name', 'color', 'slug', 'product_id');
        }])->get();

        return view('admin.articles.index', [
            'categories' => $categories
        ]);
    }

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

        return redirect()->route('articles.edit', $article->slug);
    }

    public function edit($articleSlug)
    {
        return view('admin.articles.edit', [
            'article' => Article::whereSlug($articleSlug)->firstOrFail()
        ]);
    }

    public function update($articleId)
    {
        $article = Article::findOrFail($articleId);

        request()->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required'],
            'description' => ['required'],
            'color' => ['required'],
            'code' => ['nullable'],
            'sizes' => ['required', 'array'],
            'main_image' => ['nullable', 'image', Rule::dimensions()->minWidth(600)],
            'secondary_images' => ['nullable', 'array'],
            'secondary_images.*' => ['nullable', new ImageFileOrUrl($article)]
        ]);

        $article->update([
            'product_id' => request('product_id'),
            'name' => request('name'),
            'description' => request('description'),
            'color' => request('color'),
            'code' => request('code'),
            'sizes' => request('sizes'),
            'main_image_path' => $article->updateMainImage(request('main_image')),
            'secondary_images' => $article->updateSecondaryImages(request('secondary_images')),
            'featured' => request('featured'),
        ]);

        return redirect()->route('articles.edit', $article->slug);
    }

    public function destroy($articleId)
    {
        $article = Article::findOrFail($articleId);

        $article->delete();

        return redirect()->route('admin.articles.index');
    }
}
