<?php

namespace Pawer\Models\Traits;

use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
use Illuminate\Support\Facades\Storage;

trait HasImages {

    public function getImage($image = null)
    {
        $image = $image ?? $this->image_path;
        // if(Storage::disk('public')->exists($image)) {
            return Storage::disk('public')->url($image);
        // }
        // if(Storage::disk('s3')->exists($image)) {
        //     return Storage::disk('s3')->url($image);
        // }
    }

    public function updateImage($newImage)
    {
        return $newImage ? $this->changeImage($newImage)
                        : $this->image_path;
    }

    public function changeImage($newImage)
    {
        ImageDeleted::dispatch($this->image_path);
        $image = $newImage->store(self::IMAGES_FOLDER, 'public');
        ImageAdded::dispatch($image);
        return $image;
    }
}