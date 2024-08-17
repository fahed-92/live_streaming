<?php

namespace App\Events;

use App\Models\RoomAttendee;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class UserJoinedRoom implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $user;
    public $roomId;

    public function __construct(User $user, $roomId)
    {
        $this->user = $user;
        $this->roomId = $roomId;
    }
    public function broadcastOn()
    {
        return new Channel('room.' . $this->user);
    }
}
