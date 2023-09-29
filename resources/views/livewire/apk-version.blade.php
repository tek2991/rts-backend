<div>
    <div class="grid grid-cols-1 md:w-1/2 gap-6">
        {{-- APK Version --}}
        <div>
            <x-label for="apkVersion" :value="__('APK Version')" />
            <x-input id="apkVersion" class="block mt-1 w-full" type="number" required name="apkVersion" wire:model="apkVersion" />
            @error('apkVersion')
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
