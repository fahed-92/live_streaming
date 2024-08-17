<?php

namespace App\Events;

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhiteboardDrawing
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $left;
    public $top;
    public $width;
    public $height;
    public $color;
    public $type;
    public $roomId;

    public function __construct($roomId, $left, $top, $width, $height, $color, $type)
    {
        $this->roomId = $roomId;
        $this->left = $left;
        $this->top = $top;
        $this->width = $width;
        $this->height = $height;
        $this->color = $color;
        $this->type = $type;
    }

    public function updateLockStatus()
    {
        $this->isLocked = $this->checkLock();
        $this->emit('whiteboard:lockStatus', $this->isLocked);
    }

    public function broadcastOn()
    {
        return new Channel('room.' . $this->roomId);
    }
}

