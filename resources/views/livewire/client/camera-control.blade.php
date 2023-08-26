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

    <div class="flex items-end justify-end mt-4">
        <div class="mt-4">
            <button wire:click="takePicture"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Take Photo
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
        @forelse ($images as $image)
            <div>
                <div class="border-2 p-1 rounded-md">
                    <a href="{{ asset('storage/images/' . $image->filename) }}" data-lightbox="photo" data-title="{{ $image->created_at->format('M d, Y h:i A') }}">
                        <img src="{{ asset('storage/images/' . $image->filename) }}" alt="Tools"
                            class="w-full h-56 object-contain">
                    </a>
                    <p class="text-center text-sm pt-2">
                        {{ $image->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="col-span-2">
                <p class="text-center">No images taken yet.</p>
            </div>
        @endforelse
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