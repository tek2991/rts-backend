<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
    <h2 class="text-xl font-regular pt-2 pb-4">Package details</h2>
    <x-validation-errors class="mb-4" />
    <form action="{{ route('package.store') }}" method="post">
        @csrf
        <div class="grid grid-cols-1 md:w-1/2 gap-6">
            {{-- Name --}}
            <div>
                <x-label for="name" :value="__('Package Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" required name="name"
                    value="{{ old('name') }}" />
            </div>
            {{-- Duration --}}
            <div>
                <x-label for="duration" :value="__('Duration (In Days)')" />
                <x-input id="duration" class="block mt-1 w-full" type="number" required name="duration"
                    value="{{ old('duration') }}" />
            </div>
            {{-- Price --}}
            <div>
                <x-label for="price" :value="__('Price (₹)')" />
                <x-input id="price" class="block mt-1 w-full" type="number" required name="price"
                    value="{{ old('price') }}" />
            </div>
            {{-- Status --}}
            <div>
                <x-label for="status" :value="__('Status')" />
                <select name="is_active" id="status" class="block mt-1 w-full">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <x-button class="ml-4">
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</div>