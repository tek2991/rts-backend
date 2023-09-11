<div class="max-w-7xl mx-auto">
    <div class="flex items-end justify-end">
        <div class="flex items-end justify-end mt-3 px-2 sm:p-0">
            <button wire:click="recordScreen"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Record Screen
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-2 sm:p-0 mt-6">
        @forelse ($screenRecordings as $recording)
            <div>
                <div class="border-2 p-1 rounded-md">
                    {{-- Delete button or upper right corner --}}
                    <div class="flex justify-end">
                        <button wire:click="$emit('openModal', 'confirm-delete-modal', {{ json_encode(['route' => 'client.screen-recorder.destroy', 'model_id'=> $recording->id, 'model_name'=> 'Screen Recording', 'action'=> 'delete']) }})"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <video controls class="w-full">
                        <source src="{{ asset('storage/screen_recordings/' . $recording->filename) }}" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    <p class="text-center text-sm pt-2">
                        {{ $recording->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="col-span-2">
                <p class="text-center">No screen recordings yet.</p>
            </div>
        @endforelse
    </div>
</div>
