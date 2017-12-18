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
}
