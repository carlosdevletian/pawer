<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewArrivalsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function it_fetches_latest_10_products_and_family()
    {
        $oldestArticles = create('Article', [], 10);
        sleep(1);
        $newestArticles = create('Article', [], 10);

        $response = $this->withoutExceptionHandling()->get('/new-arrivals');

        $response->assertSuccessful();

        $this->assertEquals(
            $response->data('articles')->flatten()->pluck('id'),
            $newestArticles->pluck('id')
        );
    }
}
