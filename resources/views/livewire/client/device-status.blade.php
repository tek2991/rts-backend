<div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">
        <div class="hidden sm:block text-xl text-gray-700 font-semibold">
            {{ $page }}
        </div>
        <div class="flex items-center justify-between">
            <div>
                <span class="font-semibold">
                    Device:
                </span>
                @if ($formatted_device_status == null)
                    <span class="text-red-600 font-semibold">
                        No Device found! <br>
                        <p class="text-xs">
                            Please register your device using the app.
                        </p>
                    </span>
                @else
                    <span class="text-green-600 font-semibold">
                        {{ $formatted_device_status }}
                    </span>
                @endif

            </div>
            {{-- Refresh button --}}
            <div class="ml-6">
                <button type="button" wire:click="refreshDeviceStatus" {{ $formatted_device_status == null ? 'disabled' : '' }}
                    class="px-2 py-1.5 text-xs font-bold text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 disabled:bg-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="w-4 h-4 mr-1.5">
                        <path fill-rule="evenodd"
                            d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z"
                            clip-rule="evenodd" />
                    </svg>
                    Refresh
                </button>
            </div>
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
