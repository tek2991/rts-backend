<x-app-alternate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Packages') }}
        </h2>
    </x-slot>

    <section class="bg-white dark:bg-gray-900 mt-8">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                    Pricing Plans
                </h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    Here are our pricing plans. Choose the one that fits your needs the best.
                </p>
            </div>
            <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                @foreach ($packages as $package)
                    <!-- Pricing Card -->
                    <div
                        class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                        <h3 class="mb-4 text-2xl font-semibold">{{ $package->name }}</h3>
                        <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Best option for personal use &
                            for
                            your next project.</p>
                        <div class="flex justify-center items-baseline my-8">
                            <span class="mr-2 text-5xl font-extrabold">Rs {{ $package->price }}/-</span>
                        </div>
                        <!-- List -->
                        <ul role="list" class="mb-8 space-y-4 text-left">
                            <li class="flex items-center space-x-3">
                                <!-- Icon -->
                                <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Validity: <span class="font-semibold">{{ $package->duration_in_days }}
                                        days</span></span>
                            </li>
                        </ul>
                        <a href="{{ route('public.package.show', $package->id) }}"
                            class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition">Get
                            started</a>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Link to Activation Code --}}
        {{-- <div class="p-6">
            <span class="text-lg">
                Have an activation code? &nbsp;
                <a href="{{ route('client.activation-code.start') }}" class="text-green-500 hover:text-green-600 hover:underline transition">
                    Click here to activate your account.    
                </a>
            </span>
        </div> --}}
    </section>
</x-app-alternate-layout>
