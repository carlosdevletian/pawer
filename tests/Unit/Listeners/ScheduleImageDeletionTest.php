<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use Pawer\Jobs\DeleteImage;
use Pawer\Events\ImageDeleted;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleImageDeletionTest extends TestCase
{
    /** @test*/
    public function it_queues_a_job_to_delete_an_image()
    {
        Queue::fake();

        $image = 'examples/example-image.png';

        ImageDeleted::dispatch($image);

        Queue::assertPushed(DeleteImage::class, function($job) use($image) {
            return $image === $job->imagePath;
        });
    }
}
