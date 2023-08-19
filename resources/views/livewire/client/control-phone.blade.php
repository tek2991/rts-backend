<div class="pb-12 max-w-7xl mx-auto">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        <div class="flex items-center">
            <div>
                <span class="font-semibold">
                    Device Status:
                </span>
                {{ $formatted_device_status }}
            </div>
            {{-- Refresh button --}}
            <div class="ml-auto">
                <button wire:click="refreshDeviceStatus"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                        <path fill-rule="evenodd"
                            d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z"
                            clip-rule="evenodd" />
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>

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

        {{-- Set Alarm --}}
        <div>
            <button wire:click="setAlarm"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Set Alarm
            </button>
        </div>

        {{-- Stop Alarm --}}
        <div>
            <button wire:click="stopAlarm"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Stop Alarm
            </button>
        </div>

        {{-- Lost Message --}}
        <div>
            <button wire:click="lostMessage"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Lost Message
            </button>
        </div>

        {{-- Start Service --}}
        <div>
            <button wire:click="startService"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Start Service
            </button>
        </div>

        {{-- Stop Service --}}
        <div>
            <button wire:click="stopService"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5">
                    <path fill-rule="evenodd"
                        d="M10 2a3 3 0 00-3 3v1H6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-1V5a3 3 0 00-3-3zm-3 5h8v8h-8V7z"
                        clip-rule="evenodd" />
                </svg>
                Stop Service
            </button>
        </div>

    </div>

    {{-- Hidden button to refresh --}}
    <button wire:click="contRefresh" class="hidden" id="cont-refresh-device-status"></button>
    <script>
        // Refresh device status every 3 seconds
        setInterval(function() {
            document.getElementById('cont-refresh-device-status').click();
        }, 3000);
    </script>
</div>
