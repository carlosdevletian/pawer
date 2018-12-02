<?php

namespace Pawer\Http\Controllers;

use Pawer\Cart;
use Pawer\CartItem;
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
