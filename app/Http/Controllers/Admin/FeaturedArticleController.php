<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Article;
use Illuminate\Http\Request;
use Pawer\Http\Controllers\Controller;

class FeaturedArticleController extends Controller
{
    public function store()
    {
        $article = Article::findOrFail(request('article_id'));

        Article::whereName($article->name)
                ->get()
                ->each
                ->update(['featured' => true]);

        return redirect()->back();
    }

    public function destroy()
    {
        $article = Article::findOrFail(request('article_id'));

        Article::whereName($article->name)
                ->get()
                ->each
                ->update(['featured' => false]);

        return redirect()->back();
    }
}
