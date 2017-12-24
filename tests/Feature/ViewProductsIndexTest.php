<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewProductsIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function user_can_view_all_products_for_a_given_category()
    {
        $tops = create('Category', ['name' => 'tops']);
        $underwear = create('Category', ['name' => 'underwear']);

        $tShirt = create('Product', [
            'name' => 't-shirt',
            'category_id' => $tops->id
        ]);
        $socks = create('Product', [
            'name' => 'socks',
            'category_id' => $underwear->id
        ]);
        $jacket = create('Product', [
            'name' => 'jacket',
            'category_id' => $tops->id
        ]);

        $response = $this->get('/category/tops/all-products');


        $response->data('products')->assertEquals([
            $tShirt,
            $jacket
        ]);
    }
}
