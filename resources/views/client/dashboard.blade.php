<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-0">
        <div class="grid grid-cols-4 md:grid-cols-5 gap-6 sm:gap-12 p-4 sm:p-0 sm:mt-12">

            {{-- Message --}}
            <div>
                <a href="{{ route('client.message') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-3 hover:p-2 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/sms-svgrepo-com.svg') }}" alt="SMS Logo">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Message
                    </p>
                </a>
            </div>

            {{-- Contacts --}}
            <div>
                <a href="{{ route('client.contact') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/phone-book-svgrepo-com.svg') }}" alt="Contacts Logo" class="pr-1">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Contacts
                    </p>
                </a>
            </div>

            {{-- Call Log --}}
            <div>
                <a href="{{ route('client.call-log') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/phone-call-telephone-svgrepo-com.svg') }}" alt="Call Log Logo">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Call Log
                    </p>
                </a>
            </div>

            {{-- Find Phone --}}
            <div>
                <a href="{{ route('client.locate-phone') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/map-marker-svgrepo-com.svg') }}" alt="Find Phone Logo">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Find Phone
                    </p>
                </a>
            </div>

            {{-- Camera --}}
            <div>
                <a href="{{ route('client.camera') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/photo-camera-svgrepo-com.svg') }}" alt="Camera Logo">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Camera
                    </p>
                </a>
            </div>

            {{-- Recording --}}
            <div>
                <a href="{{ route('client.voice-recorder') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/microphone-svgrepo-com.svg') }}" alt="Camera Logo">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Voice Recorder
                    </p>
                </a>
            </div>

            {{-- Video Recording --}}
            <div>
                <a href="{{ route('client.video-recorder') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/video-frame-play-vertical-svgrepo-com.svg') }}" alt="Video Recording Logo">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Video Recorder
                    </p>
                </a>
            </div>


            {{-- Start Service --}}
            <div>
                <a href="{{ route('client.start-service') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/gear-svgrepo-com.svg') }}" alt="Control">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Start Service
                    </p>
                </a>
            </div>

            {{-- Text to Speach --}}
            <div>
                <a href="{{ route('client.text-to-speech') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/text-to-speech-svgrepo-com.svg') }}" alt="Control">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Text to Speech
                    </p>
                </a>
            </div>

            {{-- Lock / Unlock Device --}}
            <div>
                <a href="{{ route('client.lock-unlock') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/shield-minimalistic-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Lock Device
                    </p>
                </a>
            </div>

            {{-- Lost SMS --}}
            <div>
                <a href="{{ route('client.lost-sms') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/smartphone-sms-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Lost Message
                    </p>
                </a>
            </div>

            {{-- Fake Shutdown --}}
            <div>
                <a href="{{ route('client.fake-shutdown') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/power-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Fake Shutdown
                    </p>
                </a>
            </div>

            {{-- Alert Device --}}
            <div>
                <a href="{{ route('client.alert-device') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/notification-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Alert Device
                    </p>
                </a>
            </div>

            {{-- Screen Recorder --}}
            <div>
                <a href="{{ route('client.screen-recorder') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/screen-capture-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Screen Recorder
                    </p>
                </a>
            </div>

            {{-- Hide App --}}
            <div>
                <a href="{{ route('client.hide-app') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-3 hover:p-2 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/locked-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Hide App
                    </p>
                </a>
            </div>

            {{-- Vibrate --}}
            <div>
                <a href="{{ route('client.vibrate-phone') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/mobile-vibrate-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Vibrate
                    </p>
                </a>
            </div>

            {{-- My Files --}}
            <div>
                <a href="#" class="flex justify-center items-center flex-col" data-modal-target="popup-modal"
                    data-modal-toggle="popup-modal"z>
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/folder-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        My Files
                    </p>
                </a>
            </div>

            {{-- Screenshot --}}
            <div>
                <a href="#" class="flex justify-center items-center flex-col" data-modal-target="popup-modal"
                    data-modal-toggle="popup-modal"z>
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/screenshot-one-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Screenshot
                    </p>
                </a>
            </div>

            {{-- Remote Call --}}
            <div>
                <a href="#" class="flex justify-center items-center flex-col" data-modal-target="popup-modal"
                    data-modal-toggle="popup-modal"z>
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/phone-call-call-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Remote Call
                    </p>
                </a>
            </div>

            {{-- Screen Mirroring --}}
            <div>
                <a href="#" class="flex justify-center items-center flex-col" data-modal-target="popup-modal"
                    data-modal-toggle="popup-modal"z>
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/mirroring-screen-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Screen Mirroring
                    </p>
                </a>
            </div>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Upcoming feature, stay tuned!
                    </h3>
                    <button data-modal-hide="popup-modal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
