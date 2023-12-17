<div class="max-w-7xl mx-auto">
    <section class="bg-white dark:bg-gray-900 mt-8 pb-8">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                    <h2 class="mb-1 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        Payment Details
                    </h2>
                    <p class="mb-4 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                        Payment Gateway: {{ $payment->gateway ?? 'N/A' }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @if ($payment->gateway == 'instamojo')      
                            <div>
                                Payment ID: <span class="font-semibold">
                                    {{ $payment->payment_id ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="sm:col-span-3 text-left flex justify-between">
                                Payment Request ID: <span class="font-semibold">
                                    {{ $payment->payment_request_id ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="sm:col-span-3 text-left  flex justify-between">
                                Purpose: <span class="font-semibold">
                                    {{ $payment->purpose ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="sm:col-span-3 text-left  flex justify-between">
                                Mac: <span class="font-semibold">
                                    {{ $payment->mac ?? '' }}
                                </span>
                            </div>
                        @endif
                        @if ($payment->gateway == 'phonepe')
                            <div>
                                Order ID: <span class="font-semibold">
                                    {{ $payment->phonepe_order_id ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="sm:col-span-3 text-left flex justify-between">
                                Transaction ID: <span class="font-semibold">
                                    {{ $payment->phonepe_transaction_id ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="sm:col-span-3 text-left flex justify-between">
                                Merchant Transaction ID: <span class="font-semibold">
                                    {{ $payment->phonepe_merchant_transaction_id ?? 'N/A' }}
                                </span>
                            </div>
                        @endif
                        @if ($payment->gateway == 'razorpay')
                            <div>
                                Order ID: <span class="font-semibold">
                                    {{ $payment->razorpay_order_id ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="sm:col-span-3 text-left flex justify-between">
                                Payment ID: <span class="font-semibold">
                                    {{ $payment->razorpay_payment_id ?? 'N/A' }}
                                </span>
                            </div>
                        @endif
                        <div>
                            Redirected: <span class="font-semibold">
                                {{ $payment->redirected ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div>
                            Webhook Verified: <span class="font-semibold">
                                {{ $payment->webhook_verified ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div>
                            Status: <span class="font-semibold">
                                {{ $payment->payment_status ?? 'N/A' }}
                            </span>
                        </div>
                        <div>
                            Payment Date: <span class="font-semibold">
                                {{ $payment->updated_at ?? 'N/A' }}
                            </span>
                        </div>

                        <div>
                            Amount Paid: <span class="font-semibold">
                                Rs. {{ $payment->amount ?? 'N/A' }}/-
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
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-8">
                @if ($subscription->package)
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                        {{ $subscription->package->name }}
                    </h2>

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
        </div>

        <div>
            {{-- Recheck Payment button --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto">
                    <div class="mt-5 flex justify-center">
                        <button wire:click="recheckPayment"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
                            Recheck Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
