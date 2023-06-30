<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit package') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-12">
        <h2 class="text-xl font-regular pt-2 pb-4">Package details</h2>
        <x-validation-errors class="mb-4" />
        <form action="{{ route('package.update', $package) }}" method="post">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-label for="name" :value="__('Package Name')" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                        value="{{ $package->name }}" />
                </div>

                <div>
                    <x-label for="duration" :value="__('Duration (In Days)')" />
                    <x-input id="duration" class="block mt-1 w-full" type="number" required name="duration"
                        value="{{ $package->duration_in_days }}" />
                </div>

                <div>
                    <x-label for="price" :value="__('Price (₹)')" />
                    <x-input id="price" class="block mt-1 w-full" type="number" required name="price"
                        value="{{ $package->price }}" />
                </div>

                <div>
                    <x-label for="status" :value="__('Status')" />
                    <select name="is_active" id="status" class="block mt-1 w-full">
                        <option value="1" {{ $package->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$package->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>
            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
