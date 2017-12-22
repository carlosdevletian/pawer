<?php

namespace Pawer\Listeners;

use Pawer\Events\ImageAdded;
use Pawer\Jobs\ProcessImage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleImageProcessing
{
    public function handle(ImageAdded $event)
    {
        ProcessImage::dispatch($event->image);
    }
}
