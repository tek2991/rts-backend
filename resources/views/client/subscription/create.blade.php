<x-app-layout>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <x-slot name="header">
        {{-- Back to packages --}}
        <a href="{{ route('client.package.index') }}"
            class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-400 flex items-center transition">
            <svg class="w-6 h-6 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 010 1.414L2.414 12H13a1 1 0 110 2H2.414l2.879 2.879a1 1 0 11-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-lg font-semibold hover:underline transition duration-300 pt-1"> Back to packages </span>
        </a>
    </x-slot>

    <section class="bg-white dark:bg-gray-900 mt-8">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-8">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                    Confirm Payment
                </h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    Please confirm the payment details below.
                </p>
                {{-- Package name --}}
                <div>
                    Package Name: <span class="font-semibold">{{ $package->name }} ({{ $package->duration_in_days }}
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
                    Total Payable: <span class="font-semibold">Rs {{ $gross_amount }}/-</span>
                </div>

                {{-- Payment Button --}}
                {{-- <form action="" method="POST"> --}}
                @livewire('client.payment-button', ['payment_gateway' => $payment_gateway])
            </div>
            <p>
                @if ($payment_gateway == 'instamojo')
                    Powered by <a href="https://www.instamojo.com/" target="_blank"
                        class="text-green-500 hover:underline">
                        Instamojo
                    </a>
                @elseif ($payment_gateway == 'phonepe')
                    Powered by <a href="https://www.phonepe.com/" target="_blank"
                        class="text-green-500 hover:underline">
                        PhonePe
                    </a>
                @elseif ($payment_gateway == 'razorpay')
                    Powered by <a href="https://www.razorpay.com/" target="_blank"
                        class="text-green-500 hover:underline">
                        Razorpay
                    </a>
                @endif
            </p>
        </div>
    </section>
</x-app-layout>
