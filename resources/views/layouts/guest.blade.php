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
</head>

<body class="bg-gray-100">
    {{-- If route is not login or register --}}
    @if (!in_array(Route::currentRouteName(), ['login', 'register']))
        <div class="px-4 mb-8 mt-4 w-full flex justify-center">
            <a href="{{ route('login') }}" class="hover:underline">
                login
            </a>
            <span class="px-3">|</span>

            <a href="{{ route('register') }}" class="hover:underline">
                register
            </a>
        </div>
    @endif

    <div class="font-sans text-gray-900 antialiased">
        <div>
            {{ $slot }}
        </div>
    </div>
    <div class="px-4 w-full bg-black text-gray-50 mt-8">
        <div
            class="sm:flex sm:justify-between mx-auto max-w-7xl sm:px-4 md:px-6 lg:px-8 py-4 text-center sm:text-start font-semibold">
            <p class="text-sm">
                This website is managed by Privatech Garden LLP
            </p>
            <p class="text-sm pt-2 sm:pt-0">
                <a href="{{ route('contact-us') }}" class="hover:underline">
                    Contact Us
                </a>

                <a href="{{ route('about-us') }}" class="hover:underline ml-4">
                    About Us
                </a>
            </p>
        </div>
    </div>
</body>

</html>
