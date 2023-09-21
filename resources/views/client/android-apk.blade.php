<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Download APK') }}
        </h2>
    </x-slot>

    <div class="overflow-hidden py-4 px-2 mt-8 rounded-lg bg-white ">
        <h1 class="text-2xl font-semibold text-gray-800 leading-tight mb-8 text-center">
            How to install the App
        </h1>

        <div class="mb-14">
            <ul class="text-center">
                <li class="my-2">
                    <div class="text-lg font-semibold text-gray-800 leading-tight">
                        Step 1:
                    </div>
                    <div class="flex justify-center items-center mt-2">
                        <a href="{{ config('services.apk.url') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500">Download
                            APK</a>
                    </div>
                </li>
                <li class="my-2">
                    <div class="text-lg font-semibold text-gray-800 leading-tight">
                        Step 2:
                    </div>
                    <span class="text-gray-700">
                        Open the APK file to start the installation.
                    </span>
                </li>
                <li class="my-2">
                    <div class="text-lg font-semibold text-gray-800 leading-tight">
                        Step 3:
                    </div>
                    <span class="text-gray-700">
                        You may need to enable unknown sources on your device.
                    </span>
                </li>
                <li class="my-2">
                    <div class="text-lg font-semibold text-gray-800 leading-tight">
                        Step 4:
                    </div>
                    <span class="text-gray-700">
                        You may get a warning about Play Protect. You can safely ignore this warning.
                    </span>
                </li>
            </ul>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="w-full flex flex-col justify-between items-center">
                <p class="pb-4 text-gray-700">
                    <span class="text-2xl font-semibold text-gray-800 leading-tight text-center">
                        Enable unknown sources
                    </span>
                </p>
                <img src="{{ asset('imgs/unknown-sources-enable.png') }}" alt="Enable unknown sources"
                    class="mx-auto mb-4 rounded-lg shadow-lg">
                <p class="my-2 max-w-xs text-justify">
                    You may need to enable unknown sources on your device. The exact steps may vary depending on your
                    device.
                </p>
            </div>

            <div class="w-full flex flex-col justify-between items-center">
                <p class="pb-4 text-gray-700">
                    <span class="text-2xl font-semibold text-gray-800 leading-tight text-center">
                        Play Protect warning
                    </span>
                </p>
                <img src="{{ asset('imgs/play-protect-warning.png') }}" alt="Enable unknown sources"
                    class="mx-auto mb-4 rounded-lg shadow-lg">
                <p class="my-2 max-w-xs text-justify">
                    You may get a warning about Play Protect. You can safely ignore this warning.
                </p>
            </div>
        </div>

        <div class="mb-8">
            <p class="text-2xl font-semibold text-gray-800 leading-tight text-center mt-8">
                Download the APK
            </p>
            <div class="flex justify-center items-center mt-4">
                <a href="{{ config('services.apk.url') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-500">Download
                    APK</a>
            </div>
        </div>
    </div>
</x-app-layout>
