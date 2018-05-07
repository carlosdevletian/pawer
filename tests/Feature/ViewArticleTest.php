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
        $article = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color_name' => 'red'
        ]);

        $response = $this->get('/models/ruca-snapback-red');

        $this->assertTrue(
            $response->data('article')->is($article)
        );
    }

    /** @test*/
    public function all_articles_of_same_name_are_loaded_to_view()
    {
        $articleA = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color_name' => 'red',
        ]);
        $articleB = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color_name' => 'green',
        ]);
        $articleC = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color_name' => 'black',
        ]);

        $response = $this->get('/models/ruca-snapback-red');

        $response->data('model')->assertEquals([
            $articleA,
            $articleB,
            $articleC
        ]);
    }
}
