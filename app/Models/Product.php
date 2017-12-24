<?php

namespace Pawer\Models;

use Pawer\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasImages;

    protected $guarded = [];

    const IMAGES_FOLDER = 'products';

    public static function boot()
    {
        parent::boot();

        static::creating(function($product) {
            $slug = str_slug($product->name);
            $product->slug = strtolower($slug);
        });
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = strtolower(str_slug($value));
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
