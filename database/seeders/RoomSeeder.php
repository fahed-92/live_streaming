<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\User;

class RoomSeeder extends Seeder
{
    public function run()
    {
        // Ensure at least one user exists
        $creator = User::first(); // You might want to handle cases where no users exist

        if ($creator) {
            Room::create([
                'code' => 'room001',
                'name' => 'Test Room 1',
                'description' => 'This is a test room for demonstration purposes.',
                'creator_id' => $creator->id,
                'starts_at' => now()->addDays(1),
                'ends_at' => now()->addDays(1)->addHours(2),
                'is_active' => true,
            ]);

            Room::create([
                'code' => 'room002',
                'name' => 'Test Room 2',
                'description' => 'Another test room for different use cases.',
                'creator_id' => $creator->id,
                'starts_at' => now()->addDays(2),
                'ends_at' => now()->addDays(2)->addHours(3),
                'is_active' => true,
            ]);
        }
    }
}

