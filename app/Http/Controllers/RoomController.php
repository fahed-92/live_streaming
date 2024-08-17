<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function __construct()
    {
        // Apply role-based middleware
        $this->middleware('role:creator')->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('role:attendee|creator')->only(['show']);
    }

    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $room = Room::create([
            'name' => $request->name,
            'code' => uniqid(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('rooms.show', $room->id);
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * End the meeting for the specified room.
     */
    public function endMeeting(Room $room)
    {
        // You might want to add logic to update the room status, notify attendees, etc.
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Meeting ended successfully!');
    }

    /**
     * Handle WebRTC signaling for video streaming.
     */
    public function signal(Request $request, Room $room)
    {
        $data = $request->all();

        // Here, you can handle the signaling data
        // For example, broadcasting the signal to other participants in the room
        broadcast(new \App\Events\WebRTCSignal($room->id, $data))->toOthers();

        return response()->json(['status' => 'success']);
    }

}
