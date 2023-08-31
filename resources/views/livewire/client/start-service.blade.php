<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 gap-8 mt-12 p-2 sm:p-0">
        {{-- Start Service --}}
        <div class="">
            <button wire:click="startService"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center sm:max-w-xs">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 00-2 0v2a1 1 0 002 0V9zm4 0a1 1 0 112 0v2a1 1 0 11-2 0V9z"
                        clip-rule="evenodd" />
                </svg>
                Start Service
            </button>
        </div>

        {{-- Stop Service --}}
        <div class="">
            <button wire:click="stopService"
                class="w-full bg-orange-500 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded flex items-center sm:max-w-xs">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 00-2 0v2a1 1 0 002 0V9zm4 0a1 1 0 112 0v2a1 1 0 11-2 0V9z"
                        clip-rule="evenodd" />
                </svg>
                Stop Service
            </button>
        </div>

    </div>
</div>
