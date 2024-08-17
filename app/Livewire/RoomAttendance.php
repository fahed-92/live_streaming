<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\RoomAttendee;
use App\Events\UserMuted;
use Illuminate\Support\Facades\Auth;

class RoomAttendance extends Component
{
    public $roomId;
    public $attendees;
    public $isMuted = false;
    public $userMuteStatus = [];
    public $isCreator = false;

    public function mount($roomId)
    {
        $this->roomId = $roomId;
        $this->isCreator = Auth::id() == Room::find($this->roomId)->creator_id;
        $this->addUserToRoom();
        $this->loadAttendees();
    }

    public function loadAttendees()
    {
        $this->attendees = RoomAttendee::with('user')
            ->where('room_id', $this->roomId)
            ->get();

        $this->updateMuteStatus();
    }

    public function toggleMuteAll($value)
    {
        $this->isMuted = $value;

        if ($this->isMuted) {
            $this->muteAll();
        } else {
            $this->unmuteAll();
        }
    }

    public function toggleMute($userId)
    {
        $attendee = RoomAttendee::where('room_id', $this->roomId)
                                ->where('user_id', $userId)
                                ->first();

        if ($attendee) {
            $user = $attendee->user;
            $user->toggleMute($this->roomId);
            $this->updateMuteStatus();
        }
    }

    public function muteAll()
    {
        foreach ($this->attendees as $attendee) {
            if ($attendee->user_id !== Auth::id()) {
                $attendee->user->toggleMute($this->roomId);
            }
        }
        $this->updateMuteStatus();
    }

    public function unmuteAll()
    {
        foreach ($this->attendees as $attendee) {
            if ($attendee->user_id !== Auth::id()) {
                $attendee->user->is_muted = false;
                $attendee->user->save();
                broadcast(new UserMuted($attendee->user->id, $attendee->user->is_muted, $this->roomId));
            }
        }
        $this->updateMuteStatus();
    }

    private function updateMuteStatus()
    {
        $this->isMuted = $this->attendees->every(fn($attendee) => $attendee->user->is_muted);
        $this->userMuteStatus = $this->attendees->mapWithKeys(function($attendee) {
            return [$attendee->user->id => $attendee->user->is_muted];
        })->toArray();
    }

    public function addUserToRoom()
    {
        if (!RoomAttendee::where('room_id', $this->roomId)->where('user_id', Auth::id())->exists()) {
            RoomAttendee::create([
                'room_id' => $this->roomId,
                'user_id' => Auth::id(),
                'is_moderator' => $this->isCreator,
            ]);
        }
    }

    public function leaveRoom()
    {
        $user = Auth::user();

        RoomAttendee::where('room_id', $this->roomId)
            ->where('user_id', $user->id)
            ->delete();

        broadcast(new \App\Events\UserLeftRoom($user, $this->roomId))->toOthers();
        return redirect()->route('rooms.index');
    }

    public function getListeners()
    {
        return [
            "echo:room.{$this->roomId},UserJoinedRoom" => 'loadAttendees',
            "echo:room.{$this->roomId},UserLeftRoom" => 'loadAttendees',
            "echo:room.{$this->roomId},UserMuted" => 'loadAttendees',
        ];
    }

    public function render()
    {
        return view('livewire.room-attendance', [
            'attendees' => $this->attendees,
            'isMuted' => $this->isMuted,
            'isCreator' => $this->isCreator,
        ]);
    }
}
