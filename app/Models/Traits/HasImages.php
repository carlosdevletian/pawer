<?php

namespace Pawer\Models\Traits;

use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
use Illuminate\Support\Facades\Storage;

trait HasImages {

    public function getImage()
    {
        if(Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }
        if(Storage::disk('s3')->exists($this->image_path)) {
            return Storage::disk('s3')->url($this->image_path);
        }
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