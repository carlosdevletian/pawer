<?php

namespace Pawer\Models;

use Pawer\Events\ImageDeleted;
use Pawer\Events\HomeImageAdded;
use Pawer\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;

class HomeImage extends Model
{
    use HasImages;

    protected $guarded = [];

    public static function getAbsoluteAndRelativePaths()
    {
        return self::get()->map(function($image) {
            return [
                'absolute' => $image->getImage($image->path),
                'relative' => $image->path
            ];
        });
    }

    public static function updateAllImages($requestImages)
    {
        self::deleteUnwanted(
            self::unwantedImages(
                $kept = self::keptImages($requestImages)
            )
        );

        $newImages = self::storeImages(
            self::filesFrom($requestImages)
        );

        return $kept->concat($newImages)->values();
    }

    public static function deleteUnwanted($unwanted)
    {
        $unwanted->each(function($image) {
            ImageDeleted::dispatch($image->path);
            $image->delete();
        });
    }

    public static function unwantedImages($kept)
    {
        return self::get()->reject(function($value) use ($kept){
            return $kept->contains($value);
        });
    }

    public static function keptImages($allImages)
    {
        return collect($allImages)->map(function($image) {
                    return self::wherePath($image)->first();
                })->filter()
                ->values();
    }

    public static function filesFrom($images)
    {
        return collect($images)->reject(function($value) {
            return is_string($value) || ! $value;
        });
    }

    public static function storeImages($files)
    {
        return $files->map(function($file) {
            return tap($file->storePublicly('home'), function($path) {
                HomeImageAdded::dispatch($path);
                self::create([
                    'path' => $path
                ]);
            });
        });
    }
}
