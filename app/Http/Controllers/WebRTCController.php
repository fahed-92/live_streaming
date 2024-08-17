<?php

namespace App\Http\Controllers;

use App\Events\WebRTCSignal;
use App\Models\Room;
use Illuminate\Http\Request;

class WebRTCController extends Controller
{
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function signal(Request $request, $id)
    {
        $request->validate([
            'offer' => 'nullable|array',
            'answer' => 'nullable|array',
            'candidate' => 'nullable|array',
            'raiseHand' => 'nullable|boolean',
        ]);

        broadcast(new WebRTCSignal($request->all(), $id));
    }
}

