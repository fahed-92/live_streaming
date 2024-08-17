<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="room-id" content="{{ isset($room) ? $room->id : '' }}">
    <title>Live Streaming App</title>


    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /*!* Custom CSS for video and chat styling *!*/
        /*.video-container {*/
        /*    position: relative;*/
        /*    width: 100%;*/
        /*    height: 100%;*/
        /*    overflow: hidden;*/
        /*}*/
        /*.video-stream {*/
        /*    position: absolute;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    width: 100%;*/
        /*    height: 100%;*/
        /*    object-fit: cover;*/
        /*}*/
        /*.controls {*/
        /*    position: absolute;*/
        /*    bottom: 1rem;*/
        /*    left: 1rem;*/
        /*    right: 1rem;*/
        /*    display: flex;*/
        /*    justify-content: space-between;*/
        /*    align-items: center;*/
        /*}*/
        /*.chat-area {*/
        /*    position: absolute;*/
        /*    top: 1rem;*/
        /*    right: 1rem;*/
        /*    bottom: 1rem;*/
        /*    width: 300px;*/
        /*    background-color: #ffffff;*/
        /*    border-radius: 0.5rem;*/
        /*    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);*/
        /*    overflow-y: auto;*/
        /*}*/
        /*.chat-message {*/
        /*    padding: 0.5rem;*/
        /*    border-bottom: 1px solid #ddd;*/
        /*}*/
    </style>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">

    <!-- Rooms Area -->
    <div class="flex-1">
        @yield('content')
    </div>

</div>
@livewireScripts

<script>
    // JavaScript for video and chat functionality
    const muteBtn = document.getElementById('mute-btn');
    const cameraBtn = document.getElementById('camera-btn');
    const handBtn = document.getElementById('hand-btn');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    chatInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            const message = chatInput.value;
            if (message.trim()) {
                const messageElem = document.createElement('div');
                messageElem.className = 'chat-message';
                messageElem.textContent = message;
                chatMessages.appendChild(messageElem);
                chatInput.value = '';
            }
        }
    });
</script>

</body>
</html>
