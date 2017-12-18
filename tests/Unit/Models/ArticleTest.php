<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
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
}
