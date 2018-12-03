<?php

namespace Pawer\Http\Controllers;

use Pawer\Cart;
use Pawer\CartItem;
use Pawer\Models\Article;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'items' => Cart::items()
        ], 200);
    }

    public function store()
    {
        request()->validate([
            'item.article_id' => ['required', function($attribute, $value, $fail) {
                if(Article::find($value)->isSoldOut()) {
                    return $fail("The selected article is sold out and cannot be added to the cart");
                }
            }],
            'item.quantity' => ['required', 'numeric', 'min:1'],
            'item.size' => ['required', 'exists:sizes,id']
        ]);

        Cart::push(
            CartItem::new(request('item'))
        );
    }

    public function destroy()
    {
        Cart::remove(
            json_decode(request('item'))
        );
    }

    public function destroyAll()
    {
        Cart::reset();
    }
}
