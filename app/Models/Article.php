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

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByFamily($query)
    {
        $groupedByName = $query->get()->groupBy('name');

        return $groupedByName->map(function($sameName) {
            return $sameName->map(function($article, $key) {
                if($key === 0) return $article;

                return collect($article)->only(['color', 'images']);
            });
        });
    }
}
