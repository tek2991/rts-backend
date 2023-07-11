<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Activation Code') }}
        </h2>
    </x-slot>

    @livewire('update-activation-code', ['activationCode' => $activationCode])
</x-app-layout>
