<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use Pawer\Events\ImageAdded;
use Pawer\Jobs\ProcessImage;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleImageProcessingTest extends TestCase
{
    /** @test*/
    public function it_queues_a_job_to_process_an_image()
    {
        Queue::fake();

        $image = 'examples/example-image.png';

        ImageAdded::dispatch($image);

        Queue::assertPushed(ProcessImage::class, function($job) use($image) {
            return $image === $job->imagePath;
        });
    }

    /** @test*/
    public function if_it_receives_many_paths_it_queues_many_jobs_to_process_images()
    {
        Queue::fake();

        $image = [$image1, $image2, $image3] = ['image-1.png', 'image-2.png', 'image-3.png'];

        ImageAdded::dispatch($image);

        Queue::assertPushed(ProcessImage::class, function($job) use($image1) {
            return $image1 === $job->imagePath;
        });
        Queue::assertPushed(ProcessImage::class, function($job) use($image2) {
            return $image2 === $job->imagePath;
        });
        Queue::assertPushed(ProcessImage::class, function($job) use($image3) {
            return $image3 === $job->imagePath;
        });
    }
}
