<div class="max-w-7xl mx-auto">
    <div class="flex items-end justify-end">
        <div class="flex items-end justify-end mt-3 px-2 sm:p-0">
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

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 p-2 sm:p-0 mt-6">
        @forelse ($images as $image)
            <div>
                <div class="border-2 p-1 rounded-md">
                    <a href="{{ asset('storage/images/' . $image->filename) }}" data-lightbox="photo"
                        data-title="{{ $image->created_at->format('M d, Y h:i A') }}">
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
    <button wire:click="contRefreshComponentSpecific" class="hidden" id="cont-refresh-component-specific"></button>
    <script>
        // Refresh device status every 3 seconds
        setInterval(function() {
            document.getElementById('cont-refresh-component-specific').click();
        }, 3000);
    </script>
</div>
