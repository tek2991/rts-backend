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
                <label for="coupon_code"
                    class="mb-2 text-sm font-medium text-gray-900 dark:text-white flex justify-between">
                    <span>Coupon Code</span>
                    @if (!$coupon)
                        <button type="button" data-modal-target="coupon-modal" data-modal-toggle="coupon-modal"
                            class="text-sm font-semibold text-blue-400 hover:text-blue-600 hover:underline">
                            View Coupons
                        </button>
                        <button type="button" wire:click="removeCoupon"
                            class="hidden text-sm font-semibold text-red-400 hover:text-red-600 hover:underline">
                            Remove Coupon
                        </button>
                    @else
                        <button type="button" data-modal-target="coupon-modal" data-modal-toggle="coupon-modal"
                            class="hidden text-sm font-semibold text-blue-400 hover:text-blue-600 hover:underline">
                            View Coupons
                        </button>
                        <button type="button" wire:click="removeCoupon"
                            class="text-sm font-semibold text-red-400 hover:text-red-600 hover:underline">
                            Remove Coupon
                        </button>
                    @endif
                </label>
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

    <!-- Main modal -->
    <div id="coupon-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="coupon-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <!-- Modal header -->
                <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white">
                        Available coupons
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-6">
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Select a coupon to apply it to your subscription. You can only apply one coupon at a time.
                    </p>
                    <ul class="my-4 space-y-3">
                        @foreach ($coupons as $coupon)
                            <li>
                                <button type="button" wire:click="applySelectedCoupon('{{ $coupon->code }}')"
                                    data-modal-hide="coupon-modal"
                                    class="w-full p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow">
                                    <span class="text-center">
                                        {{ $coupon->code }} - {{ $coupon->discount_percentage }}% off
                                    </span>
                                    <p class="text-base text-gray-600">
                                        {{ $coupon->promoter_name }}
                                    </p>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
