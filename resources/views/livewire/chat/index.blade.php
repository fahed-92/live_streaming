<div>
    <div class="p-2 border-b border-gray-300 font-bold bg-gray-200">Chat</div>
    <div id="chat-messages" class="overflow-auto p-2 h-64 flex flex-col-reverse">
        @foreach($messages as $message)
            <div class="chat-message p-2 border-b border-gray-300">
                <strong>{{ $message->user->name }}:</strong> {{ $message->body }}
            </div>
        @endforeach
    </div>
    <div class="p-2 border-t border-gray-300">
        <input id="chat-input" wire:model.lazy="message" type="text" placeholder="Type a message..." class="w-full p-2 border border-gray-300 rounded">

        @error('message')
        <div class="text-red-500 text-sm mt-1">
            {{ $message }}
        </div>
        @enderror

        <button wire:click="sendMessage" class="bg-blue-500 text-white p-2 rounded mt-2">Send</button>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('refreshMessages', function () {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to the bottom
            });
        });
    </script>
</div>
