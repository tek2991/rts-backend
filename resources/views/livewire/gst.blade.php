<div>
    <div class="grid grid-cols-1 md:w-1/2 gap-6">
        {{-- CGST --}}
        <div>
            <x-label for="cgst" :value="__('CGST %')" />
            <x-input id="cgst" class="block mt-1 w-full" type="text" required name="cgst" wire:model="cgst_rate" />
            @error('cgst_rate')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        {{-- SGST --}}
        <div>
            <x-label for="sgst" :value="__('SGST %')" />
            <x-input id="sgst" class="block mt-1 w-full" type="text" required name="sgst" wire:model="sgst_rate" />
            @error('sgst_rate')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="flex justify-end mt-4">
        {{-- Success --}}
        @if ($success)
            <div class="text-green-500">
                {{ $success }}
            </div>
        @endif
        <x-button class="ml-4" type="button" wire:click="save">
            {{ __('Save') }}
        </x-button>
    </div>
</div>
