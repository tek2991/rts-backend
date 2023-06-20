<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h2 class="text-xl font-regular pt-2 pb-4">User details</h2>
                <x-validation-errors class="mb-4" />
                <form action="{{ route('user.update', $user) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" disabled
                                value="{{ $user->name }}" />
                        </div>
                        <div>
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" disabled
                                value="{{ $user->email }}" />
                        </div>
                        <div>
                            <x-label for="office_id" :value="__('Office')" />
                            <x-input-select id="office_id" class="block mt-1 w-full" name="office_id">
                                <option value="">Select Office</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}"
                                        {{ $user->office_id == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}</option>
                                @endforeach
                            </x-input-select>
                        </div>
                        <div class="col-start-1">
                            <x-label for="office_id" :value="__('Manager of Offices:')" />
                            <ul class="list-disc pl-6 mt-2">
                                @if ($user->managerOfOffices->count() > 0)
                                    @foreach ($user->managerOfOffices as $office)
                                        <li class="text-sm">{{ $office->name }}</li>
                                    @endforeach
                                @else
                                    <li class="text-sm">No offices assigned</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
        </div>
    </div>
</x-app-layout>
