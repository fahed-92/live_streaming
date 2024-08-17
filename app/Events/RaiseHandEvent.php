<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\User;

class RaiseHandEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomId;
    public $user;

    public function __construct($roomId, User $user)
    {
        $this->roomId = $roomId;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('room.' . $this->roomId);
    }

    public function broadcastWith()
    {
        return ['user_id' => $this->user->id, 'name' => $this->user->name];
    }
}
