<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class HandResponse
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $response;
    public $roomId;

    public function __construct($userId, $response, $roomId)
    {
        $this->userId = $userId;
        $this->response = $response;
        $this->roomId = $roomId;
    }

    public function broadcastOn()
    {
        return new Channel("room.{$this->roomId}");
    }
}
