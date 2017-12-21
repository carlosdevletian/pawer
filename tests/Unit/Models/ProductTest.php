<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_product_belongs_to_a_category()
    {
        $product = create('Product');

        $this->assertInstanceOf('Pawer\Models\Category', $product->category);
    }

    /** @test*/
    public function a_product_has_many_articles()
    {
        $product = create('Product');
        $articleA = create('Article', ['product_id' => $product->id]);
        $articleB = create('Article', ['product_id' => $product->id]);

        $this->assertEquals(2, $product->articles->count());
    }
}
