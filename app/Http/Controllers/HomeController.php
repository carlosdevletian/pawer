<?php

namespace Pawer\Http\Controllers;

use Pawer\Models\Article;
use Pawer\Models\Category;
use Pawer\Models\HomeImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        if($categories->count() % 3 === 1) {
            $categoryChunks = $categories->chunkAfterFirst(3);
        } else {
            $categoryChunks = $categories->chunk(3);
        }

        return view('home', [
            'carouselImages' => HomeImage::getAbsoluteAndRelativePaths(),
            'featuredArticles' => Article::featured()->byFamily()->values(),
            'categoryChunks' => $categoryChunks
        ]);
    }
}
