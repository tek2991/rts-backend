<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Start / Stop Alarm') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-4">
        @livewire('client.alarm')
    </div>
</x-app-layout>