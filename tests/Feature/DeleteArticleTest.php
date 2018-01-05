<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_signed_in_user_can_delete_an_article()
    {
        $article = create('Article', ['name' => 'Some Article']);

        $this->signIn()->delete(route('articles.destroy', $article));

        $this->assertDatabaseMissing('articles', [
            'name' => 'Some Article'
        ]);
    }

    /** @test*/
    public function guests_cannot_delete_an_article()
    {
        $article = create('Article', ['name' => 'Some Article']);

        $this->delete(route('articles.destroy', $article));

        $this->assertDatabaseHas('articles', [
            'name' => 'Some Article'
        ]);
    }
}
