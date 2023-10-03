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
        {{-- @livewire('jetstream.navigation-menu', ['page' => $page]) --}}

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dealers') }}
                    </h2>
                    <x-button-link href="{{ route('public.dealer.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Apply for Dealership</span>
                    </x-button-link>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <div class="pt-0 mt-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                        @livewire('public-dealer-table')
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
