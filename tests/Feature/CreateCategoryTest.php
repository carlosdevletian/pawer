<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Category;
use Pawer\Events\ImageAdded;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
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
            'category_image' => File::image('category_image.png', 1100, 850),
        ], $overrides);
    }

    /** @test*/
    public function logged_in_users_can_create_a_category()
    {
        $this->fake([ImageAdded::class]);
        $this->signIn();

        $response = $this->post('/categories', [
            'name' => 'tops',
            'category_image' => $file = File::image('category_image.png', 1100, 850)
        ]);

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

    /** @test*/
    public function logged_in_users_can_see_the_form_to_create_a_category()
    {
        $response = $this->signIn()->get('/categories/create');

        $response->assertSuccessful();
    }

    /** @test*/
    public function guests_cannot_see_the_form_to_create_a_category()
    {
        $response = $this->get('/categories/create');

        $response->assertStatus(302);
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
    public function image_must_be_at_least_600px_wide()
    {
        $response = $this->signIn()->post('/categories', $this->validParams([
            'category_image' => File::image('category_image.png', $width = 599, $height = 463)
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('category_image');
        $this->assertEquals(0, Category::count());
    }

    /** @test*/
    public function an_event_is_fired_when_a_category_is_created()
    {
        $this->fake([ImageAdded::class]);

        $response = $this->signIn()->post('/categories', $this->validParams());

        Event::assertDispatched(ImageAdded::class, function($event) {
            $category = Category::firstOrFail();
            return $event->image === $category->image_path;
        });
    }

    private function fake($eventsToFake = [])
    {
        $modelDispatcher = Model::getEventDispatcher();
        Event::fake($eventsToFake);
        Model::setEventDispatcher($modelDispatcher);
    }
}
