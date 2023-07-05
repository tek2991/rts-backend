<div>
    <form wire:submit.prevent="calculateSubscriptionCost">
        <div class="max-w-xs items-center mx-auto">
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Package
                    Price</label>
                <input type="text" id="first_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly value="Rs {{ $package->price }}/-">
            </div>
            {{-- Discount Amount --}}
            <div class="mt-4">
                <label for="discount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Discount
                    Amount</label>
                <input type="text" id="discount"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly value="Rs {{ $discount_amount }}/-">
                @if ($coupon)
                    {{-- Message if Coupon is applied --}}
                    <label for="discount"
                        class="block mb-2 text-sm font-medium text-green-600 dark:text-white mt-2">Coupon
                        Applied! You just saved {{ $coupon->discount_percentage }}%</label>
                @endif
            </div>
            {{-- Coupon code --}}
            <div class="mt-4">
                <label for="coupon_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coupon
                    Code</label>
                <input type="text" id="coupon_code" wire:model="coupon_code"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-slate-100"
                    :disabled="{{ $coupon }}" required>
                @error('coupon_code')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror

                {{-- Apply coupon --}}
                @if (!$coupon)
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold text-xs py-1.5 px-2 rounded">Apply
                            Coupon</button>
                    </div>
                @endif
            </div>

            {{-- Total Amount --}}
            <div class="mt-4">
                <label for="amount_payable" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Amount Payable</label>
                <input type="text" id="amount_payable"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    readonly value="Rs {{ $cost }}/-">
            </div>
        </div>

        {{-- Payment Button --}}
        <div class="max-w-xs items-center mx-auto">
            <div class="mt-4">
                <button type="button" wire:click="payNow"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Pay
                    Now</button>
            </div>
        </div>
    </form>
</div>
