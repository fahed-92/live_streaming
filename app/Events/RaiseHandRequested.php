<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class RaiseHandRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $roomId;

    public function __construct($userId, $roomId)
    {
        $this->userId = $userId;
        $this->roomId = $roomId;
    }

    public function broadcastOn()
    {
        return new Channel("room.{$this->roomId}");
    }
}
