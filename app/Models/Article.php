<?php

namespace Pawer\Models;

use Pawer\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasImages;

    protected $guarded = [];

    protected $casts = [
        'sizes' => 'array',
        'secondary_images' => 'array',
        'featured' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($article) {
            $name = str_slug($article->name);
            $colorValue = str_replace('#', '', $article->color);
            $article->slug = strtolower("{$name}-{$colorValue}");
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function getImagePaths()
    {
        return collect([
            $this->main_image_path,
            $this->secondary_images
        ])->flatten()->toArray();
    }

    public function getImages()
    {
        return collect([
            $this->getMainImage(),
            $this->getSecondaryImages()
        ])->flatten()->toArray();
    }

    public function getMainImage()
    {
        return $this->getImage($this->main_image_path);
    }

    public function getSecondaryImages()
    {
        return collect($this->secondary_images)->map(function($image) {
            return $this->getImage($image);
        });
    }

    public function scopeByFamily($query)
    {
        return $query->select('name', 'color', 'main_image_path', 'slug')
                    ->get()
                    ->groupBy('name');
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'main_image_path' => $this->getMainImage(),
            'images' => $this->getImages()
        ]);
    }
}
