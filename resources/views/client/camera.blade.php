<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Camera Control') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-4">
        @livewire('client.control-camera')
    </div>
</x-app-layout>
