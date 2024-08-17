<div>
    <!-- Checkbox to mute/unmute all users -->
    @if ($isCreator) <!-- Show the checkbox only if the user is the creator -->
        <label>
            <input type="checkbox" wire:model="isMuted" wire:change="toggleMuteAll($event.target.checked)" />
            {{ $isMuted ? 'Unmute All' : 'Mute All' }}
        </label>
    @endif

    <h3 class="font-bold mt-4">Room Attendees</h3>
    <ul class="mt-4">
        @foreach($attendees as $attendee)
            @if ($attendee->user)
                <li id="user-{{ $attendee->user->id }}" class="flex items-center mb-2 {{ $attendee->user->is_muted ? 'text-gray-500' : '' }}">
                    <span class="mr-2">{{ $attendee->user->name }}</span>
                    @if ($isCreator) <!-- Show mute checkbox only if the user is the creator -->
                        <label class="ml-4">
                            <input type="checkbox" wire:model="userMuteStatus.{{ $attendee->user->id }}" wire:change="toggleMute({{ $attendee->user->id }})" />
                            {{ $attendee->user->is_muted ? 'Muted' : 'Unmuted' }}
                        </label>
                    @else
                        <span class="mute-status">{{ $attendee->user->is_muted ? 'Muted' : 'Unmuted' }}</span>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>

    <button wire:click="leaveRoom" class="bg-red-500 text-white p-2 rounded mt-2">Leave Room</button>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        window.Echo.channel('room.{{ $roomId }}')
            .listen('UserJoinedRoom', (event) => {
                Livewire.emit('loadAttendees');
            })
            .listen('UserLeftRoom', (event) => {
                const userElement = document.querySelector(`#user-${event.user.id}`);
                if (userElement) {
                    userElement.classList.add('text-gray-500');
                }
            })
            .listen('UserMuted', (event) => {
                const userElement = document.querySelector(`#user-${event.userId}`);
                if (userElement) {
                    const checkbox = userElement.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = event.isMuted;
                    }
                }
            });
    });
</script>
