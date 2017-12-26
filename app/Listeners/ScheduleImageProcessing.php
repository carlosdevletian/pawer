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
        if(is_array($event->image)) {
            foreach ($event->image as $image) {
                ProcessImage::dispatch($image);
            }
        } else {
            ProcessImage::dispatch($event->image);
        }
    }
}
