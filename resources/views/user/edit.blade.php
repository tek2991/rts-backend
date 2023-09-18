<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-12">
        <h2 class="text-xl font-regular pt-2 pb-4">User details</h2>
        <p class="text-sm text-red-500 mb-4">User details cannot be edited.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full" type="text" disabled value="{{ $user->name }}" />
            </div>
            <div>
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" disabled value="{{ $user->email }}" />
            </div>
            <div>
                <x-label for="mobile" :value="__('Mobile')" />
                <x-input id="mobile" class="block mt-1 w-full" type="text" disabled value="{{ $user->mobile_number }}" />
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mb-12">
        <h2 class="text-xl font-regular pt-2 pb-4">Reset user Password</h2>
        <p class="text-sm text-blue-500 mb-4">
            Reset to default password <span class="font-semibold">Password@ddmmyyyy</span>
        </p>
        <form action="{{ route('user.resetPassword', $user) }}" method="post">
            @csrf
            @method('PUT')
            <x-validation-errors class="mb-4" />
            <div class="grid grid-cols-1 md:w-1/2 gap-6">
                {{-- Confirm checkbox --}}
                <div class="flex items-center">
                    <x-input id="confirm" class="block" type="checkbox" required name="confirm" value="1" />
                    <x-label for="confirm" class="pl-2" :value="__('Confirm')" />
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </div>


    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        <span class="flex justify-between items-center mt-2 mb-4">
            <h2 class="text-xl font-regular">Assigned User Roles</h2>
            <button
                onclick="Livewire.emit('openModal', 'attach-modal', {{ json_encode(['route' => 'user.attachRole', 'model_id' => $user->id, 'model_name' => 'User', 'attaching_model_name' => 'Role']) }})"
                class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add Role</span>
            </button>
        </span>
        <livewire:users-roles-table :user="$user" />
    </div>
</x-app-layout>
