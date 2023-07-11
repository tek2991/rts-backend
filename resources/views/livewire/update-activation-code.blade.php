<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
    <h2 class="text-xl font-regular pt-2 pb-4">Activation Code details</h2>
    <x-validation-errors class="mb-4" />
        <div class="grid grid-cols-1 md:w-1/2 gap-6">
            {{-- Code --}}
            <div>
                <x-label for="code" :value="__('Activation Code')" />
                <x-input id="code" class="block mt-1 w-full" type="text" required name="code"
                    wire:model="state.code" />
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
            {{-- Expires at --}}
            <div>
                <x-label for="expires_at" :value="__('Expires At')" />
                <x-input id="expires_at" class="block mt-1 w-full" type="date" required name="expires_at"
                    wire:model="state.expires_at" />
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <x-button class="ml-4" wire:click="save">
                {{ __('Save') }}
            </x-button>
        </div>
</div>
