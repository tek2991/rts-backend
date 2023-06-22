<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h2 class="text-xl font-regular pt-2 pb-4">Role details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" readonly
                            value="{{ $role->name }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <span class="flex justify-between items-center mt-2 mb-4">
                    <h2 class="text-xl font-regular">Assigned Permissions</h2>
                    <button onclick="Livewire.emit('openModal', 'attach-modal', {{ json_encode(['route' => 'role.attachPermission', 'model_id' => $role->id, 'model_name' => 'Role', 'attaching_model_name' => 'Permission']) }})"
                        class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Add Permission</span>
                    </button>
                </span>
                <livewire:roles-permissions-table :role="$role" />
            </div>
        </div>
    </div>
</x-app-layout>
