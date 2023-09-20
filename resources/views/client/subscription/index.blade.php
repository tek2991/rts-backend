<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subscriptions') }}
        </h2>
    </x-slot>

    <div class="mt-6 p-2 sm:px-0 flex items-center justify-between">
        <a href="{{ route('client.package.index') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500">Buy
            Subscription</a>

        {{-- Download apk --}}
        <a href="{{ route('client.package.index') }}"
            class="py-2 text-sm font-medium text-blue-500 hover:underline hover:text-blue-600 flex">
            {{-- Logo --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Download APK
        </a>
    </div>

    <div class="py-6">
        @livewire('client.subscriptions')
    </div>
</x-app-layout>
