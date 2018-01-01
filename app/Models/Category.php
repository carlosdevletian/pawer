<?php

namespace Pawer\Models;

use Pawer\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasImages;

    protected $guarded = [];

    protected $casts = [
        'sub_names' => 'array'
    ];

    const IMAGES_FOLDER = 'categories';

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace("-", "", $value);
        $this->attributes['slug'] = strtolower(str_slug($this->attributes['name']));
        $this->attributes['sub_names'] = json_encode(explode('-', $value));
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
