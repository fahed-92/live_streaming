<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Room::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'code'=> $this->faker->word,
            'description'=> $this->faker->word,
            'creator_id'=> User::factory(),
            'ends_at'=> $this->faker->time,


        ];
    }
}
