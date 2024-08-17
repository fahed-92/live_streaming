<?php

namespace App\Policies;

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    // Check if the user can update the room
    public function update(User $user, Room $room)
    {
        return $user->id === $room->user_id; // Only the creator of the room can update it
    }

    // Check if the user can delete the room
    public function delete(User $user, Room $room)
    {
        return $user->id === $room->user_id; // Only the creator of the room can delete it
    }
}
