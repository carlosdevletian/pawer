<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Category;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        Storage::fake('public');
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'tops',
            'image_path' => File::image('category_image.png', 400),
        ], $overrides);
    }

    /** @test*/
    public function logged_in_users_can_create_a_category()
    {
        $this->signIn();

        $response = $this->withoutExceptionHandling()->post('/categories', [
            'name' => 'tops',
            'category_image' => $file = File::image('category_image.png', 1100, 850)
        ]);

        $response->assertSuccessful();
        tap(Category::first(), function($category) use($file) {
            $this->assertEquals('tops', $category->name);
            $this->assertNotNull($category->image_path);
            Storage::disk('public')->assertExists($category->image_path);
            $this->assertFileEquals(
                $file->getPathName(),
                Storage::disk('public')->path($category->image_path)
            );
        });
    }

    /** @test*/
    public function cannot_create_category_if_not_logged_in()
    {
        $this->post('/categories', $this->validParams());

        $this->assertCount(0, Category::get());
    }

    /** @test */
    public function name_is_required()
    {
        $response = $this->signIn()->post('/categories', $this->validParams([
            'name' => ''
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
        $this->assertEquals(0, Category::count());
    }

    /** @test */
    public function image_is_required()
    {
        $response = $this->signIn()->post('/categories', $this->validParams([
            'category_image' => ''
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('category_image');
        $this->assertEquals(0, Category::count());
    }

    /** @test */
    public function image_must_be_an_image()
    {
        $response = $this->signIn()->post('/categories', $this->validParams([
            'category_image' => File::create('no-an-image.doc')
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('category_image');
        $this->assertEquals(0, Category::count());
    }

    /** @test */
    public function image_must_be_at_least_400px_wide()
    {
        $response = $this->signIn()->post('/categories', $this->validParams([
            'category_image' => File::image('category_image.png', $width = 399, $height = 308)
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('category_image');
        $this->assertEquals(0, Category::count());
    }

    /** @test */
    public function image_must_be_have_landscape_letter_ratio()
    {
        $response = $this->signIn()->post('/categories', $this->validParams([
            'category_image' => File::image('category_image.png', $width = 1100, $height = 851)
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('category_image');
        $this->assertEquals(0, Category::count());
    }
}
