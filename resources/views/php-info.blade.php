<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PHP Info') }}
        </h2>
    </x-slot>

    <div>
        <?php phpinfo(); ?>
    </div>
</x-app-layout>
