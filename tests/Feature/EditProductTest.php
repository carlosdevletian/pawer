<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Product;
use Pawer\Models\Category;
use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProductTest extends TestCase
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
            'name' => 't-shirts',
            'category_id' => create('Category')->id,
            'product_image' => $file = File::image('product_image.png', 1100, 850),
        ], $overrides);
    }

    private function oldAttributes($overrides = [])
    {
        return array_merge([
            'name' => 'Old product Name',
            'category_id' => create('Category')->id,
            'product_image' => $file = File::image('/products/old-image-path.png.png', 1100, 850),
        ], $overrides);
    }

    /** @test*/
    public function a_logged_in_user_can_update_a_product()
    {
        $this->withoutExceptionHandling()->fakeEvents()->signIn()->post('/products', $this->validParams());
        $product = Product::first();
        $newCategory = create('Category');

        $this->patch(route('products.update', $product), [
            'name' => 'New product name',
            'category_id' => $newCategory->id,
            'product_image' => $newFile = File::image('new-image.png', 800, 850),
        ]);

        tap($product->fresh(), function($updatedProduct) use ($newFile, $newCategory) {
            $this->assertEquals('New product name', $updatedProduct->name);
            $this->assertTrue($updatedProduct->category->is($newCategory));
            Storage::assertExists($updatedProduct->image_path);
            $this->assertFileEquals(
                $newFile->getPathName(),
                Storage::path($updatedProduct->image_path)
            );
        });
    }

    /** @test*/
    public function guests_cannot_update_a_product()
    {
        $oldCategory = create('Category');
        $this->fakeEvents()->signIn()->post('/products', [
            'name' => 'Old product Name',
            'category_id' => $oldCategory->id,
            'product_image' => $oldFile = File::image('/products/old-image-path.png.png', 1100, 850),
        ]);

        $product = Product::first();
        $oldPath = $product->image_path;

        $this->signOut()->patch(route('products.update', $product), $this->validParams());

        tap($product->fresh(), function($updatedProduct) use ($oldPath, $oldCategory) {
            $this->assertEquals('Old product Name', $updatedProduct->name);
            $this->assertTrue($updatedProduct->category->is($oldCategory));
            $this->assertEquals($oldPath, $updatedProduct->image_path);
        });
    }

    /** @test*/
    public function logged_in_users_can_see_the_edit_screen()
    {
        $product = create('Product');
        $this->withoutExceptionHandling()->signIn()->get(route('products.edit', $product->slug))->assertSuccessful();
    }

    /** @test*/
    public function guests_cannot_see_the_edit_screen()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $product = create('Product');

        $this->withoutExceptionHandling()->get(route('products.edit', $product->slug));
    }

    /** @test*/
    public function an_image_path_is_not_updated_if_it_is_missing()
    {
        $this->withoutExceptionHandling()->fakeEvents()->signIn()->post('/products', $this->oldAttributes());

        $product = Product::first();
        $oldPath = $product->image_path;

        $response = $this->patch(route('products.update', $product), $this->validParams([
            'product_image' => null
        ]));

        tap($product->fresh(), function($updatedProduct) use ($oldPath) {
            $this->assertEquals($oldPath, $updatedProduct->image_path);
        });
    }

    /** @test*/
    public function if_the_image_is_updated_the_old_image_is_deleted()
    {
        $this->withoutExceptionHandling()
            ->fakeEvents([ImageAdded::class, ImageDeleted::class])
            ->signIn()
            ->post('/products', $this->oldAttributes([
                'product_image' => File::image('/products/old-image-path.png', 1100, 850)
            ]));

        $product = Product::first();
        $oldPath = $product->image_path;

        $this->patch(route('products.update', $product), $this->validParams([
            'product_image' => $newImage = File::image('new-image.png', 800, 850),
        ]));

        Event::assertDispatched(ImageAdded::class, function($event) use($product) {
            return $event->image === $product->fresh()->image_path;
        });

        Event::assertDispatched(ImageDeleted::class, function($event) use($oldPath) {
            return $event->image === $oldPath;
        });
    }

    /** @test */
    public function name_is_required()
    {
        $this->signIn()->post('/products', $this->oldAttributes([
            'name' => 'Old Name'
        ]));
        $product = Product::first();
        $response = $this->patch(route('products.update', $product), $this->validParams([
            'name' => ''
        ]));

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Old Name', $product->fresh()->name);
    }

    /** @test*/
    public function category_id_is_required()
    {
        $oldCategory = create('Category');
        $this->signIn()->post('/products', $this->oldAttributes([
            'category_id' => $oldCategory->id
        ]));
        $product = Product::first();

        $response = $this->patch(route('products.update', $product), $this->validParams([
            'category_id' => ''
        ]));

        $response->assertSessionHasErrors('category_id');
        $this->assertTrue($product->fresh()->category->is($oldCategory));
    }

    /** @test*/
    public function category_id_must_be_valid()
    {
        $oldCategory = create('Category');
        $this->signIn()->post('/products', $this->oldAttributes([
            'category_id' => $oldCategory->id
        ]));
        $product = Product::first();

        $response = $this->patch(route('products.update', $product), $this->validParams([
            'category_id' => 9999
        ]));

        $response->assertSessionHasErrors('category_id');
        $this->assertTrue($product->fresh()->category->is($oldCategory));
    }

    /** @test */
    public function image_must_be_an_image()
    {
        $this->fakeEvents()->signIn()->post('/products', $this->oldAttributes([
            'product_image' => $oldImage = File::image('product_image.png', 1100, 850),
        ]));
        $product = Product::first();
        $oldImagePath = $product->image_path;

        $response = $this->patch(route('products.update', $product), $this->validParams([
            'product_image' => File::create('not-an-image.doc')
        ]));

        $response->assertSessionHasErrors('product_image');
        $this->assertEquals($product->fresh()->image_path, $oldImagePath);
        $this->assertFileEquals(
            $oldImage->getPathName(),
            Storage::path($oldImagePath)
        );
    }

    /** @test */
    public function image_must_be_at_least_600px_wide()
    {
        $this->fakeEvents()->signIn()->post('/products', $this->oldAttributes([
            'category_image' => $oldImage = File::image('category_image.png', 1100, 850),
        ]));
        $product = Product::first();
        $oldImagePath = $product->image_path;

        $response = $this->patch(route('products.update', $product), $this->validParams([
            'product_image' => File::image('product_image.png', 599, 850)
        ]));

        $response->assertSessionHasErrors('product_image');

        $this->assertEquals($product->fresh()->image_path, $oldImagePath);
        $this->assertFileEquals(
            $oldImage->getPathName(),
            Storage::path($oldImagePath)
        );
    }

    /** @test*/
    public function the_slug_is_changed_if_the_name_is_updated()
    {
        $product = create('Product', ['name' => 'tops']);

        $this->signIn()->patch(route('products.update', $product), $this->validParams([
            'name' => 'another name'
        ]));

        tap($product->fresh(), function($updatedProduct) {
            $this->assertEquals('another-name', $updatedProduct->slug);
        });
    }
}
