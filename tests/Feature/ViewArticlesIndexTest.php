<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewArticlesIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function user_can_view_all_articles_for_a_given_product()
    {
        $this->withoutExceptionHandling();
        $tShirt = create('Product', ['name' => 't-shirt']);
        $jacket = create('Product', ['name' => 'jacket']);

        $articleA = create('Article', [
            'name' => 'Example T Shirt Article',
            'product_id' => $tShirt->id
        ]);
        $wrongArticle = create('Article', [
            'name' => 'An article for another product',
            'product_id' => $jacket->id
        ]);
        $articleB = create('Article', [
            'name' => 'Another T shirt',
            'product_id' => $tShirt->id
        ]);

        $response = $this->get('/product/t-shirt/all-models');

        $this->assertEquals(
            $response->data('articles')->keys(),
            collect([
                'Example T Shirt Article',
                'Another T shirt'
            ])
        );
    }
}
