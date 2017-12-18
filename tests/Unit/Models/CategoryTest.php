<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_category_has_many_products()
    {
        $category = create('Category');
        $productA = create('Product', ['category_id' => $category->id]);
        $productB = create('Product', ['category_id' => $category->id]);

        $this->assertEquals(2, $category->products->count());
    }
}
