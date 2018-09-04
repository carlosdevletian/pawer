<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\Category;
use Pawer\Events\ImageAdded;
use Pawer\Events\ImageDeleted;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditCategoryTest extends TestCase
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
            'name' => 'tops',
            'category_image' => File::image('category_image.png', 1100, 850),
            'category_home_image' => File::image('category_home_image.png', 1200, 850),
        ], $overrides);
    }

    private function oldAttributes($overrides = [])
    {
        return array_merge([
            'name' => 'tops',
            'category_image' => File::image('/categories/old-image-path.png', 1100, 850),
            'category_home_image' => File::image('/categories/old-home-image-path.png', 1200, 850),
        ], $overrides);
    }

    /** @test*/
    public function a_logged_in_user_can_update_a_category()
    {
        $this->withoutExceptionHandling();
        $this->fakeEvents();
        $this->signIn()->post('/categories', [
            'name' => 'tops',
            'category_image' => $oldFile = File::image('/categories/old-image-path.png', 1100, 850),
            'category_home_image' => $oldHomeFile = File::image('category_home_image.png', 1100, 850)
        ]);

        $category = Category::first();

        $response = $this->patch(route('categories.update', $category), [
                        'name' => 'New category',
                        'category_image' => $newFile = File::image('new-image.png', 800, 850),
                        'category_home_image' => $newHomeFile = File::image('new-home-image.png', 800, 850),
                    ]);

        tap($category->fresh(), function($updatedCategory) use ($oldFile, $newFile, $oldHomeFile, $newHomeFile) {
            $this->assertEquals('New category', $updatedCategory->name);
            Storage::assertExists($updatedCategory->image_path);
            $this->assertFileEquals(
                $newFile->getPathName(),
                Storage::path($updatedCategory->image_path)
            );
            Storage::assertExists($updatedCategory->home_image_path);
            $this->assertFileEquals(
                $newHomeFile->getPathName(),
                Storage::path($updatedCategory->home_image_path)
            );
            $this->assertFileNotEquals(
                $oldFile->getPathName(),
                $newFile->getPathName()
            );
            $this->assertFileNotEquals(
                $oldHomeFile->getPathName(),
                $newHomeFile->getPathName()
            );
        });
    }

    /** @test*/
    public function guests_cannot_update_a_category()
    {
        $this->fakeEvents();
        $this->signIn()->post('/categories', [
            'name' => 'Old Name',
            'category_image' => $oldFile = File::image('/categories/old-image-path.png', 1100, 850),
            'category_home_image' => $oldHomePath = File::image('/categories/old-home-image-path.png', 1100, 850),
        ]);

        $category = Category::first();
        $oldPath = $category->image_path;
        $oldHomePath = $category->home_image_path;

        auth()->logout();
        $response = $this->patch(route('categories.update', $category), [
                        'name' => 'New category',
                        'category_image' => File::image('new-image.png', 800, 850),
                        'category_image' => File::image('new-image.png', 800, 850),
                    ]);

        tap($category->fresh(), function($updatedCategory) use ($oldPath, $oldHomePath) {
            $this->assertEquals('Old Name', $updatedCategory->name);
            $this->assertEquals($oldPath, $updatedCategory->image_path);
            $this->assertEquals($oldHomePath, $updatedCategory->home_image_path);
        });
    }

    /** @test*/
    public function logged_in_users_can_see_the_edit_screen()
    {
        $category = create('Category');

        $response = $this->signIn()->get(route('categories.edit', $category->slug));

        $response->assertSuccessful();
        $response->assertViewIs('admin.categories.edit');
    }

    /** @test*/
    public function guests_cannot_see_the_edit_screen()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $category = create('Category');

        $this->withoutExceptionHandling()->get(route('categories.edit', $category->slug));
    }

    /** @test*/
    public function an_image_path_is_not_updated_if_it_is_missing()
    {
        $this->withoutExceptionHandling();
        $this->fakeEvents();
        $this->signIn()->post('/categories', [
            'name' => 'tops',
            'category_image' => $oldFile = File::image('/categories/old-image-path.png', 1100, 850),
            'category_home_image' => File::image('/categories/old-image-path.png', 1100, 850),
        ]);

        $category = Category::first();

        $response = $this->patch(route('categories.update', $category), [
                        'name' => 'New category',
                        'category_image' => null,
                    ]);

        tap($category->fresh(), function($updatedCategory) use ($oldFile) {
            $this->assertEquals('New category', $updatedCategory->name);
            $this->assertFileEquals(
                $oldFile->getPathName(),
                Storage::path($updatedCategory->image_path)
            );
        });
    }

    /** @test*/
    public function a_home_image_path_is_not_updated_if_it_is_missing()
    {
        $this->withoutExceptionHandling();
        $this->fakeEvents();
        $this->signIn()->post('/categories', [
            'name' => 'tops',
            'category_image' => File::image('/categories/old-image-path.png', 1200, 850),
            'category_home_image' => $oldFile = File::image('/categories/old-home-image-path.png', 1100, 850)
        ]);

        $category = Category::first();

        $response = $this->patch(route('categories.update', $category), [
                        'name' => 'New category',
                        'category_image' => null,
                        'category_home_image' => null,
                    ]);

        tap($category->fresh(), function($updatedCategory) use ($oldFile) {
            $this->assertEquals('New category', $updatedCategory->name);
            $this->assertFileEquals(
                $oldFile->getPathName(),
                Storage::path($updatedCategory->home_image_path)
            );
        });
    }

    /** @test*/
    public function if_the_image_is_updated_the_old_image_is_deleted()
    {
        $this->withoutExceptionHandling();
        $this->fakeEvents([ImageAdded::class, ImageDeleted::class]);
        $this->signIn()->post('/categories', $this->oldAttributes([
            'category_image' => File::image('/categories/old-image-path.png', 1100, 850)
        ]));

        $category = Category::first();
        $oldImage = $category->image_path;

        $response = $this->patch(route('categories.update', $category), [
                        'name' => 'New category',
                        'category_image' => $newImage = File::image('new-image.png', 800, 850),
                    ]);

        Event::assertDispatched(ImageAdded::class, function($event) use($category) {
            return $event->image === $category->fresh()->image_path;
        });

        Event::assertDispatched(ImageDeleted::class, function($event) use($oldImage) {
            return $event->image === $oldImage;
        });
    }

    /** @test */
    public function name_is_required()
    {
        $this->signIn()->post('/categories', $this->oldAttributes([
            'name' => 'Old Name'
        ]));
        $category = Category::first();
        $response = $this->patch(route('categories.update', $category), $this->validParams([
            'name' => ''
        ]));

        $response->assertSessionHasErrors('name');
        $this->assertEquals('Old Name', Category::first()->name);
    }

    // /** @test */
    // public function image_is_required()
    // {
    //     $response = $this->signIn()->post('/categories', $this->validParams([
    //         'category_image' => ''
    //     ]));

    //     $response->assertStatus(302);
    //     $response->assertSessionHasErrors('category_image');
    //     $this->assertEquals(0, Category::count());
    // }

    /** @test */
    public function image_must_be_an_image()
    {
        $this->fakeEvents();

        $this->signIn()->post('/categories', $this->oldAttributes([
            'category_image' => $oldImage = File::image('category_image.png', 1100, 850),
        ]));
        $category = Category::first();
        $oldImagePath = $category->image_path;

        $response = $this->patch(route('categories.update', $category), $this->validParams([
            'category_image' => File::create('not-an-image.doc')
        ]));

        $response->assertSessionHasErrors('category_image');
        $this->assertEquals($category->fresh()->image_path, $oldImagePath);
        $this->assertFileEquals(
            $oldImage->getPathName(),
            Storage::path($oldImagePath)
        );
    }

    /** @test */
    public function image_must_be_at_least_600px_wide()
    {
        $this->markTestSkipped('Funcionalidad removida');
        $this->fakeEvents();

        $this->signIn()->post('/categories', $this->oldAttributes([
            'category_image' => $oldImage = File::image('category_image.png', 1100, 850),
        ]));
        $category = Category::first();
        $oldImagePath = $category->image_path;

        $response = $this->patch(route('categories.update', $category), $this->validParams([
            'category_image' => File::image('category_image.png', 599, 850)
        ]));

        $response->assertSessionHasErrors('category_image');

        $this->assertEquals($category->fresh()->image_path, $oldImagePath);
        $this->assertFileEquals(
            $oldImage->getPathName(),
            Storage::path($oldImagePath)
        );
    }

    /** @test*/
    public function the_slug_is_changed_if_the_name_is_updated()
    {
        $category = create('Category', ['name' => 'tops']);

        $response = $this->signIn()->patch(route('categories.update', $category), $this->validParams([
            'name' => 'another name'
        ]));

        tap($category->fresh(), function($updatedCategory) {
            $this->assertEquals('another-name', $updatedCategory->slug);
        });
    }
}
