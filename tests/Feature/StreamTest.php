<?php

use App\Livewire\Stream;
use App\Models\Room;
use Livewire\Livewire;
use function Pest\Laravel\assertDatabaseHas;

it('can mount the Stream component with a room', function () {
    // Create a Room instance
    $room = Room::factory()->create();

    // Mount the Stream component with the room
    Livewire::test(Stream::class, ['room' => $room])
        ->assertSet('room', $room) // Assert that the room is set correctly
        ->assertViewIs('livewire.stream') // Assert that the correct view is rendered
        ->assertViewHas('room'); // Assert that the view has the room
});

it('renders the correct view for the Stream component', function () {
    $room = Room::factory()->create();

    Livewire::test(Stream::class, ['room' => $room])
        ->assertViewIs('livewire.stream')
        ->assertSee($room->name); // Assuming the room's name is displayed in the view
});
