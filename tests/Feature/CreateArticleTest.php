<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Article;
use Pawer\Events\ImageAdded;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        Storage::fake();
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'product_id' => create('Product')->id,
            'name' => 'An example model',
            'description' => 'An example description for the new model',
            'color' => '#C0C0C0',
            'code' => 'EXAMPLECODE',
            'sizes' => ['sm', 'md', 'lg'],
            'main_image' => File::image('main_image.png', 1000, 850),
            'secondary_images' => [
                File::image('secondary_image_1.png', 900, 850),
                File::image('secondary_image_2.png', 800, 850),
            ],
            'featured' => true
        ], $overrides);
    }

    /** @test*/
    public function logged_in_users_can_see_the_page_to_create_articles()
    {
        $product = create('Product', ['name' => 't-shirts']);

        $response = $this->signIn()->get('/products/t-shirts/models/create');

        $response->assertSuccessful();
        $this->assertTrue($response->data('product')->is($product));
        $response->assertViewIs('admin.articles.create');
    }

    /** @test*/
    public function guests_cannot_see_the_page_to_create_articles()
    {
        $product = create('Product', ['name' => 't-shirts']);

        $response = $this->get('/products/t-shirts/models/create');

        $response->assertStatus(302);
    }

    /** @test*/
    public function logged_in_users_can_create_an_article()
    {
        $product = create('Product', ['name' => 't-shirts']);

        $this->fakeEvents([ImageAdded::class])->signIn()->post('/articles', [
            'product_id' => $product->id,
            'name' => 'An example model',
            'description' => 'An example description for the new model',
            'color' => '#C0C0C0',
            'code' => 'EXAMPLECODE',
            'sizes' => ['sm', 'md', 'lg'],
            'main_image' => $mainImage = File::image('main_image.png', 1000, 850),
            'secondary_images' => [
                $s1 = File::image('secondary_image_1.png', 900, 850),
                $s2 = File::image('secondary_image_2.png', 800, 850),
            ],
            'featured' => true
        ]);

        tap(Article::first(), function($article) use($product, $mainImage, $s1, $s2) {
            $this->assertTrue($article->product->is($product));
            $this->assertEquals('An example model', $article->name);
            $this->assertEquals('An example description for the new model', $article->description);
            $this->assertEquals('#C0C0C0', $article->color);
            $this->assertEquals('EXAMPLECODE', $article->code);
            $this->assertEquals(['sm', 'md', 'lg'], $article->sizes);
            Storage::assertExists($article->main_image_path);
            $this->assertFileEquals(
                $mainImage->getPathName(),
                Storage::path($article->main_image_path)
            );
            collect($article->secondary_images)->each(function($image, $index) use($s1, $s2){
                Storage::assertExists($image);
                $this->assertFileEquals(
                    ($index == 0 ? $s1 : $s2)->getPathName(),
                    Storage::path($image)
                );
            });
            $this->assertTrue($article->featured);
        });
    }

    /** @test*/
    public function guests_cannot_create_articles()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling()->post('/articles', $this->validParams());
    }

    /** @test*/
    public function product_id_is_required()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'product_id' => ''
        ]));
        $response->assertSessionHasErrors('product_id');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function product_id_must_be_valid()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'product_id' => 999
        ]));
        $response->assertSessionHasErrors('product_id');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function name_is_required()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'name' => ''
        ]));
        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function description_is_required()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'description' => ''
        ]));
        $response->assertSessionHasErrors('description');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function color_is_required()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'color' => ''
        ]));
        $response->assertSessionHasErrors('color');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function code_is_optional()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'code' => ''
        ]));
        $this->assertCount(1, Article::get());
    }

    /** @test*/
    public function sizes_is_required()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'sizes' => []
        ]));
        $response->assertSessionHasErrors('sizes');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function sizes_must_be_an_array()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'sizes' => 'not-an-array'
        ]));
        $response->assertSessionHasErrors('sizes');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function main_image_is_required()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'main_image' => ''
        ]));
        $response->assertSessionHasErrors('main_image');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function main_image_must_be_an_image()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'main_image' => File::create('no-an-image.doc')
        ]));
        $response->assertSessionHasErrors('main_image');
        $this->assertCount(0, Article::get());
    }

    /** @test */
    public function main_image_must_be_at_least_600px_wide()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'main_image' => File::image('main_image.png', $width = 599, $height = 463)
        ]));

        $response->assertSessionHasErrors('main_image');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function secondary_image_are_optional()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'secondary_images' => []
        ]));
        $this->assertCount(1, Article::get());
    }

    /** @test*/
    public function if_present_secondary_image_must_be_an_array()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'secondary_images' => 'not-an-array'
        ]));
        $response->assertSessionHasErrors('secondary_images');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function secondary_image_must_be_images()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'secondary_images' => [File::create('an-image.png'), File::create('no-an-image.doc')]
        ]));
        $response->assertSessionHasErrors('secondary_images.*');
        $this->assertCount(0, Article::get());
    }

    /** @test */
    public function secondary_images_must_be_at_least_600px_wide()
    {
        $response = $this->signIn()->post('/articles', $this->validParams([
            'secondary_images' => [
                File::image('secondary_image.png', $width = 750, $height = 463),
                File::image('secondary_image.png', $width = 599, $height = 463),
            ]
        ]));

        $response->assertSessionHasErrors('secondary_images.*');
        $this->assertCount(0, Article::get());
    }

    /** @test*/
    public function an_event_is_fired_when_a_category_is_created()
    {
        $this->fakeEvents([ImageAdded::class]);

        $response = $this->signIn()->post('/articles', $this->validParams());

        Event::assertDispatched(ImageAdded::class, function($event) {
            $article = Article::firstOrFail();
            return $event->image === $article->getImagePaths();
        });
    }
}
