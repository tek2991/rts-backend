<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Coupon') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        <h2 class="text-xl font-regular pt-2 pb-4">Coupon details</h2>
        <x-validation-errors class="mb-4" />
        <form action="{{ route('coupon.store') }}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:w-1/2 gap-6">
                {{-- Code --}}
                <div>
                    <x-label for="code" :value="__('Coupon Code')" />
                    <x-input id="code" class="block mt-1 w-full" type="text" required name="code"
                        value="{{ old('code') }}" />
                </div>
                
                {{-- Promoter name --}}
                <div>
                    <x-label for="promoter_name" :value="__('Promoter Name')" />
                    <x-input id="promoter_name" class="block mt-1 w-full" type="text" required name="promoter_name"
                        value="{{ old('promoter_name') }}" />
                </div>

                {{-- Max use --}}
                <div>
                    <x-label for="max_use" :value="__('Max Use')" />
                    <x-input id="max_use" class="block mt-1 w-full" type="number" required name="max_use"
                        value="{{ old('max_use') }}" />
                </div>

                {{-- Discount --}}
                <div>
                    <x-label for="discount" :value="__('Discount %')" />
                    <x-input id="discount" class="block mt-1 w-full" type="number" required name="discount_percentage"
                        value="{{ old('discount') }}" />
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
