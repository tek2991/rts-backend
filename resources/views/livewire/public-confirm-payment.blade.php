<section class="bg-white dark:bg-gray-900 mt-8">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-8">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                Confirm Payment
            </h2>
            <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                Please confirm the payment details below.
            </p>
            <div>
                {{-- Package name --}}
                <div>
                    Package: <span class="font-semibold">{{ $package->name }} ({{ $package->duration_in_days }}
                        days)</span>
                </div>
                {{-- Package price --}}
                <div>
                    Price: <span class="font-semibold">Rs {{ $package->price }}/-</span>
                </div>
                {{-- Coupon --}}
                @if ($coupon)
                    <div>
                        Coupon: <span class="font-semibold">{{ $coupon->code }}</span>
                    </div>
                    {{-- Discount Amount --}}
                    <div>
                        Discount Amount: <span class="font-semibold">Rs {{ $discount_amount }}/-</span>
                    </div>
                @endif
                {{-- Taxable --}}
                <div>
                    Taxable: <span class="font-semibold">Rs {{ $net_amount }}/-</span>
                </div>
                {{-- Tax --}}
                <div>
                    Tax (GST {{ $tax_rate }}%): <span class="font-semibold">Rs {{ $tax }}/-</span>
                </div>
                {{-- Total Amount --}}
                <div>
                    Payable: <span class="font-semibold">Rs {{ $gross_amount }}/-</span>
                </div>
            </div>

            <button type="button"
                class="w-full max-w-xs mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded"
                data-modal-target="signup-modal" id="signup-modal-btn" data-modal-toggle="signup-modal">
                Continue to sign up
            </button>
        </div>
        <p>
            @if ($payment_gateway == 'instamojo')
                Powered by <a href="https://www.instamojo.com/" target="_blank" class="text-green-500 hover:underline">
                    Instamojo
                </a>
            @elseif ($payment_gateway == 'phonepe')
                Powered by <a href="https://www.phonepe.com/" target="_blank" class="text-green-500 hover:underline">
                    PhonePe
                </a>
            @endif
        </p>
    </div>

    <div id="signup-modal" tabindex="-1" aria-hidden="true" wire:ignore.self data-modal-backdrop="static"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Signup
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="signup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <x-validation-errors class="mb-4" />
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            wire:model="name" autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                            wire:model="email" autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="mobile_number" value="{{ __('Mobile Number (+91)') }}" />
                        <x-input id="mobile_number" class="block mt-1 w-full" type="number" name="mobile_number"
                            wire:model="mobile_number" autocomplete="mobile_number" length="10" />
                    </div>
                    <div class="flex">
                        <x-checkbox id="acknowledgement" wire:model="acknowledgement" />
                        <p class="ml-2 text-sm text-gray-500">
                            I do hereby give my consent to receive communication from
                            {{ config('app.name', 'Laravel') }} on my given contact details.
                        </p>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button" wire:click="register"
                        class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Register & Pay
                    </button>
                    <button data-modal-hide="signup-modal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</section>
