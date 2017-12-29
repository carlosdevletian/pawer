<?php

namespace Pawer\Listeners;

use Pawer\Events\HomeImageAdded;
use Pawer\Jobs\ProcessHomeImage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleHomeImageProcessing
{
    public function handle(HomeImageAdded $event)
    {
        ProcessHomeImage::dispatch($event->image);
    }
}
