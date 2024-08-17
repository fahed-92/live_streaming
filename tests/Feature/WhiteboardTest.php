<?php

use App\Livewire\Whiteboard;
use Livewire\Livewire;
use Illuminate\Support\Facades\Auth;

it('can set the active drawing user', function () {
    // Simulate an authenticated user
    $user = Auth::loginUsingId(1); // Assuming user ID 1 exists

    Livewire::test(Whiteboard::class)
        ->call('setDrawingUser')
        ->assertSet('activeUser', $user->id); // Assert that activeUser is set to the authenticated user's ID
});

it('can broadcast canvas updates', function () {
    $canvasData = 'sampleCanvasData';

    Livewire::test(Whiteboard::class)
        ->set('canvasData', $canvasData)
        ->call('broadcastCanvasUpdate')
        ->assertEmitted('refreshCanvas', $canvasData); // Assert that the 'refreshCanvas' event is emitted with the correct data
});

it('renders the correct view for the Whiteboard component', function () {
    Livewire::test(Whiteboard::class)
        ->assertViewIs('livewire.whiteboard'); // Assert that the correct view is rendered
});
