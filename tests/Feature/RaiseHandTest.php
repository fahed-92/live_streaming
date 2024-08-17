<?php

use App\Livewire\RaiseHand;
use App\Models\HandRaiseRequest;
use App\Events\RaiseHandRequested;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

beforeEach(function () {
    // Set up a sample room and user
    $this->roomId = 1;
    $this->user = \App\Models\User::factory()->create();
    Auth::login($this->user);
});

it('initializes with the correct hand raise status', function () {
    // Ensure there is no hand raise request for the user
    HandRaiseRequest::where('user_id', $this->user->id)->where('room_id', $this->roomId)->delete();

    // Mount the component
    $component = Livewire::test(RaiseHand::class, ['roomId' => $this->roomId]);

    // Assert that handRaised is false initially
    $component->assertSet('handRaised', false);
});

it('raises hand and broadcasts the event', function () {
    // Mount the component
    $component = Livewire::test(RaiseHand::class, ['roomId' => $this->roomId]);

    // Listen for the event
    Livewire::test(RaiseHand::class, ['roomId' => $this->roomId])
        ->call('raiseHand')
        ->assertEmitted(RaiseHandRequested::class, $this->user->id, $this->roomId);

    // Assert that the hand raise request was created
    assertDatabaseHas('hand_raise_requests', [
        'user_id' => $this->user->id,
        'room_id' => $this->roomId,
    ]);

    // Assert that the handRaised property is set to true
    $component->assertSet('handRaised', true);
});

it('does not raise hand if already raised', function () {
    // Create a hand raise request
    HandRaiseRequest::create([
        'user_id' => $this->user->id,
        'room_id' => $this->roomId,
    ]);

    // Mount the component
    $component = Livewire::test(RaiseHand::class, ['roomId' => $this->roomId]);

    // Try to raise hand again
    $component->call('raiseHand');

    // Assert that no additional hand raise request was created
    assertDatabaseCount('hand_raise_requests', 1);

    // Assert that the handRaised property is still true
    $component->assertSet('handRaised', true);
});

it('checks user hand raise status correctly', function () {
    // Create a hand raise request
    HandRaiseRequest::create([
        'user_id' => $this->user->id,
        'room_id' => $this->roomId,
    ]);

    // Mount the component
    $component = Livewire::test(RaiseHand::class, ['roomId' => $this->roomId]);

    // Assert that the handRaised property is set to true
    $component->assertSet('handRaised', true);
});
