<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subscriptions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @livewire('client.subscriptions')
    </div>
</x-app-layout>
