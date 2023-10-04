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


                <div class="relative overflow-x-auto shadow-lg sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Dealer name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Address
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealers as $dealer)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $dealer->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <a href="mailto:{{ $dealer->email }}" class="text-blue-500 hover:to-blue-600">
                                            {{ $dealer->email }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="tel:{{ $dealer->phone }}" class="text-blue-500 hover:to-blue-600">
                                            {{ $dealer->phone }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs">
                                        <p class="text-justify text">{{ $dealer->address }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center mt-8">
                    <p class="text-gray-500">No dealers found.</p>
                </div>
            @endif
        </div>
    @endif
</div>
