<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Whiteboard extends Component
{
    public $canvasData;
    public $activeUser;

    protected $listeners = ['broadcastCanvasUpdate', 'setDrawingUser', 'refreshCanvas'];

    public function setDrawingUser()
    {
        // Set the current user as the active drawer
        $this->activeUser = auth()->id();
    }

    public function broadcastCanvasUpdate()
    {
        // Broadcast canvas data to other users
        $this->emitTo('whiteboard', 'refreshCanvas', $this->canvasData);
    }

    public function render()
    {
        return view('livewire.whiteboard');
    }
}



