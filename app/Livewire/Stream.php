<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\RoomAttendee;

class Stream extends Component
{
    public $room;
    public $attendees = [];

    public function mount($room)
    {
        $this->room = $room;
        $this->loadAttendees();
    }

    public function getListeners()
    {
        return [
            "echo:room.{$this->room->id},UserJoinedRoom" => 'loadAttendees',
            "echo:room.{$this->room->id},UserLeftRoom" => 'loadAttendees',
            "echo:room.{$this->room->id},UserMuted" => 'loadAttendees',
        ];
    }

    public function loadAttendees()
    {
        $this->attendees = RoomAttendee::with('user')
            ->where('room_id', $this->room->id)
            ->get();

        // Notify that attendees have been updated
//        $this->dispatchBrowserEvent('attendees-updated', ['attendees' => $this->attendees->toArray()]);
    }

    public function render()
    {
        return view('livewire.stream', [
            'attendees' => $this->attendees,
        ]);
    }
}
