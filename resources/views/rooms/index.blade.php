@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Rooms</h1>

        @role('creator')
        <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Create New Room</a>
        @endrole

        <div class="mt-4 grid grid-cols-1 gap-4">
            @foreach($rooms as $room)
                <div class="p-4 border rounded-lg">
                    <h2 class="text-xl font-semibold">{{ $room->name }}</h2>
                    <p class="text-gray-600">Room Code: {{ $room->code }}</p>
                    <a href="{{ route('rooms.show', $room->id) }}" class="text-blue-500">Join Room</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
