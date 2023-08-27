<div class="max-w-7xl mx-auto">
    <div class="flex items-end justify-end">
        {{-- Locate Phone Button --}}
        <div class="flex items-end justify-end mt-3 p-2 sm:p-0">
            <button wire:click="SyncCallLog"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm7-8a7 7 0 11-14
                        0 7 7 0 0114 0z"
                        clip-rule="evenodd" />
                </svg>
                Sync Call Logs
            </button>
        </div>
    </div>

    <div class="p-2 sm:p-0 mt-1">
        @livewire('client.call-logs-table', ['user_id' => $user->id])
    </div>
</div>
