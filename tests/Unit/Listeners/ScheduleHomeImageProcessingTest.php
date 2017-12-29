<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use Pawer\Events\HomeImageAdded;
use Pawer\Jobs\ProcessHomeImage;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleHomeImageProcessingTest extends TestCase
{
    /** @test*/
    public function it_queues_a_job_to_process_a_home_image()
    {
        Queue::fake();

        $image = 'examples/example-image.png';

        HomeImageAdded::dispatch($image);

        Queue::assertPushed(ProcessHomeImage::class, function($job) use($image) {
            return $image === $job->imagePath;
        });
    }
}
