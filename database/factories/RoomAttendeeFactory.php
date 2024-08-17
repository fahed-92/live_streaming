<?php

use App\Models\RoomAttendee;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomAttendeeFactory extends Factory
{
    protected $model = RoomAttendee::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Correctly reference the User factory
            'room_id' => 1, // Correctly reference the Room factory
        ];
    }
}
