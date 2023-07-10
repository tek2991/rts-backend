<div>
    <form wire:submit.prevent="applyActivationCode">
        <div class="max-w-xs items-center mx-auto">
            {{-- Activation code --}}
            <div class="mt-4">
                <label for="activation_code"
                    class="mb-2 text-sm font-medium text-gray-900 dark:text-white flex justify-between">
                    <span>Activation Code</span>
                </label>
                <input type="text" id="activation_code" wire:model="activation_code"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-slate-100"
                    :disabled="{{ $activationCode }}" required>
                @error('activation_code')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror

                {{-- Apply activation --}}
                @if (!$activationCode)
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold text-xs py-1.5 px-2 rounded">Apply</button>
                    </div>
                @endif
            </div>

            @if ($activationCode)
                {{-- Value --}}
                <div class="mt-4">
                    <label for="price"
                        class="mb-2 text-sm font-medium text-gray-900 dark:text-white flex justify-between">
                        <span>Price</span>
                    </label>
                    <input type="text" id="price" value="Rs {{ $price }}/-"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-slate-100"
                        disabled>
                </div>

                {{-- Duratrion in days --}}
                <div class="mt-4">
                    <label for="duration_in_days"
                        class="mb-2 text-sm font-medium text-gray-900 dark:text-white flex justify-between">
                        <span>Duration in days</span>
                    </label>
                    <input type="text" id="duration_in_days" wire:model="duration_in_days"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-slate-100"
                        disabled>
                </div>
            @endif
        </div>

        {{-- Activate Button --}}
        <div class="max-w-xs items-center mx-auto">
            <div class="mt-4">
                <button type="button" wire:click="activate" @if (!$activationCode) disabled @endif
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded disabled:bg-gray-500">Activate</button>
            </div>
        </div>
    </form>
</div>
