<?php

namespace Tests\Feature;

use Tests\TestCase;
use Pawer\Models\HomeImage;
use Pawer\Events\ImageDeleted;
use Pawer\Events\HomeImageAdded;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditHomeImagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function logged_in_users_can_edit_home_images()
    {
        Storage::fake();
        $imageA = create('HomeImage', ['path' => 'home/image-A.png']);
        $imageB = create('HomeImage', ['path' => 'home/image-B.png']);
        $imagec = create('HomeImage', ['path' => 'home/image-C.png']);

        $response = $this->withoutExceptionHandling()->fakeEvents()->signIn()->patch(route('home-images.update'), [
            'home_images' => [
                'home/image-A.png',
                $newImage = File::image('new-image.png', 800, 850)
            ],
        ]);

        tap(HomeImage::get(), function($homeImages) use ($newImage) {
            $this->assertCount(2, $homeImages);
            $this->assertEquals('home/image-A.png', $homeImages->first()->path);
            $this->assertFileEquals(
                $newImage->getPathName(),
                Storage::path($homeImages[1]->path)
            );
            Event::assertDispatched(HomeImageAdded::class, function($event) use($homeImages) {
                return $event->image === $homeImages[1]->path;
            });
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'home/image-B.png';
        });

        Event::assertDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'home/image-C.png';
        });

        Event::assertNotDispatched(ImageDeleted::class, function($event) {
            return $event->image === 'home/image-A.png';
        });
    }

    /** @test*/
    public function guests_cannot_edit_home_images()
    {
        Storage::fake();
        $imageA = create('HomeImage', ['path' => 'home/image-A.png']);
        $imageB = create('HomeImage', ['path' => 'home/image-B.png']);
        $imagec = create('HomeImage', ['path' => 'home/image-C.png']);

        $response = $this->patch(route('home-images.update'), [
            'home_images' => [
                'home/image-A.png',
                $newImage = File::image('new-image.png', 800, 850)
            ],
        ]);

        tap(HomeImage::get(), function($homeImages) use ($newImage) {
            $this->assertCount(3, $homeImages);
            $this->assertEquals('home/image-A.png', $homeImages[0]->path);
            $this->assertEquals('home/image-B.png', $homeImages[1]->path);
            $this->assertEquals('home/image-C.png', $homeImages[2]->path);
        });
    }
}
