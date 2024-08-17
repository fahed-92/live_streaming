@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">Create a New Room</h1>

        <form action="{{ route('rooms.store') }}" method="POST" class="mt-4">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Room Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded mt-2" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Room</button>
        </form>
    </div>
@endsection
