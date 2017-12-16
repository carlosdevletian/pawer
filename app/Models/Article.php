<?php

namespace Pawer\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $casts = [
        'sizes' => 'array',
        'images' => 'array',
    ];
}
