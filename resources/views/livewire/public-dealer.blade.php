<div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        <h2 class="text-xl font-regular pt-2 pb-4">Search Dealers</h2>
        <div class="grid grid-cols-1 md:w-1/2 gap-6">
            {{-- State --}}
            <div>
                <x-label for="state" :value="__('Select State')" />
                <x-input-select id="state" wire:model="state_id">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </x-input-select>
            </div>

            {{-- District --}}
            <div>
                <x-label for="district" :value="__('Select District')" />
                <select name="district" id="district" wire:model="district_id"
                    {{ !$state_id || count($districts) < 1 ? 'disabled' : '' }}
                    class="w-full mt-1 border-gray-300 rounded-md p-2 focus:ring-0 focus:border-piss-yellow disabled:bg-gray-100">
                    <option value="">Select District</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <x-button class="ml-4" wire:click="search">
                {{ __('Search') }}
            </x-button>
        </div>
    </div>
    @if ($dealers != null)
        <div class="mt-8">
            @if (count($dealers) > 0)
                <h2 class="mb-3">
                    <span class="text-xl font-regular pt-2 pb-4">Dealers</span>
                    <span class="text-sm text-gray-500">({{ count($dealers) }})</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-8">
                    @foreach ($dealers as $dealer)
                        <div
                            class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $dealer->name }}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                {{ $dealer->address }}
                            </p>
                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                {{ $dealer->district->name }}, {{ $dealer->district->state->name }}
                            </p>
                            <p class="font-normal text-gray-700 dark:text-gray-400 mt-1">
                                <span class="font-normal text-gray-700 dark:text-gray-400">Phone: </span>
                                <a href="tel:{{ $dealer->phone }}"
                                    class="font-normal text-blue-500 hover:text-blue-600">
                                    {{ $dealer->phone }}
                                </a>
                            </p>
                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                <span class="font-normal text-gray-700 dark:text-gray-400">Email: </span>
                                <a href="mailto:{{ $dealer->email }}"
                                    class="font-normal text-blue-500 hover:text-blue-600">
                                    {{ $dealer->email }}
                                </a>
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center mt-8">
                    <p class="text-gray-500">No dealers found.</p>
                </div>
            @endif
        </div>
    @endif
</div>
