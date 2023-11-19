<div>
    @if ($payment_gateway == 'razorpay')
        @livewire('client.razorpay')
    @else
        <form action="{{ $payment_route }}" method="GET">
            <div class="max-w-xs items-center mx-auto">
                <div class="mt-4">
                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                        Pay Now
                    </button>
                    <p>
                        <small class="text-gray-500">* You will be redirected to the payment gateway to
                            complete the payment.</small>
                    </p>
                </div>
            </div>
        </form>
    @endif
</div>
