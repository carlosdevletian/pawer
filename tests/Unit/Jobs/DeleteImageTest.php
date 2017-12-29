<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Pawer\Jobs\DeleteImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteImageTest extends TestCase
{
    /** @test*/
    public function it_deletes_the_image_it_was_passed()
    {

        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/regular-images/high-quality-image.png'))
        );
        $image = 'examples/example.png';

        Storage::assertExists('examples/example.png');

        DeleteImage::dispatch($image);
        Storage::assertMissing($image);
    }
    /** @test*/
    public function it_deletes_the_image_it_was_passed1()
    {

        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/regular-images/high-quality-image.png'))
        );
        $image = 'examples/example.png';

        Storage::assertExists($image);

        DeleteImage::dispatch('examples/another-imate.png');
        Storage::assertExists($image);
    }
}
