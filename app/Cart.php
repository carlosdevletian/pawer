<?php

namespace Pawer;

use Illuminate\Support\Facades\Session;

class Cart
{
    protected static $bag = 'cart.items';

    public static function items()
    {
        return collect(session(self::$bag));
    }

    public static function push($newItem)
    {
        if($existingItem = self::find($newItem)) {
            return self::mergeAndPushSimilarItems($newItem, $existingItem);
        }

        return Session::push(self::$bag, $newItem);

    }

    public static function remove($existingItem)
    {
        self::without(
            self::find($existingItem)
        )->tap(function() {
            Session::forget(self::$bag);
        })->each(function($item) {
            Session::push(self::$bag, $item);
        });
    }

    public static function reset()
    {
        Session::forget(self::$bag);
    }

    public static function mergeAndPushSimilarItems($newItem, $existingItem)
    {
        $updatedItem = self::mergeItems($newItem, $existingItem);

        // Get all the current items in the cart and remove the
        // item of same article and size (similar), and then
        // re-include that item with the quantity updated.
        self::without($newItem)
        ->push($updatedItem)
        ->tap(function() {
            Session::forget(self::$bag);
        })->each(function($item) {
            Session::push(self::$bag, $item);
        });
    }

    public static function find($item)
    {
        return self::items()->where('article.id', $item->article->id)->where('size.id', $item->size->id)->first();
    }

    public static function without($item)
    {
        return self::items()->reject( function($currentItem) use ($item) {
            return $currentItem->article == $item->article &&
                    $currentItem->size == $item->size;
        });
    }

    public static function mergeItems($newItem, $existingItem)
    {
        $existingItem->quantity += $newItem->quantity;
        $existingItem->total_price = (float) number_format(($existingItem->quantity * $existingItem->article->price), 2);

        return $existingItem;
    }
}
