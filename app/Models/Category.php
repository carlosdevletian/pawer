<?php

namespace Pawer\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function($category) {
            $slug = str_slug($category->name);
            $category->slug = strtolower($slug);
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
