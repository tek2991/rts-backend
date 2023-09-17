<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Video Recorder') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-0">
        @livewire('client.video-recorder')
    </div>
</x-app-layout>
