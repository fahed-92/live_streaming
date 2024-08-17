<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $message;
    public $messages;

    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    protected $validationMessages = [
        'message.required' => 'The message cannot be empty.',
    ];

    public function mount()
    {
        $this->messages = Message::with('user')->latest()->take(50)->get()->reverse();
    }

    public function sendMessage()
    {
        $this->validate($this->rules, $this->validationMessages);

        $message = Message::create([
            'user_id' => Auth::id(),
            'body' => $this->message,
        ]);

        $this->message = '';

        // Broadcast the new message
        broadcast(new \App\Events\MessageSent($message))->toOthers();

        $this->refreshMessages();

    }

    public function getListeners()
    {
        return [
            "echo:chat,MessageSent" => 'refreshMessages',
        ];
    }

    public function refreshMessages()
    {
        $this->messages = Message::with('user')->latest()->take(50)->get()->reverse();
    }

    public function render()
    {
        return view('livewire.chat.index');
    }
}
