<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_signed_in_user_can_delete_a_category()
    {
        $category = create('Category', ['name' => 'Some Category']);

        $this->signIn()->delete(route('categories.destroy', $category));

        $this->assertDatabaseMissing('categories', [
            'name' => 'Some Category'
        ]);
    }

    /** @test*/
    public function guests_cannot_delete_a_category()
    {
        $category = create('Category', ['name' => 'Some Category']);

        $this->delete(route('categories.destroy', $category));

        $this->assertDatabaseHas('categories', [
            'name' => 'Some Category'
        ]);
    }

    /** @test*/
    public function when_a_category_is_deleted_all_its_products_are_deleted()
    {
        $category = create('Category', ['name' => 'Some Category']);

        $productA = create('Product', ['category_id' => $category->id, 'name' => 'Correct Product A']);
        $otherProduct = create('Product', ['name' => 'Other Product']);
        $productB = create('Product', ['category_id' => $category->id, 'name' => 'Correct Product B']);

        $this->signIn()->delete(route('categories.destroy', $category));

        $this->assertDatabaseMissing('products', [
            'name' => 'Correct Product A'
        ]);

        $this->assertDatabaseMissing('products', [
            'name' => 'Correct Product B'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Other Product'
        ]);
    }
}
