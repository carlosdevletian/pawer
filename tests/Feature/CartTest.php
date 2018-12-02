<?php

namespace Tests\Feature;

use Pawer\Cart;
use Pawer\CartItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function can_get_all_items_in_cart()
    {
        $articleA = create('Article');
        $sizeA = create('Size');

        $itemA = [
            'product_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $articleB = create('Article');
        $sizeB = create('Size');

        $itemB = [
            'product_id' => $articleB->id,
            'quantity' => 2,
            'size' => $sizeB->id
        ];

        $this->post(route('cart-items.store'), [
            'item' => $itemA
        ]);

        $this->post(route('cart-items.store'), [
            'item' => $itemB
        ]);

        $response = $this->json('GET', route('cart-items.index'));

        $this->assertCount(2, $response->getData()->items);

        tap($response->getData()->items[0], function($firstItem) use ($articleA, $sizeA) {
            $this->assertTrue($firstItem->article->id === $articleA->id);
            $this->assertTrue($firstItem->size->id === $sizeA->id);
        });

        tap($response->getData()->items[1], function($secondItem) use ($articleB, $sizeB) {
            $this->assertTrue($secondItem->article->id === $articleB->id);
            $this->assertTrue($secondItem->size->id === $sizeB->id);
        });
    }

    /** @test*/
    public function a_user_can_add_articles_to_the_cart()
    {
        $article = create('Article');
        $size = create('Size');

        $item = [
            'product_id' => $article->id,
            'quantity' => 2,
            'size' => $size->id
        ];

        $response = $this->withoutExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSuccessful();
        $this->assertEquals(Cart::items()->first(), CartItem::new($item));
    }

    /** @test*/
    public function if_the_same_article_and_size_is_added_twice_then_one_item_with_the_sum_of_the_quantities_and_new_total_is_added_to_the_cart()
    {
        $article = create('Article', ['price' => 0.99]);
        $size = create('Size');

        $item = [
            'product_id' => $article->id,
            'quantity' => 2,
            'size' => $size->id
        ];

        $response = $this->withoutExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);
        $this->assertCount(1, Cart::items());
        $this->assertEquals(1.98, Cart::items()->first()->total_price);

        $response = $this->withoutExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $this->assertCount(1, Cart::items());
        $this->assertEquals(Cart::items()->first()->quantity, 4);
        $this->assertEquals(Cart::items()->first()->total_price, 3.96);
    }

    /** @test*/
    public function a_user_can_remove_an_item_from_the_cart()
    {
        $articleA = create('Article');
        $sizeA = create('Size');

        $itemA = [
            'product_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $articleB = create('Article');
        $sizeB = create('Size');

        $itemB = [
            'product_id' => $articleB->id,
            'quantity' => 2,
            'size' => $sizeB->id
        ];

        $this->post(route('cart-items.store'), [
            'item' => $itemA
        ]);

        $this->post(route('cart-items.store'), [
            'item' => $itemB
        ]);

        $this->assertCount(2, Cart::items());

        $response = $this->withoutExceptionHandling()->delete(route('cart-items.destroy'), [
            'item' => json_encode(Cart::items()->last())
        ]);

        $this->assertCount(1, Cart::items());

        tap(Cart::items()->first(), function($firstItem) use ($articleA, $sizeA) {
            $this->assertTrue($firstItem->article->id === $articleA->id);
            $this->assertTrue($firstItem->size->id === $sizeA->id);
        });
    }

    /** @test*/
    public function the_cart_can_be_reset_to_zero_item()
    {

        $articleA = create('Article');
        $sizeA = create('Size');

        $itemA = [
            'product_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $articleB = create('Article');
        $sizeB = create('Size');

        $itemB = [
            'product_id' => $articleB->id,
            'quantity' => 2,
            'size' => $sizeB->id
        ];

        $this->post(route('cart-items.store'), [
            'item' => $itemA
        ]);

        $this->post(route('cart-items.store'), [
            'item' => $itemB
        ]);

        $response = $this->json('GET', route('cart-items.index'));

        $this->assertCount(2, $response->getData()->items);

        $this->delete(route('cart-items.destroy-all'));

        $response = $this->json('GET', route('cart-items.index'));

        $this->assertCount(0, $response->getData()->items);
    }
}
