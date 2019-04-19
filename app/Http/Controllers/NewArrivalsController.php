<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Illuminate\Http\Request;

class NewArrivalsController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->take(10)->byFamily();

        return view('new-arrivals', [
            'articles' => $articles
        ]);
    }
}
