<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function user_can_view_an_article()
    {
        $this->withoutExceptionHandling();
        $article = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'description' => 'A description for the ruca snapback article',
            'slug' => 'ruca-snapback-red',
            'color' => 'red',
            'code' => 'RUCAEXAMPLECODE-RED',
            'sizes' => "[
                'XS','SM','MD','LG','XL'
            ]",
            'images' => "[
                'example-image-1.png', 'example-image-2.png'
            ]"
        ]);

        $response = $this->get('/articles/RUCA%20SNAPBACK');

        $response->assertSuccessful();
        $response->assertViewHas('article', function($viewArticle) use ($article) {
            return $viewArticle->is($article);
        });
    }
}
