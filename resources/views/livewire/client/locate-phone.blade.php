<div class="max-w-7xl mx-auto">
    <div class="flex items-end justify-end">
        {{-- Locate Phone Button --}}
        <div class="flex items-end justify-end mt-3 px-2 sm:p-0">
            <button wire:click="locatePhone"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Locate Phone
            </button>
        </div>
    </div>

    {{-- Google Maps --}}

    <div class="mt-4">
        @php
            $api_key = config('services.google_maps.key');
        @endphp
        <iframe 
            width="100%" height="450px" frameborder="0" style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key={{ $api_key }}&q={{ $lat }},+{{ $lng }}"
            allowfullscreen
            loading="lazy"
        ></iframe>
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
