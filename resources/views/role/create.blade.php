<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h2 class="text-xl font-regular pt-2 pb-4">Role details</h2>
                <x-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:w-1/2 gap-6">
                        <div>
                            <x-label for="name" :value="__('Name')" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                value="{{ old('name') }}" />
                        </div>
                        <div>
                            <x-label for="permission_ids" :value="__('Permissions')" />
                            <x-input-select id="permission_ids" name="permission_ids[]" multiple>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </x-input-select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Create') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
