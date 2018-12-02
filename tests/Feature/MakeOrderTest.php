<?php

namespace Tests\Feature;

use Pawer\Cart;
use Tests\TestCase;
use Pawer\Mail\SendOrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakeOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function send_an_email_with_order()
    {
        Mail::fake();

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

        $cartItems = Cart::items();

        $cartItems->zip($response->getData()->items)->each(function($items) {
            $this->assertTrue(
                $items[0]->article->id === $items[1]->article->id &&
                $items[0]->quantity === $items[1]->quantity
            );
        });

        $response = $this->post(route('order-email.handle'), [
            'email' => 'john@example.com'
        ]);

        Mail::assertQueued(SendOrderMail::class, function($mail) use ($cartItems) {
            return $mail->hasTo('orders@paw3r.com') &&
                    $mail->subject("New Order by john@example.com") &&
                    $mail->items == $cartItems;
        });
    }
}
