<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserMuted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $isMuted;

    public function __construct($userId, $isMuted, $roomId)
    {
        $this->userId = $userId;
        $this->isMuted = $isMuted;
        $this->roomId = $roomId;
    }

    public function broadcastOn()
    {
        return new Channel('room.' . $this->roomId);
    }
}
