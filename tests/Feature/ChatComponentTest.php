<?php

use App\Livewire\Chat;
use App\Models\Message;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the chat component', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Chat::class)
        ->assertStatus(200)
        ->assertSee('Type a message...');
});

it('validates the message input', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Chat::class)
        ->set('message', '')
        ->call('sendMessage')
        ->assertHasErrors(['message' => 'required']);
});

it('sends a message successfully', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Chat::class)
        ->set('message', 'Hello, world!')
        ->call('sendMessage')
        ->assertSet('message', '')
        ->assertSee('Hello, world!');

    $this->assertDatabaseHas('messages', [
        'body' => 'Hello, world!',
        'user_id' => $user->id,
    ]);
});
