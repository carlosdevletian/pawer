<?php

namespace Pawer\Models;

use Pawer\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasImages;

    protected $guarded = [];

    const IMAGES_FOLDER = 'categories';

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = strtolower(str_slug($value));
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImage()
    {
        return asset($this->image_path);
    }
}
