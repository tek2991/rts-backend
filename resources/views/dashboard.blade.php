<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @livewire('dashboard')
</x-app-layout>
