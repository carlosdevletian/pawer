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
            'article_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $articleB = create('Article');
        $sizeB = create('Size');

        $itemB = [
            'article_id' => $articleB->id,
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
            'article_id' => $article->id,
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
    public function article_id_is_required()
    {
        $size = create('Size');

        $item = [
            'quantity' => 2,
            'size' => $size->id
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSessionHasErrors('item.article_id');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function article_must_exist()
    {
        $size = create('Size');

        $item = [
            'article_id' => 999,
            'quantity' => 2,
            'size' => $size->id
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function articles_must_be_available_to_be_added_to_the_cart()
    {
        $soldOutArticle = create('Article', ['sold_out' => true]);
        $size = create('Size');

        $soldOutItem = [
            'article_id' => $soldOutArticle->id,
            'quantity' => 2,
            'size' => $size->id
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $soldOutItem
        ]);

        $response->assertSessionHasErrors('item.article_id');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function quantity_is_required()
    {
        $article = create('Article');
        $size = create('Size');

        $item = [
            'article_id' => $article->id,
            'size' => $size->id
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSessionHasErrors('item.quantity');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function quantity_must_be_a_number()
    {
        $article = create('Article');
        $size = create('Size');

        $item = [
            'article_id' => $article->id,
            'quantity' => 'not-a-number',
            'size' => $size->id
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSessionHasErrors('item.quantity');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function quantity_must_be_greater_than_zero()
    {
        $article = create('Article');
        $size = create('Size');

        $item = [
            'article_id' => $article->id,
            'quantity' => 0,
            'size' => $size->id
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSessionHasErrors('item.quantity');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function size_is_required()
    {
        $article = create('Article');

        $item = [
            'article_id' => $article->id,
            'quantity' => 0,
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSessionHasErrors('item.size');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function size_must_exist()
    {
        $article = create('Article');

        $item = [
            'article_id' => $article->id,
            'quantity' => 1,
            'size' => 999
        ];

        $response = $this->withExceptionHandling()->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSessionHasErrors('item.size');
        $this->assertCount(0, Cart::items());
    }

    /** @test*/
    public function if_the_same_article_and_size_is_added_twice_then_one_item_with_the_sum_of_the_quantities_and_new_total_is_added_to_the_cart()
    {
        $article = create('Article', ['price' => 0.99]);
        $size = create('Size');

        $item = [
            'article_id' => $article->id,
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
            'article_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $articleB = create('Article');
        $sizeB = create('Size');

        $itemB = [
            'article_id' => $articleB->id,
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
            'article_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $articleB = create('Article');
        $sizeB = create('Size');

        $itemB = [
            'article_id' => $articleB->id,
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

    /** @test*/
    public function if_an_item_is_on_sale_it_takes_into_account_the_sale_price()
    {

        $articleA = create('Article', ['price' => 10.99, 'on_sale' => true, 'sale_price' => 5.99]);
        $sizeA = create('Size');

        $item = [
            'article_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $response = $this->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSuccessful();
        $this->assertEquals(Cart::items()->first(), CartItem::new($item));
        $this->assertEquals(Cart::items()->first()->total_price, 11.98 );
    }

    /** @test*/
    public function if_an_item_is_not_on_sale_it_takes_into_account_the_regular_price()
    {

        $articleA = create('Article', ['price' => 10.99, 'on_sale' => false, 'sale_price' => 5.99]);
        $sizeA = create('Size');

        $item = [
            'article_id' => $articleA->id,
            'quantity' => 2,
            'size' => $sizeA->id
        ];

        $response = $this->post(route('cart-items.store'), [
            'item' => $item
        ]);

        $response->assertSuccessful();
        $this->assertEquals(Cart::items()->first(), CartItem::new($item));
        $this->assertEquals(Cart::items()->first()->total_price, 21.98 );
    }
}
