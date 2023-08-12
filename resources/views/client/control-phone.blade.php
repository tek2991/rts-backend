<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Control Phone') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-4">
        @livewire('client.control-phone')
    </div>
</x-app-layout>
