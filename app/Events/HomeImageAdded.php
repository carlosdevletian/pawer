<?php

namespace Pawer\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class HomeImageAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $image;

    public function __construct($image)
    {
        $this->image = $image;
    }
}
