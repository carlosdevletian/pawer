<?php

namespace Pawer\Providers;

use Pawer\Models\Product;
use Pawer\Models\Category;
use Illuminate\Support\Collection;
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

        Collection::macro('chunkAfterFirst', function($chunkSize) {
            $first = collect($this->items)->first();
            $rest = collect($this->items)->except(1)->chunk($chunkSize);
            return collect([$first])->chunk(1)->concat($rest);
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
