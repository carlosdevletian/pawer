<?php

namespace Pawer\Providers;

use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.product-menu', function ($view) {
            $view->with('categories', Category::with('products:category_id,name,slug')->select('id', 'name', 'slug')->get());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
