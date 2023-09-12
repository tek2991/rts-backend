<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hide App') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-0">
        @livewire('client.hide-app')
    </div>
</x-app-layout>
