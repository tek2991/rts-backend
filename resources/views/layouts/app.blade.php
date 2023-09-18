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
        @php
            $name = request()
                ->route()
                ->getName();
            // Get the last segment of the route name, e.g. 'dashboard' from 'client.dashboard'
            $name = explode('.', $name)[count(explode('.', $name)) - 1];
            // If name is index or create or edit, then set it to the previous segment and pluralize it
            if (in_array($name, ['index', 'create', 'edit'])) {
                $name = explode('.', request()->route()->getName())[count(explode('.', request()->route()->getName())) - 2];
                $name = Str::plural($name);
            }
            // Capitalize the first letter of the last segment of the route name
            $page = ucfirst($name);
        @endphp

        @livewire('jetstream.navigation-menu', ['page' => $page])

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                @hasrole('client')
                    @livewire('client.device-status', ['page' => $page])
                @endhasrole

                @hasanyrole('administrator|manager')
                    <div class="max-w-7xl mx-auto pb-4 px-4 sm:px-6 lg:px-8 hidden sm:block">
                        {{ $header }}
                    </div>
                @endhasanyrole
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div class="pt-0">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-8">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts
    @livewire('livewire-ui-modal')
</body>

</html>
