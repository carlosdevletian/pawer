<?php

namespace Pawer\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule as ImageRule;

class ImageFileOrUrl implements Rule
{
    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }


    public function passes($attribute, $value)
    {
        return $this->isValidPath($value) || $this->isValidImageFile($value);
    }


    public function message()
    {
        return 'Secondary images must be either existing images or valid image files';
    }

    public function isValidPath($value)
    {
        return collect($this->article->secondary_images)->contains($value);
    }

    public function isValidImageFile($value)
    {
        return Validator::make([
            'secondary_image' => $value
        ], [
            'secondary_image' => ['image', ImageRule::dimensions()->minWidth(600) ]
        ])->passes();
    }
}
