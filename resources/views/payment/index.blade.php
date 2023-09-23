<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payments') }}
            </h2>
        </div>
    </x-slot>


    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        @livewire('payment-table')
    </div>

</x-app-layout>
