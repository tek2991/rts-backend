<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Coupon') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-12">
        <h2 class="text-xl font-regular pt-2 pb-4">Coupon details</h2>
        <x-validation-errors class="mb-4" />
        <form action="{{ route('coupon.update', $coupon) }}" method="post">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-label for="code" :value="__('Coupon Code')" />
                    <x-input id="code" class="block mt-1 w-full" type="text" name="code" value="{{ $coupon->code }}" />
                </div>

                <div>
                    <x-label for="promoter_name" :value="__('Promoter Name')" />
                    <x-input id="promoter_name" class="block mt-1 w-full" type="text" name="promoter_name"
                        value="{{ $coupon->promoter_name }}" />
                </div>

                <div>
                    <x-label for="max_use" :value="__('Max Use')" />
                    <x-input id="max_use" class="block mt-1 w-full" type="number" name="max_use"
                        value="{{ $coupon->max_use }}" />
                </div>

                <div>
                    <x-label for="discount" :value="__('Discount %')" />
                    <x-input id="discount" class="block mt-1 w-full" type="number" name="discount_percentage"
                        value="{{ $coupon->discount_percentage }}" />
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
