<?php

namespace Pawer\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function($product) {
            $slug = str_slug($product->name);
            $product->slug = strtolower($slug);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
