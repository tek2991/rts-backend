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

    {{-- Text to speech form --}}
    <div class="my-8 bg-white rounded-lg shadow-lg p-4">
        <div class="my-4 w-full sm:max-w-xs">
            <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a
                Language</label>
            <select id="countries" wire:model="selected_language"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                @foreach ($languages as $id => $language)
                    <option value="{{ $id }}">{{ $language }}</option>
                @endforeach
            </select>
        </div>

        <div class="my-4 w-full sm:max-w-xs">
            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Text ({{ $message_length }}/160)</label>
            <textarea id="text" wire:model="message"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="160"
                rows="3"></textarea>
        </div>

        {{-- Send Button --}}
        <div class="flex items-center justify-end">
            <button wire:click="sendTextToSpeech"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
               Send
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
