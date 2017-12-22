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
}
