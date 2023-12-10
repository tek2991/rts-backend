<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Activation Code') }}
            </h2>
        </div>
    </x-slot>


    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-8">
        <h1 class="text-2xl font-bold">
            {{ $activationCode->code }}
        </h1>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <h2 class="text-xl font-bold">
                    {{ __('Is Valid') }}
                </h2>
                <p>
                    {{ $activationCode->isValid() ? 'Yes' : 'No' }}
                </p>
            </div>

            <div>
                <h2 class="text-xl font-bold">
                    {{ __('Is Used') }}
                </h2>
                <p>
                    {{ $activationCode->isUsed() ? 'Yes' : 'No' }}
                </p>
            </div>

            {{-- If activation code is used --}}
            @if ($activationCode->isUsed())
                <div>
                    <h2 class="text-xl font-bold">
                        {{ __('Used By') }}
                    </h2>
                    <p>
                        Name: {{ $activationCode->user->name }}
                    </p>
                    <p>
                        Email: {{ $activationCode->user->email }}
                    </p>

                    <p>
                        Used At: {{ $activationCode->used_at }}
                    </p>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
