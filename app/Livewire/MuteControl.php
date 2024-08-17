<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\RoomAttendee;
use Illuminate\Support\Facades\Auth;
use App\Events\UserMuted;

class MuteControl extends Component
{
    public $roomId;
    public $users;
    public $isMuted = false;  // Track the state of mute/unmute

    public function mount($roomId)
    {
        $this->roomId = $roomId;
        $this->users = RoomAttendee::where('room_id', $roomId)->with('user')->get();
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
        $user = User::find($userId);
        if ($user) {
            $user->toggleMute($this->roomId);  // Pass the roomId to toggleMute
            $this->updateMuteStatus();
        }
    }

    public function muteAll()
    {
        foreach ($this->users as $user) {
            if ($user->id !== Auth::id()) {
                $user->user->toggleMute($this->roomId);  // Pass the roomId to toggleMute
            }
        }
        $this->updateMuteStatus();
    }

    public function unmuteAll()
    {
        foreach ($this->users as $user) {
            if ($user->id !== Auth::id()) {
                $user->user->is_muted = false;
                $user->user->save();
                broadcast(new UserMuted($user->user->id, $user->user->is_muted, $this->roomId));
            }
        }
        $this->updateMuteStatus();
    }

    private function updateMuteStatus()
    {
        // Determine if all users are muted
        $this->isMuted = $this->users->every(fn($user) => $user->user->is_muted);
    }

    public function render()
    {
        return view('livewire.mute-control', [
            'users' => $this->users,
            'isMuted' => $this->isMuted,
        ]);
    }
}
