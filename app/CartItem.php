<?php

namespace Pawer;

use Pawer\Models\Size;
use Pawer\Models\Article;

class CartItem
{
    public $article, $name, $quantity, $size;

    function __construct($item)
    {
        $this->article = Article::findOrFail($item['product_id']);
        $this->name = $this->article->name;
        $this->quantity = $item['quantity'];
        $this->size = Size::findOrFail($item['size']);
        $this->total_price = (float) number_format(($this->article->price * $this->quantity), 2);
    }

    public static function new($item)
    {
        return new self($item);
    }
}
