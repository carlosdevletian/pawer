<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MarkArticlesAsFeaturedTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function logged_in_users_can_mark_an_article_as_featured()
    {
        $article = create('Article', [
            'featured' => false
        ]);
        $this->assertFalse($article->isFeatured());

        $this->signIn()->post('/featured-articles', [
            'article_id' => $article->id
        ]);

        $this->assertTrue($article->fresh()->isFeatured());
    }

    /** @test*/
    public function when_an_article_is_featured_all_articles_by_that_name_are_alse_featured()
    {
        $featuredA = create('Article', [
            'name' => 'Should Be Featured',
            'featured' => false
        ]);
        $notFeatured = create('Article', [
            'name' => 'NOT FEATURED',
            'featured' => false
        ]);
        $featuredB = create('Article', [
            'name' => 'Should Be Featured',
            'featured' => false
        ]);
        $this->assertFalse($featuredA->isFeatured());
        $this->assertFalse($notFeatured->isFeatured());
        $this->assertFalse($featuredB->isFeatured());

        $this->signIn()->post('/featured-articles', [
            'article_id' => $featuredA->id
        ]);

        $this->assertTrue($featuredA->fresh()->isFeatured());
        $this->assertFalse($notFeatured->fresh()->isFeatured());
        $this->assertTrue($featuredB->fresh()->isFeatured());
    }

    /** @test*/
    public function guests_cannot_mark_an_article_as_featured()
    {
        $article = create('Article', [
            'featured' => false
        ]);
        $this->assertFalse($article->isFeatured());

        $this->post('/featured-articles', [
            'article_id' => $article->id
        ]);

        $this->assertFalse($article->fresh()->isFeatured());
    }

    /** @test*/
    public function logged_in_users_unmark_an_featured_article()
    {
        $article = create('Article', [
            'featured' => true
        ]);
        $this->assertTrue($article->isFeatured());

        $this->signIn()->delete('/featured-articles', [
            'article_id' => $article->id
        ]);

        $this->assertFalse($article->fresh()->isFeatured());
    }

    /** @test*/
    public function when_an_article_is_unfeatured_all_articles_by_that_name_are_also_unfeatured()
    {
        $unfeaturedA = create('Article', [
            'name' => 'Should Be UN-featured',
            'featured' => true
        ]);
        $stayFeatured = create('Article', [
            'name' => 'Must stay featured',
            'featured' => true
        ]);
        $unfeaturedB = create('Article', [
            'name' => 'Should Be UN-featured',
            'featured' => true
        ]);
        $this->assertTrue($unfeaturedA->isFeatured());
        $this->assertTrue($stayFeatured->isFeatured());
        $this->assertTrue($unfeaturedB->isFeatured());

        $this->signIn()->delete('/featured-articles', [
            'article_id' => $unfeaturedA->id
        ]);

        $this->assertFalse($unfeaturedA->fresh()->isFeatured());
        $this->assertTrue($stayFeatured->fresh()->isFeatured());
        $this->assertFalse($unfeaturedB->fresh()->isFeatured());
    }

    /** @test*/
    public function guests_cannot_unmark_an_featured_article()
    {
        $article = create('Article', [
            'featured' => true
        ]);
        $this->assertTrue($article->isFeatured());

        $this->delete('/featured-articles', [
            'article_id' => $article->id
        ]);

        $this->assertTrue($article->fresh()->isFeatured());
    }
}
