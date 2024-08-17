<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class HandRaised extends Notification
{
    protected $userId;
    protected $roomId;

    public function __construct($userId, $roomId)
    {
        $this->userId = $userId;
        $this->roomId = $roomId;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'userId' => $this->userId,
            'roomId' => $this->roomId,
        ]);
    }
}
