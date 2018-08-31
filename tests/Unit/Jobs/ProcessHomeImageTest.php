<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Pawer\Jobs\ProcessHomeImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessHomeImageTest extends TestCase
{
    protected function setUp()
    {
        static::markTestSkipped('Image Processing Suspended');
    }

    /** @test*/
    public function it_resizes_the_image_to_1500px_wide()
    {
        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/home-images/high-quality-image.png'))
        );
        $image = 'examples/example.png';

        ProcessHomeImage::dispatch($image);

        $resizedImage = Storage::get('examples/example.png');
        [$width, $height] = getimagesizefromstring($resizedImage);
        $this->assertEquals(1500, $width);
        $this->assertEquals(574, $height);
    }

    /** @test*/
    public function it_optimizes_the_image()
    {
        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/home-images/small-unoptimized-image.png'))
        );
        $image = 'examples/example.png';

        ProcessHomeImage::dispatch($image);

        $optimizedImageSize = Storage::size('examples/example.png');
        $originalSize = filesize(base_path('tests/__fixtures__/home-images/small-unoptimized-image.png'));
        $this->assertLessThan($originalSize, $optimizedImageSize);
    }

    /** @test*/
    public function it_does_not_resize_the_image_if_it_is_already_smaller_than_1500px_wide()
    {
        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/home-images/smaller-size-image.png'))
        );
        $image = 'examples/example.png';

        ProcessHomeImage::dispatch($image);

        $resizedImage = Storage::get('examples/example.png');
        [$width, $height] = getimagesizefromstring($resizedImage);

        $this->assertEquals(1362, $width);
    }
}
