<?php

use App\Livewire\MuteControl;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomAttendee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Events\UserMuted;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a room and users
    $this->room = Room::factory()->create();
    $this->roomId = $this->room->id;

    $this->authenticatedUser = User::factory()->create();
    Auth::login($this->authenticatedUser);

    $this->users = User::factory()->count(3)->create();
    foreach ($this->users as $user) {
        RoomAttendee::create([
            'room_id' => $this->roomId,
            'user_id' => $user->id,
        ]);
    }
});

it('initializes with the correct mute status and users', function () {
    // Mount the component
    $component = Livewire::test(MuteControl::class, ['roomId' => $this->roomId]);

    // Assert the users are correctly loaded
    $component->assertSet('users', RoomAttendee::where('room_id', $this->roomId)->with('user')->get());

    // Assert the initial mute status is false
    $component->assertSet('isMuted', false);
});

it('can toggle mute for all users', function () {
    // Mount the component
    $component = Livewire::test(MuteControl::class, ['roomId' => $this->roomId]);

    // Mock the UserMuted event
    Event::fake();

    // Call toggleMuteAll to mute all users
    $component->call('toggleMuteAll', true);

    // Assert that isMuted is true
    $component->assertSet('isMuted', true);

    // Check that each user (except the authenticated one) is muted
    foreach ($this->users as $user) {
        $user->refresh();
        $this->assertTrue($user->is_muted);
        Event::assertDispatched(UserMuted::class, function ($event) use ($user) {
            return $event->userId === $user->id && $event->isMuted === true && $event->roomId === $this->roomId;
        });
    }

    // Call toggleMuteAll to unmute all users
    $component->call('toggleMuteAll', false);

    // Assert that isMuted is false
    $component->assertSet('isMuted', false);

    // Check that each user (except the authenticated one) is unmuted
    foreach ($this->users as $user) {
        $user->refresh();
        $this->assertFalse($user->is_muted);
        Event::assertDispatched(UserMuted::class, function ($event) use ($user) {
            return $event->userId === $user->id && $event->isMuted === false && $event->roomId === $this->roomId;
        });
    }
});

it('can toggle mute for a single user', function () {
    // Mount the component
    $component = Livewire::test(MuteControl::class, ['roomId' => $this->roomId]);

    // Select a user to mute
    $userToMute = $this->users->first();

    // Call toggleMute for the selected user
    $component->call('toggleMute', $userToMute->id);

    // Assert that the user is muted
    $userToMute->refresh();
    $this->assertTrue($userToMute->is_muted);

    // Call toggleMute again to unmute the user
    $component->call('toggleMute', $userToMute->id);

    // Assert that the user is unmuted
    $userToMute->refresh();
    $this->assertFalse($userToMute->is_muted);
});
