<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Article;
use Pawer\Models\Product;
use Pawer\Models\Category;
use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditArticleTest extends TestCase
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
            'color_name' => 'Navy Blue',
            'code' => 'EXAMPLECODE',
            'price' => 0.50,
            'sizes' => $this->getValidSizes(),
            'main_image' => File::image('main_image.png', 1000, 850),
            'secondary_images' => [
                File::image('secondary_image_1.png', 900, 850),
                File::image('secondary_image_2.png', 800, 850),
            ],
            'featured' => true
        ], $overrides);
    }

    private function oldAttributes($overrides = [])
    {
        return array_merge([
            'product_id' => create('Product')->id,
            'name' => 'Old model',
            'description' => 'Old Description',
            'color' => '#C0C0C0',
            'color_name' => 'Navy Blue',
            'code' => 'OLDCODE',
            'price' => 0.99,
            'sold_out' => false,
            'sizes' => $this->getValidSizes(),
            'main_image' => File::image('main_image.png', 1000, 850),
            'secondary_images' => [
                File::image('secondary_image_1.png', 900, 850),
                File::image('secondary_image_2.png', 800, 850),
            ],
            'featured' => true
        ], $overrides);
    }

    private function getValidSizes()
    {
        return create('Size', [], 3)->pluck('id')->toArray();
    }

    /** @test*/
    public function a_logged_in_user_can_update_an_article()
    {
        $this->withoutExceptionHandling()->fakeEvents()->signIn()->post('/articles', $this->validParams());
        $article = Article::first();
        $newProduct = create('Product');

        $this->fakeEvents([ImageAdded::class])->signIn()->patch(route('articles.update', $article), [
            'product_id' => $newProduct->id,
            'name' => 'New name',
            'description' => 'New description',
            'color' => '#000000',
            'color_name' => 'Navy Blue',
            'code' => 'NEWCODE',
            'price' => 0.55,
            'sold_out' => true,
            'sizes' => [create('Size', ['name' => 'unique-size'])->id],
            'main_image' => $newMainImage = File::image('main_image.png', 700, 850),
            'secondary_images' => [
                $newS1 = File::image('secondary_image_1.png', 600, 850),
                $newS2 = File::image('secondary_image_2.png', 650, 850),
            ],
            'featured' => false
        ]);

        tap($article->fresh(), function($article) use($newProduct, $newMainImage, $newS1, $newS2) {
            $this->assertTrue($article->product->is($newProduct));
            $this->assertTrue($article->product->is($newProduct));
            $this->assertEquals('New name', $article->name);
            $this->assertEquals('New description', $article->description);
            $this->assertEquals('#000000', $article->color);
            $this->assertEquals('NEWCODE', $article->code);
            $this->assertEquals('unique-size', $article->sizes->first()->name);
            $this->assertEquals(0.55, $article->price);
            $this->assertTrue($article->sold_out);
            $this->assertFileEquals(
                $newMainImage->getPathName(),
                Storage::path($article->main_image_path)
            );
            collect($article->secondary_images)->each(function($image, $index) use($newS1, $newS2){
                Storage::assertExists($image);
                $this->assertFileEquals(
                    ($index == 0 ? $newS1 : $newS2)->getPathName(),
                    Storage::path($image)
                );
            });
            $this->assertFalse($article->featured);
        });
    }

    /** @test*/
    public function guests_cannot_update_a_product()
    {
        $this->fakeEvents()->signIn()->post('/articles', $this->oldAttributes());
        $article = Article::first();

        $this->signOut()->patch(route('articles.update', $article), $this->validParams());

        $this->assertEquals(
            $article->getAttributes(),
            $article->fresh()->getAttributes()
        );

    }

    /** @test*/
    public function logged_in_users_can_see_the_edit_screen()
    {
        $article = create('Article');

        $response = $this->signIn()->get(route('articles.edit', $article->slug))->assertSuccessful();

        $response->assertViewIs('admin.articles.edit');
        $this->assertTrue($response->data('article')->is($article));
    }

    /** @test*/
    public function guests_cannot_see_the_edit_screen()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $article = create('Article');

        $this->withoutExceptionHandling()->get(route('articles.edit', $article->slug));
    }

    /** @test*/
    public function main_image_is_not_updated_if_it_is_missing()
    {
        $this->withoutExceptionHandling()->fakeEvents()->signIn()->post('/articles', $this->oldAttributes());

        $article = Article::first();
        $oldMainImagePath = $article->main_image_path;

        $response = $this->patch(route('articles.update', $article), $this->validParams([
            'main_image' => null
        ]));

        tap($article->fresh(), function($updatedArticle) use ($oldMainImagePath) {
            $this->assertEquals($oldMainImagePath, $updatedArticle->main_image_path);
        });
    }

    /** @test*/
    public function if_main_image_is_updated_the_old_image_is_deleted()
    {
        $this->withoutExceptionHandling()
            ->fakeEvents([ImageAdded::class, ImageDeleted::class])
            ->signIn()
            ->post('/articles', $this->oldAttributes([
                'main_image' => File::image('/articles/old-image-path.png', 1100, 850)
            ]));

        $article = Article::first();
        $oldPath = $article->main_image_path;

        $this->patch(route('articles.update', $article), $this->validParams([
            'main_image' => $newImage = File::image('new-image.png', 800, 850),
        ]));

        Event::assertDispatched(ImageAdded::class, function($event) use($article) {
            return $event->image === $article->fresh()->main_image_path;
        });

        Event::assertDispatched(ImageDeleted::class, function($event) use($oldPath) {
            return $event->image === $oldPath;
        });
    }

    /** @test*/
    public function secondary_images_updated()
    {
        $article = create('Article', [
            'secondary_images' => [
                'articles/first-image.png',
                'articles/second-image.png',
                'articles/third-image.png',
            ]
        ]);

        $response = $this->fakeEvents()->signIn()->patch(route('articles.update', $article), $this->validParams([
            'secondary_images' => [
                'articles/first-image.png',
                $newImage = File::image('new-image.png', 800, 850)
            ],
        ]));

        tap($article->fresh(), function($updatedArticle) use ($newImage) {
            $this->assertCount(2, $updatedArticle->secondary_images);
            $this->assertContains('articles/first-image.png', $updatedArticle->secondary_images);
            $this->assertFileEquals(
                $newImage->getPathName(),
                Storage::path($updatedArticle->secondary_images[1])
            );
            Event::assertDispatched(ImageAdded::class, function($event) use($updatedArticle) {
                return $event->image === $updatedArticle->secondary_images[1];
            });
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'articles/second-image.png';
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'articles/third-image.png';
        });

        Event::assertNotDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'articles/first-image.png';
        });
    }

    /** @test*/
    public function secondary_images_can_be_erased()
    {
            $article = create('Article', [
                'secondary_images' => [
                    'articles/first-image.png',
                    'articles/second-image.png',
                    'articles/third-image.png',
                ]
            ]);

        $response = $this->fakeEvents()->signIn()->patch(route('articles.update', $article), $this->validParams([
            'secondary_images' => [
                null,
                null,
                null,
            ],
        ]));

        tap($article->fresh(), function($updatedArticle) {
            $this->assertCount(0, $updatedArticle->secondary_images);
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'articles/first-image.png';
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'articles/second-image.png';
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'articles/third-image.png';
        });
    }

    /** @test*/
    public function secondary_images_must_be_an_array()
    {
            $article = create('Article', [
                'secondary_images' => [
                    'articles/first-image.png',
                    'articles/second-image.png',
                    'articles/third-image.png',
                ]
            ]);

        $response = $this->fakeEvents()->signIn()->patch(route('articles.update', $article), $this->validParams([
            'secondary_images' => 'not-an-array',
        ]));

        $response->assertSessionHasErrors('secondary_images');
        $this->assertEquals(
            $article->fresh()->secondary_images, [
            'articles/first-image.png',
            'articles/second-image.png',
            'articles/third-image.png',
        ]);
    }

    /** @test*/
    public function secondary_images_must_be_a_path_to_an_existing_secondary_image()
    {
            $article = create('Article', [
                'secondary_images' => [
                    'articles/first-image.png',
                    'articles/second-image.png',
                    'articles/third-image.png',
                ]
            ]);

        $response = $this->fakeEvents()->signIn()->patch(route('articles.update', $article), $this->validParams([
            'secondary_images' => [
                'invalid-path.png'
            ],
        ]));

        $response->assertSessionHasErrors('secondary_images.*');
    }

    /** @test*/
    public function secondary_images_can_be_image_files()
    {
            $article = create('Article', [
                'secondary_images' => [
                    'articles/first-image.png',
                    'articles/second-image.png',
                    'articles/third-image.png',
                ]
            ]);

        $response = $this->fakeEvents()->signIn()->patch(route('articles.update', $article), $this->validParams([
            'secondary_images' => [
                File::image('new-image.png', 800, 850)
            ],
        ]));

        $this->assertCount(1, $article->fresh()->secondary_images);
    }

    /** @test*/
    public function if_they_are_files_secondary_images_must_have_a_minimum_width_of_600px()
    {
            $article = create('Article', [
                'secondary_images' => [
                    'articles/first-image.png',
                    'articles/second-image.png',
                    'articles/third-image.png',
                ]
            ]);

        $response = $this->fakeEvents()->signIn()->patch(route('articles.update', $article), $this->validParams([
            'secondary_images' => [
                File::image('new-image.png', $width = 599)
            ],
        ]));

        $response->assertSessionHasErrors('secondary_images.*');
    }

    /** @test*/
    public function product_id_is_required()
    {
        $article = create('Article', ['product_id' => $productId = create('Product')->id]);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'product_id' => ''
        ]));

        $response->assertSessionHasErrors('product_id');
        $this->assertEquals($productId, $article->fresh()->product_id);
    }

    /** @test*/
    public function product_id_must_be_valid()
    {
        $article = create('Article', ['product_id' => $productId = create('Product')->id]);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'product_id' => 999
        ]));

        $response->assertSessionHasErrors('product_id');
        $this->assertEquals($productId, $article->fresh()->product_id);
    }

    /** @test*/
    public function name_is_required()
    {
        $article = create('Article', ['name' => 'Old name']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'name' => ''
        ]));

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Old name', $article->fresh()->name);
    }

    /** @test*/
    public function description_is_required()
    {
        $article = create('Article', ['description' => 'Old Description']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'description' => ''
        ]));

        $response->assertSessionHasErrors('description');
        $this->assertEquals('Old Description', $article->fresh()->description);
    }

    /** @test*/
    public function color_is_required()
    {
        $article = create('Article', ['color' => '#000000']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'color' => ''
        ]));

        $response->assertSessionHasErrors('color');
        $this->assertEquals('#000000', $article->fresh()->color);
    }

    /** @test*/
    public function color_name_is_required()
    {
        $article = create('Article', ['color_name' => 'Navy Blue']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'color_name' => ''
        ]));

        $response->assertSessionHasErrors('color_name');
        $this->assertEquals('Navy Blue', $article->fresh()->color_name);
    }

    /** @test*/
    public function code_is_optional()
    {
        $article = create('Article', ['code' => 'EXAMPLEOLDCODE']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'code' => ''
        ]));

        $this->assertEquals(null, $article->fresh()->code);
    }

    /** @test*/
    public function sizes_is_required()
    {
        $article = create('Article');

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'sizes' => []
        ]));

        $response->assertSessionHasErrors('sizes');
    }

    /** @test*/
    public function sizes_must_be_an_array()
    {
        $article = create('Article');

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'sizes' => 'not-an-array'
        ]));

        $response->assertSessionHasErrors('sizes');
    }

    /** @test*/
    public function sizes_must_be_valid_existing_product_sizes()
    {
        $article = create('Article');

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'sizes' => [99]
        ]));
        $response->assertSessionHasErrors('sizes.*');
    }

    /** @test*/
    public function main_image_must_be_an_image()
    {
        $article = create('Article', ['main_image_path' => 'some-path.png']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'main_image' => File::create('no-an-image.doc')
        ]));

        $response->assertSessionHasErrors('main_image');
        $this->assertEquals('some-path.png', $article->fresh()->main_image_path);
    }

    /** @test */
    public function main_image_must_be_at_least_600px_wide()
    {
        $article = create('Article', ['main_image_path' => 'some-path.png']);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'main_image' => File::create('an-image.png', $width = 599)
        ]));

        $response->assertSessionHasErrors('main_image');
        $this->assertEquals('some-path.png', $article->fresh()->main_image_path);
    }

    /** @test*/
    public function the_slug_is_changed_if_the_name_is_updated()
    {
        $article = create('Article', [
            'name' => 'old model',
            'color_name' => 'old color'
        ]);

        $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'name' => 'new model',
            'color_name' => 'old color'
        ]));

        tap($article->fresh(), function($updatedArticle) {
            $this->assertEquals('new-model-old-color', $updatedArticle->slug);
        });
    }

    /** @test*/
    public function the_slug_is_changed_if_the_color_is_updated()
    {
        $article = create('Article', [
            'name' => 'old model name',
            'color_name' => 'Old color'
        ]);

        $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'name' => 'old model name',
            'color_name' => 'New cool color'
        ]));

        tap($article->fresh(), function($updatedArticle) {
            $this->assertEquals('old-model-name-new-cool-color', $updatedArticle->slug);
        });
    }

    /** @test*/
    public function price_is_required()
    {
        $article = create('Article', ['price' => 0.75]);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'price' => ''
        ]));

        $response->assertSessionHasErrors('price');
        $this->assertEquals(0.75, $article->fresh()->price);
    }

    /** @test*/
    public function price_must_be_numeric()
    {
        $article = create('Article', ['price' => 0.75]);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'price' => 'not-a-number'
        ]));

        $response->assertSessionHasErrors('price');
        $this->assertEquals(0.75, $article->fresh()->price);
    }

    /** @test*/
    public function price_cannot_be_negative()
    {
        $article = create('Article', ['price' => 0.75]);

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'price' => -10
        ]));

        $response->assertSessionHasErrors('price');
        $this->assertEquals(0.75, $article->fresh()->price);
    }

    /** @test*/
    public function an_article_can_be_markes_as_sold_out()
    {
        $article = create('Article', ['sold_out' => false]);
        $this->assertFalse($article->isSoldOut());

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'sold_out' => 1
        ]));

        $this->assertTrue($article->fresh()->isSoldOut());
    }

    /** @test*/
    public function an_article_can_be_markes_as_available()
    {
        $article = create('Article', ['sold_out' => true]);
        $this->assertTrue($article->isSoldOut());

        $response = $this->signIn()->patch(route('articles.update', $article), $this->validParams([
            'sold_out' => null
        ]));

        $this->assertTrue($article->fresh()->isAvailable());
    }
}
