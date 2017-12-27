<?php

namespace Pawer\Listeners;

use Pawer\Jobs\DeleteImage;
use Pawer\Events\ImageDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleImageDeletion
{
    public function handle(ImageDeleted $event)
    {
        DeleteImage::dispatch($event->image);
    }
}
