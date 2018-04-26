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
    /** @test*/
    public function a_category_can_have_sub_names_based_on_dashes_in_name()
    {
        $underwear = create('Category', ['name' => 'under_wear']);

        $this->assertEquals('underwear', $underwear->name);

        $this->assertEquals([
            'under',
            'wear'
        ], $underwear->sub_names);

        $anotherOne = create('Category', ['name' => 'under_wear category']);

        $this->assertEquals('underwear category', $anotherOne->name);

        $this->assertEquals([
            'under',
            'wear category'
        ], $anotherOne->sub_names);
    }
}
