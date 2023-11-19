<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Package
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Amount Paid
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Discount
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Validity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    @php
                        $package = $subscription->package ? $subscription->package->name : false;
                        $coupon = $subscription->coupon ? $subscription->coupon->name : false;
                        $activation_code = $subscription->activation_code ? $subscription->activation_code : false;
                    @endphp
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $package ? $package : $activation_code }}
                        </th>
                        <td class="px-6 py-4">
                            Rs. {{ $subscription->net_amount }}/-
                        </td>
                        <td class="px-6 py-4">
                            {{ $coupon ? $subscription->discount_amount . ' ' . $coupon->discount_percentage . '%' : '' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $subscription->started_at . ' - ' . $subscription->expires_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $subscription->status }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('client.subscription.show', $subscription->id) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border-t dark:border-gray-600 sm:px-6">
            {{ $subscriptions->links() }}
        </div>
    </div>

</div>
