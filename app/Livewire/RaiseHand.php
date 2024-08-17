<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Events\RaiseHandRequested;
use App\Models\HandRaiseRequest;

class RaiseHand extends Component
{
    public $roomId;
    public $handRaised = false;

    public function mount($roomId)
    {
        $this->roomId = $roomId;
        $this->checkUserHandRaised();
    }

    public function raiseHand()
    {
        if (!$this->handRaised) {
            $this->handRaised = true;
            $userId = Auth::id();

            // Save hand raise request
            HandRaiseRequest::create([
                'user_id' => $userId,
                'room_id' => $this->roomId,
            ]);

            // Broadcast the event
            event(new RaiseHandRequested($userId, $this->roomId));

            // Emit an event to update the UI
//            $this->emit('handRaised');
            // $this->emitSelf('refreshComponent');

        }
    }

    public function checkUserHandRaised()
    {
        $this->handRaised = HandRaiseRequest::where('user_id', Auth::id())
            ->where('room_id', $this->roomId)
            ->exists();
    }

    public function render()
    {
        return view('livewire.raise-hand');
    }
}
