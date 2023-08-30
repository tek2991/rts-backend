<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dealer') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-12">
        <h2 class="text-xl font-regular pt-2 pb-4">Dealer details</h2>
        <form action="{{ route('dealer.update', $dealer) }}" method="post">
            @method('PUT')
            @csrf
            <div class="grid grid-cols-1 md:w-1/2 gap-6">
                {{-- District --}}
                <div>
                    <x-label for="district" :value="__('District')" />
                    <x-input-select id="district" class="block mt-1 w-full" required name="district_id">
                        <option value="">Select District</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ $district->id == $dealer->district_id ? 'selected' : '' }}>{{ $district->name }}
                            </option>
                        @endforeach
                    </x-input-select>
                </div>
                {{-- Name --}}
                <div>
                    <x-label for="name" :value="__('Name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" required name="name"
                        value="{{ $dealer->name }}" />
                </div>

                {{-- Email --}}
                <div>
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" class="block mt-1 w-full" type="email" required name="email"
                        value="{{ $dealer->email }}" />
                </div>

                {{-- Mobile --}}
                <div>
                    <x-label for="phone" :value="__('Mobile')" />
                    <x-input id="phone" class="block mt-1 w-full" type="text" required name="phone"
                        value="{{ $dealer->phone }}" />
                </div>

                {{-- Address --}}
                <div>
                    <x-label for="address" :value="__('Address')" />
                    <x-text-area id="address" class="block mt-1 w-full" required name="address">
                        {{ $dealer->address }} </x-text-area>
                </div>

                {{-- Is Active --}}
                <div>
                    <x-label for="is_active" :value="__('Is Active')" />
                    <x-input-select id="is_active" class="block mt-1 w-full" required name="is_active">
                        <option value="1" {{ $dealer->is_active == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $dealer->is_active == 0 ? 'selected' : '' }}>No</option>
                    </x-input-select>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
