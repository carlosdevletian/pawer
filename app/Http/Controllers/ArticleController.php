<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($article)
    {
        return view('articles.show', [
            'article' => Article::where('name', $article)->firstOrFail()
        ]);
    }
}
