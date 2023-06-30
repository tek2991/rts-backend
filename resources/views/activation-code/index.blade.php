<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activation Codes') }}
            </h2>
            @can('create', App\Models\ActivationCode::class)
                <x-button-link href="{{ route('activation-code.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Create Activation Code</span>
                </x-button-link>
            @endcan
        </div>
    </x-slot>


    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        @livewire('activation-code-table')
    </div>

</x-app-layout>
