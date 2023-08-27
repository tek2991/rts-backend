<div class="pb-12 max-w-7xl mx-auto">
    @livewire('client.device-status')

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mt-12">
        {{-- Lock Device Button --}}
        <div>
            <button wire:click="lockDevice"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Lock Device
            </button>
        </div>

        {{-- Unlock Device Button --}}
        <div>
            <button wire:click="unlockDevice"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Unlock Device
            </button>
        </div>
    </div>
</div>
