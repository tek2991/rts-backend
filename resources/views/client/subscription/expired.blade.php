<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-8">
                <h2 class="text-2xl font-semibold text-center">
                    <span class="text-3xl text-orange-500">Oops!</span> <br>
                    You have <span class="text-red-600">no</span> active subscription!
                </h2>

                <div class="mt-8 flex items-center justify-center">
                    <a href="{{ route('client.packages') }}" class="bg-blue-500 hover:bg-blue-600 shadow-md text-white rounded-md px-4 py-2.5">Buy Subscription</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
