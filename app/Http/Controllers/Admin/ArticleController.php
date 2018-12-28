<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Size;
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
            'sizes' => Size::get(),
            'product' => Product::whereSlug($productSlug)->firstOrFail()
        ]);
    }

    public function store()
    {
        request()->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
            'color' => ['required'],
            'color_name' => ['required'],
            'code' => ['nullable'],
            'sizes' => ['required', 'array'],
            'sizes.*' => ['exists:sizes,id'],
            'main_image' => ['required', 'image', Rule::dimensions()->minWidth(600)],
            'secondary_images' => ['nullable', 'array'],
            'secondary_images.*' => ['image', Rule::dimensions()->minWidth(600)]
        ]);

        $article = Article::create([
            'product_id' => request('product_id'),
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'color' => request('color'),
            'color_name' => request('color_name'),
            'code' => request('code'),
            'main_image_path' => $mainImage = request('main_image')->store('articles', 'public'),
            'secondary_images' => $secondaryImages = collect(request('secondary_images'))->map(function($image) {
                return $image->store('articles', 'public');
            }),
            'featured' => request('featured')
        ]);

        $article->sizes()->attach(Size::find(request('sizes')));

        ImageAdded::dispatch($article->getImagePaths());

        return redirect()->route('articles.edit', $article->slug);
    }

    public function edit($articleSlug)
    {
        return view('admin.articles.edit', [
            'sizes' => Size::get(),
            'article' => Article::whereSlug($articleSlug)->firstOrFail()
        ]);
    }

    public function update($articleId)
    {
        $article = Article::findOrFail($articleId);

        request()->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required'],
            'color' => ['required'],
            'color_name' => ['required'],
            'code' => ['nullable'],
            'sizes' => ['required', 'array'],
            'sizes.*' => ['exists:sizes,id'],
            'main_image' => ['nullable', 'image', Rule::dimensions()->minWidth(600)],
            'secondary_images' => ['nullable', 'array'],
            'secondary_images.*' => ['nullable', new ImageFileOrUrl($article)],
            'sold_out' => ['nullable'],
            'on_sale' => ['nullable'],
            'sale_price' => ['nullable', 'required_with:on_sale', 'numeric', 'min:0.01', 'bail', 'lt:price'],
        ], [
            'sale_price.lt' => "The sale price must be less than the item's price"
        ]);

        $article->update([
            'product_id' => request('product_id'),
            'name' => request('name'),
            'description' => request('description'),
            'color' => request('color'),
            'color_name' => request('color_name'),
            'code' => request('code'),
            'main_image_path' => $article->updateMainImage(request('main_image')),
            'secondary_images' => $article->updateSecondaryImages(request('secondary_images')),
            'featured' => request('featured'),
            'price' => request('price'),
            'sold_out' => request('sold_out') === null ? false : true,
            'on_sale' => request('on_sale') === null ? false : true,
            'sale_price' => request('sale_price')
        ]);

        $article->sizes()->sync(Size::find(request('sizes')));

        return redirect()->route('articles.edit', $article->slug);
    }

    public function destroy($articleId)
    {
        $article = Article::findOrFail($articleId);

        $article->delete();

        return redirect()->route('admin.articles.index');
    }
}
