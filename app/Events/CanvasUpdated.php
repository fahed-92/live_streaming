<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CanvasUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $canvasData;

    public function __construct($canvasData)
    {
        $this->canvasData = $canvasData;
    }

    public function broadcastOn()
    {
        return new Channel('room.' . $this->roomId);
    }
}
