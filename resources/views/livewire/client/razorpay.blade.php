<div>
    @if ($razor_order_generated === false)
        <div class="max-w-xs items-center mx-auto">
            <div class="mt-4">
                <button type="button" wire:click="createRazorpayOrder"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    Pay Now
                </button>
                <p>
                    <small class="text-gray-500">* You will be redirected to the payment gateway to
                        complete the payment.</small>
                </p>
            </div>
        </div>
    @else
        <div class="max-w-xs items-center mx-auto mt-4">
            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded"
                type="button" id="rzp-button">Pay Now</button>
            <p>
                <small class="text-gray-500">* You will be redirected to the payment gateway to
                    complete the payment.</small>
            </p>
        </div>
        <script>
            var options = {
                "key": "{{ $razorpay_key }}",
                "amount": "{{ $session_data['gross_amount'] * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "INR",
                "name": "{{ $session_data['app_name'] }}", //your business name
                "description": "{{ $session_data['package']['name'] }}",
                "image": "{{ $session_data['logo'] }}",
                "order_id": "{{ $razor_order_data['id'] }}",
                //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "callback_url": "{{ $session_data['callback_url'] }}",
                "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                    "name": "{{ $session_data['user']['name'] }}",
                    "email": "{{ $session_data['user']['email'] }}",
                    "contact": "{{ $session_data['user']['mobile_number'] }}",
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            document.getElementById('rzp-button').onclick = function(e) {
                rzp1.open();
                e.preventDefault();
            }

            // click rzp-button button automatically after 2 seconds
            setTimeout(function() {
                document.getElementById('rzp-button').click();
            }, 2000);
        </script>
    @endif
</div>
