<div class="max-w-7xl mx-auto">
    <div class="flex items-end justify-between">
        <div class="flex items-end justify-end mt-3 px-2 sm:p-0">
            <button wire:click="loadVideos"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 pr-1">
                    <path fill-rule="evenodd"
                        d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z"
                        clip-rule="evenodd" />
                </svg>
                Refresh
            </button>
        </div>
        <div class="flex items-end justify-end mt-3 px-2 sm:p-0">
            <button wire:click="recordVideo"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                Record Video
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-2 sm:p-0 mt-6">
        @forelse ($videos as $video)
            <div>
                <div class="border-2 p-1 rounded-md">
                    {{-- Delete button or upper right corner --}}
                    <div class="flex justify-end">
                        <button
                            wire:click="$emit('openModal', 'confirm-delete-modal', {{ json_encode(['route' => 'client.video-recorder.destroy', 'model_id' => $video->id, 'model_name' => 'Video', 'action' => 'delete']) }})"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <video controls class="w-full">
                        <source src="{{ $video->s3Url() }}" type="video/mp4">
                        Your browser does not support the video element.
                    </video>
                    <p class="text-center text-sm pt-2">
                        {{ $video->created_at->format('M d, Y h:i A') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="col-span-2">
                <p class="text-center">No voice recordings.</p>
            </div>
        @endforelse
    </div>
</div>
