<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Activation Code') }}
        </h2>
    </x-slot>

    @livewire('create-activation-code')
</x-app-layout>
