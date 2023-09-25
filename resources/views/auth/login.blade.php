<x-guest-layout>
    @livewireStyles
    
    @livewire('auth.login')

    @stack('modals')
    @livewireScripts
    @livewire('livewire-ui-modal')
</x-guest-layout>
