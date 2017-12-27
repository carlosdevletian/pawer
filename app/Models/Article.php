<?php

namespace Pawer\Models;

use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
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

    const IMAGES_FOLDER = 'articles';

    public static function boot()
    {
        parent::boot();

        static::saving(function($article) {
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

    public function updateMainImage($newImage)
    {
        return $this->updateImage($newImage, $this->main_image_path);
    }

    public function updateSecondaryImages($secondaryImages)
    {
        $this->deleteUnwanted(
            $this->unwantedImages(
                $kept = $this->keptImages($secondaryImages)
            )
        );

        $newImages = $this->storeImages(
            $this->filesFrom($secondaryImages)
        );

        return $kept->concat($newImages)->values();
    }

    public function getSecondaryImages()
    {
        return collect($this->secondary_images)->map(function($image) {
            return $this->getImage($image);
        });
    }

    public function getSecondaryWithRelative()
    {
        $secondary = [];

        foreach ($this->secondary_images as $image) {
            $secondary[] = [
                'relative' => $image,
                'absolute' => $this->getImage($image)
            ];
        }

        return $secondary;
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

    public function deleteUnwanted($unwanted)
    {
        $unwanted->each(function($image) {
            ImageDeleted::dispatch($image);
        });
    }

    public function unwantedImages($kept)
    {
        return collect($this->secondary_images)->reject(function($value) use ($kept){
            return $kept->contains($value);
        });
    }

    public function keptImages($allImages)
    {
        return collect($allImages)
                ->filter()
                ->values()
                ->intersect($this->secondary_images);
    }

    public function filesFrom($images)
    {
        return collect($images)->reject(function($value) {
            return is_string($value) || ! $value;
        });
    }

    public function storeImages($files)
    {
        return $files->map(function($file) {
            $path = $file->store('articles', 'public');
            ImageAdded::dispatch($path);
            return $path;
        });
    }
}
