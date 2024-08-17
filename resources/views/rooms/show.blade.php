@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Grid Layout for Video and Chat -->
        <div class="grid grid-cols-3 gap-4">
            <!-- Video Streaming and Controls Section (2/3 width) -->
            <div class="col-span-2 bg-gray-200 p-4 rounded shadow">
                <h2 class="text-xl font-bold mb-2">{{ $room->name }}</h2>
                <p class="mb-4">Room Code: {{ $room->code }}</p>

                @role('creator')
                <button class="bg-red-500 text-white px-4 py-2 mb-4"
                        onclick="document.getElementById('end-meeting-form').submit();">
                    End Meeting
                </button>

                <form id="end-meeting-form" action="{{ route('rooms.end', $room->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
                @endrole

                @role('attendee|creator')
                <livewire:stream :room="$room" />
                @endrole

                @role('attendee')
                <livewire:raise-hand :roomId="$room->id" />
                @endrole

                @role('creator')
                <livewire:hand-response :roomId="$room->id" />



                @endrole
                <livewire:room-attendance :roomId="$room->id" />
            </div>

            <!-- Chat Section (1/3 width) -->
            <div class="bg-gray-200 p-4 rounded shadow">
                <h2 class="text-xl font-bold mb-2">Chat</h2>
                <div class="h-80 overflow-auto">
                    @livewire('chat')
                </div>
            </div>
        </div>

        <!-- Whiteboard Section -->
        <div class="mt-4 bg-gray-200 p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Whiteboard</h2>
            <livewire:whiteboard :roomId="$room->id" />
        </div>
    </div>
@endsection
