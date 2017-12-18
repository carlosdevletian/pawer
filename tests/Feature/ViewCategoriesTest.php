<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function user_can_view_all_categories()
    {
        $tops = create('Category', ['name' => 'tops']);
        $headwear = create('Category', ['name' => 'headwear']);
        $underwear = create('Category', ['name' => 'underwear']);

        $response = $this->get('/catalog');

        $response->data('categories')->assertEquals([
            $tops,
            $headwear,
            $underwear
        ]);
    }
}
