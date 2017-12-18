<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
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
