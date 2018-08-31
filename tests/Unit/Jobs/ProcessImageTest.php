<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Pawer\Jobs\ProcessImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessImageTest extends TestCase
{
    protected function setUp()
    {
        static::markTestSkipped('Image Processing Suspended');
    }

    /** @test*/
    public function it_resizes_the_image_to_1800px_wide()
    {
        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/regular-images/high-quality-image.png'))
        );
        $image = 'examples/example.png';

        ProcessImage::dispatch($image);

        $resizedImage = Storage::get('examples/example.png');
        [$width, $height] = getimagesizefromstring($resizedImage);
        $this->assertEquals(1224, $width);
        $this->assertEquals(1584, $height);
    }

    /** @test*/
    public function it_optimizes_the_image()
    {
        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/regular-images/small-unoptimized-image.png'))
        );
        $image = 'examples/example.png';

        ProcessImage::dispatch($image);

        $optimizedImageSize = Storage::size('examples/example.png');
        $originalSize = filesize(base_path('tests/__fixtures__/regular-images/small-unoptimized-image.png'));
        $this->assertLessThan($originalSize, $optimizedImageSize);
    }

    /** @test*/
    public function it_does_not_resize_the_image_if_it_is_already_smaller_than_600px_wide()
    {
        Storage::fake();
        Storage::put(
            'examples/example.png',
            file_get_contents(base_path('tests/__fixtures__/regular-images/smaller-size-image.png'))
        );
        $image = 'examples/example.png';

        ProcessImage::dispatch($image);

        $resizedImage = Storage::get('examples/example.png');
        [$width, $height] = getimagesizefromstring($resizedImage);

        $this->assertEquals(400, $width);
    }
}
