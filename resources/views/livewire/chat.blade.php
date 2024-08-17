<div>
    <div class="p-2 border-b border-gray-300 font-bold bg-gray-200">Chat</div>
    <div id="chat-messages" class="overflow-auto p-2 h-64">
        @foreach($messages as $message)
            <div class="chat-message p-2 border-b border-gray-300">
                <strong>{{ $message->user->name }}:</strong> {{ $message->body }}
            </div>
        @endforeach
    </div>
    <div class="p-2 border-t border-gray-300">
        <input id="chat-input" wire:model="message" type="text" placeholder="Type a message..." class="w-full p-2 border border-gray-300 rounded">
        <button wire:click="sendMessage" class="bg-blue-500 text-white p-2 rounded mt-2">Send</button>
    </div>
</div>
