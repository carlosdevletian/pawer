<?php

namespace Pawer\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $casts = [
        'sizes' => 'array',
        'images' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($article) {
            $name = str_slug($article->name);
            $article->slug = strtolower("{$name}-{$article->color}");
        });
    }
}
