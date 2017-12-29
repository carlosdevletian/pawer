<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Pawer\Models\HomeImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'carouselImages' => HomeImage::getAbsoluteAndRelativePaths(),
            'featuredArticles' => Article::featured()->byFamily()->values()
        ]);
    }
}
