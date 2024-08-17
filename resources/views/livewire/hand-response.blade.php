<div>
    @role('creator')
    <div>
        @foreach($handRaiseRequests as $request)
            <div class="flex items-center mb-2">
                <span class="mr-2">{{ $request->user->name }} wants to speak</span>
                <button wire:click="handleResponse({{ $request->user_id }}, 'allow')" class="bg-green-500 text-white px-2 py-1 rounded mr-2">Allow</button>
                <button wire:click="handleResponse({{ $request->user_id }}, 'deny')" class="bg-red-500 text-white px-2 py-1 rounded">Deny</button>
            </div>
        @endforeach
    </div>
    @endrole
</div>
