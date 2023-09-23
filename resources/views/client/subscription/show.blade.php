<x-app-layout>
    <x-slot name="header">
        {{-- Back to subscriptions --}}
        <a href="{{ route('client.subscription.index') }}"
            class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-400 flex items-center transition">
            <svg class="w-6 h-6 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 010 1.414L2.414 12H13a1 1 0 110 2H2.414l2.879 2.879a1 1 0 11-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-lg font-semibold hover:underline transition duration-300 pt-1"> All Subscriptions </span>
        </a>
    </x-slot>

    <section class="bg-white dark:bg-gray-900 mt-8">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-8">
                @if ($subscription->package)
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        {{ $subscription->package->name }}
                    </h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                        Best option for personal use & for your next project.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            Validity: <span class="font-semibold">{{ $subscription->package->duration_in_days }}
                                days</span>
                        </div>
                        <div>
                            Price: <span class="font-semibold">Rs {{ $subscription->package->price }}/-</span>
                        </div>
                        <div>
                            Devices: <span class="font-semibold">1</span>
                        </div>
                    </div>
                @endif
            </div>
            @if ($subscription->activationCode)
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-8">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        {{ $subscription->activationCode->code }}
                    </h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                        Activation Code
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            Validity: <span class="font-semibold">{{ $subscription->activationCode->duration_in_days }}
                                days</span>
                        </div>
                        <div>
                            Price: <span class="font-semibold">Rs {{ $subscription->activationCode->price }}/-</span>
                        </div>
                        <div>
                            Devices: <span class="font-semibold">1</span>
                        </div>
                    </div>
                </div>
            @endif
            @if ($subscription->package)
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-8">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        Payment Details
                    </h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                        Here are the payment details of your subscription.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            Payment ID: <span class="font-semibold">
                                {{ $subscription->payment->payment_id ?? 'N/A' }}
                            </span>
                        </div>
                        <div>
                            Status: <span class="font-semibold">
                                {{ $subscription->payment->payment_status ?? 'N/A' }}
                            </span>
                        </div>
                        <div>
                            Payment Date: <span class="font-semibold">
                                {{ $subscription->payment->updated_at ?? 'N/A' }}
                            </span>
                        </div>

                        <div>
                            Amount Paid: <span class="font-semibold">
                                Rs. {{ $subscription->payment->amount ?? 'N/A' }}/-
                            </span>
                        </div>

                        <div>
                            Discount: <span class="font-semibold">
                                Rs. {{ $subscription->discount_amount ?? 'N/A' }}/-
                            </span>
                        </div>

                        <div>
                            Coupon: <span class="font-semibold">
                                {{ $subscription->coupon_code ?? 'N/A' }}
                            </span>
                        </div>

                        <div>
                            Start Date: <span class="font-semibold">
                                {{ $subscription->started_at ?? 'N/A' }}
                            </span>
                        </div>

                        <div>
                            End Date: <span class="font-semibold">
                                {{ $subscription->expires_at ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
