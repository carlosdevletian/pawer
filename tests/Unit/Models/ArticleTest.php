<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Pawer\Models\Article;
use Illuminate\Support\Facades\Storage;
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
            'color_name' => 'Navy-Blue'
        ]);

        $this->assertEquals('ruca-snapback-navy-blue', $article->slug);
    }

    /** @test*/
    public function an_article_can_be_marked_as_featured()
    {
        $featuredArticle = create('Article', ['featured' => true]);
        $normalArticle = create('Article', ['featured' => false]);

        $featured = Article::featured();

        $this->assertCount(1, $featured->get());
        $this->assertTrue($featured->first()->is($featuredArticle));
    }

    /** @test*/
    public function can_get_all_image_paths_for_the_article()
    {
        $article = create('Article', [
            'main_image_path' => 'articles/main-image.png',
            'secondary_images' => [
                'articles/secondary-image-1.png',
                'articles/secondary-image-2.png',
            ],
        ]);

        $this->assertEquals($article->getImagePaths(), [
            'articles/main-image.png',
            'articles/secondary-image-1.png',
            'articles/secondary-image-2.png',
        ]);
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
            'main_image_path' => '/green-image.png'
        ]);
        $ruca3 = create('Article', [
            'name' => 'RUCA SNAPBACK',
            'color' => 'red',
            'main_image_path' => '/red-image.png'
        ]);
        $other1 = create('Article', [
            'name' => 'OTHER',
            'color' => 'black'
        ]);
        $other2 = create('Article', [
            'name' => 'OTHER',
            'color' => 'white',
            'main_image_path' => '/white-image.png'
        ]);

        $results = Article::byFamily();

        $this->assertArrayHasKey('RUCA SNAPBACK', $results->toArray());
        $this->assertArrayHasKey('OTHER', $results->toArray());
    }
}
