<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-4">
        <div class="grid grid-cols-4 md:grid-cols-5 gap-6 sm:gap-12 p-4 sm:p-0">

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

            {{-- Start /Stop Alarm --}}
            <div>
                <a href="{{ route('client.alarm') }}" class="flex justify-center items-center flex-col">
                    <div
                        class="bg-white shadow-sm rounded-3xl w-16 sm:w-20 aspect-square p-2 hover:p-1 hover:shadow-md transition-all">
                        <img src="{{ asset('icons/alarm-clock-svgrepo-com.svg') }}" alt="Lock Unlock">
                    </div>
                    <p class="sm:text-lg text-center leading-none font-semibold text-gray-700 dark:text-gray-200 pt-2">
                        Alarm
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


        </div>
    </div>
</x-app-layout>
