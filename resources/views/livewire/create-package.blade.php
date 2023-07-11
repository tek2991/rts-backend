<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
    <h2 class="text-xl font-regular pt-2 pb-4">Package details</h2>
    <x-validation-errors class="mb-4" />
    <div class="grid grid-cols-1 md:w-1/2 gap-6">
        {{-- Name --}}
        <div>
            <x-label for="name" :value="__('Package Name')" />
            <x-input id="name" class="block mt-1 w-full" type="text" required name="name"
                wire:model="state.name" />
        </div>
        {{-- Duration --}}
        <div>
            <x-label for="duration" :value="__('Duration (In Days)')" />
            <x-input id="duration" class="block mt-1 w-full" type="number" required name="duration"
                wire:model="state.duration" />
        </div>
        {{-- Net amount --}}
        <div>
            <x-label for="net_amount" :value="__('Net Amount (₹)')" />
            <x-input id="net_amount" class="block mt-1 w-full" type="number" required name="net_amount"
                wire:model="state.net_amount" />
        </div>
        {{-- Tax --}}
        <div>
            <x-label for="tax"> Tax ({{ $cgst + $sgst }}%) GST</x-label>
            <x-input id="tax" class="block mt-1 w-full" type="number" required name="tax"
                wire:model="state.tax" readonly />
        </div>
        {{-- Price --}}
        <div>
            <x-label for="price" :value="__('Price (₹)')" />
            <x-input id="price" class="block mt-1 w-full" type="number" required name="price"
                wire:model="state.price" />
        </div>
        {{-- Status --}}
        <div>
            <x-label for="status" :value="__('Status')" />
            <select name="is_active" id="status" class="block mt-1 w-full" wire:model="state.is_active">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
    </div>
    <div class="flex justify-end mt-4">
        <x-button class="ml-4" wire:click="save">
            {{ __('Save') }}
        </x-button>
    </div>
</div>
