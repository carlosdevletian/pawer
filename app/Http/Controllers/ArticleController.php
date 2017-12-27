<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Pawer\Models\Product;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index($productSlug)
    {
        $product = Product::whereSlug($productSlug)->with('category:id,name,slug')->firstOrFail();
        $articles = $product->articles()->byFamily();

        return view('articles.index', [
            'product' => $product,
            'articles' =>  $articles
        ]);
    }

    public function show($article)
    {
        $article = Article::whereSlug($article)->with('product:id,name,slug,category_id')->firstOrFail();
        $model = Article::whereName($article->name)->get();
        $product = $article->product;

        return view('articles.show', [
            'article' => $article,
            'model' =>  $model,
            'product' => $product,
            'category' => $product->load('category:id,name,slug')->category
        ]);
    }
}
