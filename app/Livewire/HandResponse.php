<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HandRaiseRequest;
use App\Events\HandResponse as HandResponseEvent;

class HandResponse extends Component
{
    public $roomId;
    public $handRaiseRequests = [];
    public $userHandRaised = false;

    protected $listeners = ['handRaised' => 'loadHandRaiseRequests'];

    public function mount($roomId)
    {
        $this->roomId = $roomId;
        $this->loadHandRaiseRequests();
        $this->checkUserHandRaised();
    }

    public function loadHandRaiseRequests()
    {
        $this->handRaiseRequests = HandRaiseRequest::where('room_id', $this->roomId)
            ->with('user')
            ->get();
    }

    public function checkUserHandRaised()
    {
        $this->userHandRaised = HandRaiseRequest::where('user_id', auth()->id())
            ->where('room_id', $this->roomId)
            ->exists();
    }

    public function handleResponse($userId, $response)
    {
        $request = HandRaiseRequest::where('user_id', $userId)
            ->where('room_id', $this->roomId)
            ->first();

        if ($request) {
            event(new HandResponseEvent($userId, $response, $this->roomId));
            $request->delete();
            $this->loadHandRaiseRequests();
            $this->checkUserHandRaised();
        }
    }

    public function render()
    {
        return view('livewire.hand-response');
    }
}
