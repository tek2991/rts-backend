<div class="pb-12 max-w-7xl mx-auto">
    @livewire('client.device-status')
    <div class="flex items-end justify-end mt-4">
        {{-- Locate Phone Button --}}
        <div class="mt-4 flex items-end justify-end">
            <button wire:click="SyncCallLog"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Sync Call Logs
            </button>
        </div>
    </div>

    <div class="mt-8">
        @livewire('client.call-logs-table', ['user_id' => $user->id])
    </div>
</div>
