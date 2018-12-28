<?php

namespace Pawer;

use Pawer\Models\Size;
use Pawer\Models\Article;

class CartItem
{
    public $article, $name, $quantity, $size;

    function __construct($item)
    {
        $this->article = Article::findOrFail($item['article_id']);
        $this->name = $this->article->name;
        $this->quantity = $item['quantity'];
        $this->size = Size::findOrFail($item['size']);
        $this->total_price = $this->setTotalPrice();
    }

    public static function new($item)
    {
        return new self($item);
    }

    private function setTotalPrice()
    {
        if($this->article->isOnSale()) {
            $applicablePrice = $this->article->sale_price;
        } else {
            $applicablePrice = $this->article->price;
        }

        return (float) number_format($applicablePrice * $this->quantity, 2);
    }
}
