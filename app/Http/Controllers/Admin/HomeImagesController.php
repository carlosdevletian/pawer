<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\HomeImage;
use Illuminate\Http\Request;
use Pawer\Http\Controllers\Controller;

class HomeImagesController extends Controller
{
    public function update()
    {
        HomeImage::updateAllImages(request('home_images'));

        return back();
    }
}
