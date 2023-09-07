<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subscriptions') }}
        </h2>
    </x-slot>

    <div class="mt-6 p-2 flex items-center gap-4">
        <a href="{{ route('client.package.index') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500">Buy
            Subscription</a>
    </div>

    <div class="py-6">
        @livewire('client.subscriptions')
    </div>
</x-app-layout>
