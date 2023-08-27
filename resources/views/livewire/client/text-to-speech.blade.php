<div class="pb-12 max-w-7xl mx-auto">
    @livewire('client.device-status')
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
</div>
