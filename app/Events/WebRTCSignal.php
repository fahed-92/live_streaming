<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebRTCSignal
{
    use Dispatchable, SerializesModels;

    public $data;
    public $roomId;

    public function __construct($data, $roomId)
    {
        $this->data = $data;
        $this->roomId = $roomId;
    }

    public function broadcastOn()
    {
        return new Channel('room.' . $this->roomId);
    }
}
