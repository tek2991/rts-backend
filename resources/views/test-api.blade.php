<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test API') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                {{-- Send notification form --}}
                <form action="{{ route('send-notification') }}" method="POST">
                    @csrf
                    {{-- divice token --}}
                    <div class="mb-4">
                        <label for="device_token" class="sr-only">Device Token</label>
                        <input type="text" name="device_token" id="device_token" placeholder="Device Token" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('device_token') border-red-500 @enderror" value="{{ old('device_token') }}">

                        @error('device_token')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="sr-only">Title</label>
                        <input type="text" name="title" id="title" placeholder="Title" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('title') border-red-500 @enderror" value="{{ old('title') }}">

                        @error('title')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Body --}}
                    <div class="mb-4">
                        <label for="body" class="sr-only">Body</label>
                        <textarea name="body" id="body" cols="30" rows="4" placeholder="Body" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>

                        @error('body')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- Action to --}}
                    <div class="mb-4">
                        <label for="action_to" class="sr-only">Action To</label>
                        <input type="text" name="action_to" id="action_to" placeholder="Action To" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('action_to') border-red-500 @enderror" value="{{ old('action_to') }}">

                        @error('action_to')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white rounded-md px-4 py-1.5">Send</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
