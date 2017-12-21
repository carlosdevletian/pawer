<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'featuredArticles' => Article::featured()->byFamily()->values()
        ]);
    }
}
