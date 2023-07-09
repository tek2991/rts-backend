<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Activation Code') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-12">
        <h2 class="text-xl font-regular pt-2 pb-4">Activation Code details</h2>
        <x-validation-errors class="mb-4" />
        <form action="{{ route('activation-code.update', $activationCode) }}" method="post">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Code --}}
                <div>
                    <x-label for="code" :value="__('Activation Code')" />
                    <x-input id="code" class="block mt-1 w-full" type="text" required name="code"
                        value="{{ $activationCode->code }}" />
                </div>
                {{-- Duration in days --}}
                <div>
                    <x-label for="duration" :value="__('Duration (In Days)')" />
                    <x-input id="duration" class="block mt-1 w-full" type="number" required name="duration"
                        value="{{ $activationCode->duration_in_days }}" />
                </div>
                {{-- Price --}}
                <div>
                    <x-label for="price" :value="__('Price (₹)')" />
                    <x-input id="price" class="block mt-1 w-full" type="number" required name="price"
                        value="{{ $activationCode->price }}" />
                </div>
                {{-- Expires at --}}
                <div>
                    <x-label for="expires_at" :value="__('Expires At')" />
                    <x-input id="expires_at" class="block mt-1 w-full" type="date" required name="expires_at"
                        value="{{ $activationCode->expires_at->format('Y-m-d') }}" />
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
