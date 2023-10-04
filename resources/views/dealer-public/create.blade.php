<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dealership Application') }}
                    </h2>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <div class="pt-0 mt-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="overflow-hidden sm:rounded-lg p-4">
                            <h2 class="text-xl font-regular pt-2 pb-4">Contact details</h2>
                            <x-validation-errors class="mb-4" />
                            <form action="{{ route('public.dealer.store') }}" method="post">
                                @csrf
                                <div class="grid grid-cols-1 md:w-1/2 gap-6">
                                    {{-- Name --}}
                                    <div>
                                        <x-label for="name" :value="__('Name')" />
                                        <x-input id="name" class="block mt-1 w-full" type="text" required
                                            name="name" value="{{ old('name') }}" />
                                    </div>
                                    {{-- Email --}}
                                    <div>
                                        <x-label for="email" :value="__('Email')" />
                                        <x-input id="email" class="block mt-1 w-full" type="email" required
                                            name="email" value="{{ old('email') }}" />
                                    </div>
                                    {{-- Mobile --}}
                                    <div>
                                        <x-label for="mobile_number" :value="__('Mobile')" />
                                        <x-input id="mobile_number" class="block mt-1 w-full" type="number" required
                                            name="mobile_number" value="{{ old('mobile_number') }}" />
                                    </div>
                                    {{-- Message --}}
                                    <div>
                                        <x-label for="message" :value="__('Message')" />
                                        <x-text-area id="message" class="block mt-1 w-full" required name="message">
                                            {{ old('message') }} </x-text-area>
                                    </div>
                                    {{-- Acknowledgement check box --}}
                                    <div class="flex">
                                        <x-checkbox id="acknowledgement" required
                                        name="acknowledgement" />
                                        <p class="ml-2 text-sm text-gray-500">
                                            I do hereby give my consent to receive communication from
                                            {{ config('app.name', 'Laravel') }} on my given contact details.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-button class="ml-4">
                                        {{ __('Save') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts
    @livewire('livewire-ui-modal')
</body>

</html>
