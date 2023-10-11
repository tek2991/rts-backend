<x-app-alternate-layout>
    <x-slot name="header">
        {{-- Back to packages --}}
        <a href="{{ route('public.package.index') }}"
            class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-400 flex items-center transition">
            <svg class="w-6 h-6 mr-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 010 1.414L2.414 12H13a1 1 0 110 2H2.414l2.879 2.879a1 1 0 11-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-lg font-semibold hover:underline transition duration-300 pt-1"> Back to packages </span>
        </a>
    </x-slot>

    <div>
        @livewire('public-confirm-payment')
    </div>
</x-app-alternate-layout>
