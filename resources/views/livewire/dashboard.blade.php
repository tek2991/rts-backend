<div>
    <div class="py-12" wire:ignore>
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($stats as $key => $item)
                            <a href="#" wire:click="select('{{ $key }}')">
                                <div class="flex items-center p-4 rounded-lg shadow-xs dark:bg-gray-800">
                                    <div
                                        class="p-2 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400">
                                            {{ $item['label'] }}
                                        </p>
                                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                            {{ $item['stat'] }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        @if ($selected == 'total_users')
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Total Users</h1>
            @livewire('user-table', ['clientsOnly' => true])
        @endif

        @if ($selected == 'users_without_subscription')
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Users Without Subscription</h1>
            @livewire('user-table', ['clientsOnly' => true, 'withoutSubscription' => true])
        @endif

        @if ($selected == 'users_with_subscription')
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Users With Subscription</h1>
            @livewire('user-table', ['clientsOnly' => true, 'withSubscription' => true])
        @endif

        @if ($selected == 'users_with_active_subscription')
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Users With Active Subscription</h1>
            @livewire('user-table', ['clientsOnly' => true, 'withActiveSubscription' => true])
        @endif

        @if ($selected == 'total_amount_of_subscriptions')
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Total Amount of Subscriptions</h1>
            @livewire('subscription-table')
        @endif
    </div>
</div>
