<div>
    <button
        id="raise-hand-button"
        wire:click="raiseHand"
        class="bg-blue-500 text-white px-4 py-2 rounded {{ $handRaised ? 'bg-gray-500 cursor-not-allowed' : '' }}"
        {{ $handRaised ? 'disabled' : '' }}
    >
        {{ $handRaised ? 'Hand Raised' : 'Raise Hand' }}
    </button>
</div>
