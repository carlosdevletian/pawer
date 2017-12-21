<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Pawer\Models\Product;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index($productSlug)
    {
        $product = Product::whereSlug($productSlug)->firstOrFail();
        $articles = $product->articles;

        return view('articles.index', [
            'product' => $product,
            'articles' =>  $articles
        ]);
    }

    public function show($article)
    {
        $article = Article::whereSlug($article)->firstOrFail();
        $model = Article::whereName($article->name)->get();

        return view('articles.show', [
            'article' => $article,
            'model' =>  $model
        ]);
    }
}
