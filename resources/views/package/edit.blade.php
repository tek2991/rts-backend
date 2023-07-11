<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit package') }}
        </h2>
    </x-slot>

    @livewire('update-package', ['package' => $package])
</x-app-layout>
