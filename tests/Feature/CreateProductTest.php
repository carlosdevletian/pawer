<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Product;
use Pawer\Events\ImageAdded;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        Storage::fake();
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 't-shirts',
            'category_id' => create('Category')->id,
            'product_image' => $file = File::image('product_image.png', 1100, 850),
        ], $overrides);
    }

    /** @test*/
    public function logged_in_users_can_create_a_product()
    {
        $category = create('Category');

        $response = $this->fakeEvents([ImageAdded::class])->signIn()->post('/products', [
            'name' => 't-shirts',
            'category_id' => $category->id,
            'product_image' => $file = File::image('product_image.png', 1100, 850),
        ]);

        tap(Product::first(), function($product) use($category, $file) {
            $this->assertEquals('t-shirts', $product->name);
            $this->assertTrue($product->category->is($category));
            $this->assertNotNull($product->image_path);
            Storage::assertExists($product->image_path);
            $this->assertFileEquals(
                $file->getPathName(),
                Storage::path($product->image_path)
            );
        });
    }

    /** @test*/
    public function cannot_create_product_if_not_logged_in()
    {
        $this->post('/products', $this->validParams());

        $this->assertCount(0, Product::get());
    }

    /** @test*/
    public function logged_in_users_can_see_the_form_to_create_a_product()
    {
        $response = $this->signIn()->get('/products/create');

        $response->assertSuccessful();
    }

    /** @test*/
    public function guests_cannot_see_the_form_to_create_a_product()
    {
        $response = $this->get('/products/create');

        $response->assertStatus(302);
    }

    /** @test */
    public function name_is_required()
    {
        $response = $this->signIn()->post('/products', $this->validParams([
            'name' => ''
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
        $this->assertEquals(0, Product::count());
    }

    /** @test */
    public function image_is_required()
    {
        $response = $this->signIn()->post('/products', $this->validParams([
            'product_image' => ''
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('product_image');
        $this->assertEquals(0, Product::count());
    }

    /** @test */
    public function image_must_be_an_image()
    {
        $response = $this->signIn()->post('/products', $this->validParams([
            'product_image' => File::create('no-an-image.doc')
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('product_image');
        $this->assertEquals(0, Product::count());
    }

    /** @test */
    public function image_must_be_at_least_600px_wide()
    {
        $response = $this->signIn()->post('/products', $this->validParams([
            'product_image' => File::image('product_image.png', $width = 599, $height = 463)
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('product_image');
        $this->assertEquals(0, Product::count());
    }

    /** @test*/
    public function an_event_is_fired_when_a_product_is_created()
    {
        $this->fakeEvents([ImageAdded::class]);

        $response = $this->signIn()->post('/products', $this->validParams());

        Event::assertDispatched(ImageAdded::class, function($event) {
            $product = Product::firstOrFail();
            return $event->image === $product->image_path;
        });
    }
}
