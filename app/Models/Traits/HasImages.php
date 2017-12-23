<?php

namespace Pawer\Models\Traits;

use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;

trait HasImages {

    public function updateImage($newImage)
    {
        return $newImage ? $this->changeImage($newImage)
                        : $this->image_path;
    }

    public function changeImage($newImage)
    {
        ImageDeleted::dispatch($this->image_path);
        $image = $newImage->store(self::IMAGES_FOLDER);
        ImageAdded::dispatch($image);
        return $image;
    }
}