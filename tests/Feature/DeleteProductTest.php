<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_signed_in_user_can_delete_a_product()
    {
        $product = create('Product', ['name' => 'Some Product']);

        $this->signIn()->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', [
            'name' => 'Some Product'
        ]);
    }

    /** @test*/
    public function guests_cannot_delete_a_product()
    {
        $product = create('Product', ['name' => 'Some Product']);

        $this->delete(route('products.destroy', $product));

        $this->assertDatabaseHas('products', [
            'name' => 'Some Product'
        ]);
    }

    /** @test*/
    public function when_a_product_is_deleted_all_its_articles_are_deleted()
    {
        $product = create('Product', ['name' => 'Some Product']);

        $articleA = create('Article', ['product_id' => $product->id, 'name' => 'Correct Article A']);
        $otherArticle = create('Article', ['name' => 'Other Article']);
        $articleB = create('Article', ['product_id' => $product->id, 'name' => 'Correct Article B']);

        $this->signIn()->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('articles', [
            'name' => 'Correct Article A'
        ]);

        $this->assertDatabaseMissing('articles', [
            'name' => 'Correct Article B'
        ]);

        $this->assertDatabaseHas('articles', [
            'name' => 'Other Article'
        ]);
    }
}
