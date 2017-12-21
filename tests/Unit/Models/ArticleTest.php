<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Pawer\Models\Article;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_slug_is_set_based_on_name_and_color()
    {
        $article = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color' => 'blue'
        ]);

        $this->assertEquals('ruca-snapback-blue', $article->slug);
    }

    /** @test*/
    public function can_get_all_articles_of_same_name_grouped_as_a_family()
    {
        $ruca1 = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color' => 'blue'
        ]);
        $ruca2 = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color' => 'green',
            'images' => ['/green-image.png']
        ]);
        $ruca3 = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color' => 'red',
            'images' => ['/red-image.png']
        ]);
        $other1 = create('Article', [
            'name' => 'OTHER',
            'color' => 'black'
        ]);
        $other2 = create('Article', [
            'name' => 'OTHER',
            'color' => 'white',
            'images' => ['/white-image.png']
        ]);

        $results = Article::byFamily();

        $this->assertEquals(
            $results->toArray(),
            collect([
                'RUCA SNAPBACK' => [
                    $ruca1->toArray(),
                    [
                        'color' => 'green',
                        'images' => ['/green-image.png']
                    ],
                    [
                        'color' => 'red',
                        'images' => ['/red-image.png']
                    ],
                ],
                'OTHER' => [
                    $other1->toArray(),
                    [
                        'color' => 'white',
                        'images' => ['/white-image.png']
                    ]
                ]
            ])->toArray()
        );
    }
}
